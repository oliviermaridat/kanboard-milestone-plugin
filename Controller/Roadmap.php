<?php
namespace Kanboard\Plugin\Milestone\Controller;

use Kanboard\Controller\Base;
use Kanboard\Model\Link;
use Kanboard\Model\Column;
use Kanboard\Model\Task;
use Kanboard\Model\TaskLink;
use Kanboard\Model\Project;
use Kanboard\Model\User;

/**
 * Roadmap
 *
 * @package controller
 * @author  Olivier Maridat
 */
class Roadmap extends Base
{
    /**
     * Roadmap index page
     *
     * @access public
     */
    public function index()
    {
        $project = $this->getProject();
	$milestones = $this->db
                    ->table(TaskLink::TABLE)
                    ->columns(
                        TaskLink::TABLE.'.id',
                        TaskLink::TABLE.'.task_id',
                        Link::TABLE.'.label',
                        Task::TABLE.'.title',
                        Task::TABLE.'.is_active',
                        Task::TABLE.'.project_id',
                        Task::TABLE.'.column_id',
                        Task::TABLE.'.color_id',
                        Task::TABLE.'.time_spent AS task_time_spent',
                        Task::TABLE.'.time_estimated AS task_time_estimated',
                        Task::TABLE.'.owner_id AS task_assignee_id',
                        User::TABLE.'.username AS task_assignee_username',
                        User::TABLE.'.name AS task_assignee_name',
                        Column::TABLE.'.title AS column_title',
                        Project::TABLE.'.name AS project_name',
			'COUNT('.TaskLink::TABLE.'.task_id) AS subtask'
                    )
                    ->eq(Link::TABLE.'.label', 'is a milestone of')
                    ->eq(Task::TABLE.'.project_id', $project['id'])
		    ->join(Link::TABLE, 'id', 'link_id')
                    ->join(Task::TABLE, 'id', 'task_id')
                    ->join(Column::TABLE, 'id', 'column_id', Task::TABLE)
                    ->join(User::TABLE, 'id', 'owner_id', Task::TABLE)
                    ->join(Project::TABLE, 'id', 'project_id', Task::TABLE)
                    ->asc(Link::TABLE.'.id')
                    ->desc(Column::TABLE.'.position')
                    ->desc(Task::TABLE.'.is_active')
                    ->asc(Task::TABLE.'.position')
                    ->asc(Task::TABLE.'.id')
		    ->groupBy(TaskLink::TABLE.'.task_id')
                    ->findAll();
        $this->response->html($this->helper->layout->project('milestone:roadmap/index', array(
            'milestones' => $milestones,
	    'project' => $project,
	    'editable' => true,
        )));
    }
}