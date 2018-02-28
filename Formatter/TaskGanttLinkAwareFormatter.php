<?php

namespace Kanboard\Plugin\Milestone\Formatter;

use Kanboard\Plugin\Gantt\Formatter\TaskGanttFormatter;

/**
 * Task Gantt Formatter ware of internal links between tasks
 *
 * @package formatter
 * @author  Olivier Maridat
 */
class TaskGanttLinkAwareFormatter extends TaskGanttFormatter
{
    /**
     * Local cache for project columns
     *
     * @access private
     * @var array
     */
    private $columns = array();
    private $known_start_dates = array();
    private $known_due_dates = array();

    /**
     * Apply formatter
     *
     * @access public
     * @return array
     */
    public function format()
    {
        $bars = array();

        // Depending of the task order, two loops are required
        foreach ($this->query->findAll() as $task) {
            $this->formatTaskUsingLinks($task);
        }
        foreach ($this->query->findAll() as $task) {
            $bars[] = $this->formatTaskUsingLinks($task);
        }

        return $bars;
    }

    /**
     * Format a single task
     *
     * @access private
     * @param  array  $task
     * @return array
     */
    private function formatTaskUsingLinks(array $task)
    {
        if (! isset($this->columns[$task['project_id']])) {
            $this->columns[$task['project_id']] = $this->columnModel->getList($task['project_id']);
        }

	$start = $task['date_started'] ?: time();
        $end = $task['date_completed'] ?: ($task['date_due'] ?: $start);

        if ((empty($task['date_completed']) && empty($task['date_due'])) || empty($task['date_started'])) {
            // Follow target milestone start/due dates
            list($dates_started, $dates_due) = $this->taskLinkExtModel->getAllDates($task['id'], 8, $this->known_start_dates, $this->known_due_dates);
            if (empty($task['date_started']) && !empty($dates_started)) {
                $start = max($start, min($dates_started));
            }
            if (empty($task['date_completed']) && empty($task['date_due']) && !empty($dates_due)) {
                $end = min($dates_due);
            }
            // Start after any blocking tasks
            if (empty($task['date_started'])) {
                list($dates_started, $dates_due) = $this->taskLinkExtModel->getAllDates($task['id'], 3, $this->known_start_dates, $this->known_due_dates);
                if (!empty($dates_due)) {
                    $start = max(array_merge(array($start), $dates_due));
                }
            }
            $this->known_start_dates[$task['id']] = $start;
            $this->known_due_dates[$task['id']] = $end;
        }

        return array(
            'type' => 'task',
            'id' => $task['id'],
            'title' => $task['title'],
            'start' => array(
                (int) date('Y', $start),
                (int) date('n', $start),
                (int) date('j', $start),
            ),
            'end' => array(
                (int) date('Y', $end),
                (int) date('n', $end),
                (int) date('j', $end),
            ),
            'column_title' => $task['column_name'],
            'assignee' => $task['assignee_name'] ?: $task['assignee_username'],
            'progress' => $this->taskModel->getProgress($task, $this->columns[$task['project_id']]).'%',
            'link' => $this->helper->url->href('TaskViewController', 'show', array('project_id' => $task['project_id'], 'task_id' => $task['id'])),
            'color' => $this->colorModel->getColorProperties($task['color_id']),
            'not_defined' => empty($task['date_due']) || empty($task['date_started']),
            'date_started_not_defined' => empty($task['date_started']),
            'date_due_not_defined' => empty($task['date_completed']) && empty($task['date_due']),
        );
    }
}
