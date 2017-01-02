<?php

namespace Kanboard\Plugin\Milestone\Model;

use Kanboard\Core\Base;
use Kanboard\Model\ColumnModel;
use Kanboard\Model\LinkModel;
use Kanboard\Model\ProjectModel;
use Kanboard\Model\TaskLinkModel;
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
   * @param  integer   $link_id   Filter on a link id (default: no filter)
   * @return array
   */
  public function getAll($task_id, $link_id=-1)
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
      if (-1 != $link_id) {
          $query->eq(self::TABLE.'.link_id', $link_id);
      }
      return $query->findAll();
  }

  /**
   * Get all links started and due dates attached to the given task
   *
   * @access public
   * @param  integer   $task_id   Task id
   * @param  integer   $link_id   Filter on a link id (default: no filter)
   * @return array     Two arrays containing non empty started dates, and non empty due dates
   */
  public function getAllDates($task_id, $link_id)
  {
      $links = $this->getAll($task_id, $link_id);
      $dates_started = array();
      $dates_due = array();
      foreach($links as $link) {
          if (!empty($link['date_started'])) {
              $dates_started[] = $link['date_started'];
          }
          if (!empty($link['date_due'])) {
              $dates_due[] = $link['date_due'];
          }
      }
      return array($dates_started, $dates_due);
  }
}
