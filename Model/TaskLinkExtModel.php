<?php

namespace Kanboard\Plugin\Milestone\Model;

use Kanboard\Core\Base;
use Kanboard\Model\ColumnModel;
use Kanboard\Model\LinkModel;
use Kanboard\Model\ProjectModel;
use Kanboard\Model\TaskModel;
use Kanboard\Model\UserModel;

class TaskLinkExtModel extends Base
{
  /**
   * SQL table name
   *
   * @var string
   */
  const TABLE = 'task_has_links';

  /**
   * Get all links attached to a task
   *
   * @access public
   * @param  integer   $task_id   Task id
   * @param  array     $link_ids  Filter on one or several link ids (default: no filter)
   * @return array
   */
  public function getAll($task_id, $link_ids=NULL)
  {
      $query = $this->db
                  ->table(self::TABLE)
                  ->columns(
                      self::TABLE.'.id',
                      self::TABLE.'.opposite_task_id AS task_id',
                      LinkModel::TABLE.'.label',
                      TaskModel::TABLE.'.title',
                      TaskModel::TABLE.'.is_active',
                      TaskModel::TABLE.'.project_id',
                      TaskModel::TABLE.'.column_id',
                      TaskModel::TABLE.'.color_id',
                      TaskModel::TABLE.'.date_completed',
                      TaskModel::TABLE.'.date_started',
                      TaskModel::TABLE.'.date_due',
                      TaskModel::TABLE.'.time_spent AS task_time_spent',
                      TaskModel::TABLE.'.time_estimated AS task_time_estimated',
                      TaskModel::TABLE.'.owner_id AS task_assignee_id',
                      UserModel::TABLE.'.username AS task_assignee_username',
                      UserModel::TABLE.'.name AS task_assignee_name',
                      ColumnModel::TABLE.'.title AS column_title',
                      ProjectModel::TABLE.'.name AS project_name'
                  )
                  ->eq(self::TABLE.'.task_id', $task_id)
                  ->join(LinkModel::TABLE, 'id', 'link_id')
                  ->join(TaskModel::TABLE, 'id', 'opposite_task_id')
                  ->join(ColumnModel::TABLE, 'id', 'column_id', TaskModel::TABLE)
                  ->join(UserModel::TABLE, 'id', 'owner_id', TaskModel::TABLE)
                  ->join(ProjectModel::TABLE, 'id', 'project_id', TaskModel::TABLE)
                  ->asc(LinkModel::TABLE.'.id')
                  ->desc(ColumnModel::TABLE.'.position')
                  ->desc(TaskModel::TABLE.'.is_active')
                  ->asc(TaskModel::TABLE.'.position')
		  ->asc(TaskModel::TABLE.'.id');
      if (NULL != $link_ids && is_array($link_ids) && !empty($link_ids)) {
          $query->in(self::TABLE.'.link_id', $link_ids);
      }
      return $query->findAll();
  }

  /**
   * Get all links started and due dates attached to the given task
   *
   * @access public
   * @param  integer   $task_id   Task id
   * @param  integer   $link_id   Filter on a link id (default: no filter)
   * @param  array     $know_start_dates   Already known start dates
   * @param  array     $know_due_dates     Already known due dates
   * @return array     Two arrays containing non empty started dates, and non empty due dates
   */
  public function getAllDates($task_id, $link_id, $know_start_dates, $know_due_dates)
  {
      $links = $this->getAll($task_id, array($link_id));
      $dates_started = array();
      $dates_due = array();
      foreach($links as $link) {
	  // Existing or known start date
          if (!empty($link['date_started'])) {
              $dates_started[] = $link['date_started'];
          }
          else if (isset($know_start_dates[$link['task_id']])) {
              $dates_started[] = $know_start_dates[$link['task_id']];
	  }
	  // Existing completed or due date, or known due date
          if (!empty($link['date_completed'])) {
              $dates_due[] = $link['date_completed'];
          }
	  else if (!empty($link['date_due'])) {
              $dates_due[] = $link['date_due'];
          }
          else if (isset($know_due_dates[$link['task_id']])) {
              $dates_due[] = $know_due_dates[$link['task_id']];
          }
      }
      return array($dates_started, $dates_due);
  }
}
