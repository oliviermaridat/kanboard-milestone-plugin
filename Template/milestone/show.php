<section class="accordion-section <?= empty($milestone) ? 'accordion-collapsed' : '' ?>">
    <div class="accordion-title">
	<h3>
		<a href="#" class="fa accordion-toggle"></a> <?= t('Milestone') ?>
		<?= $this->modal->largeIcon('plus', 'Add a new task into this milestone', 'TaskInternalLinkController', 'create', array('task_id' => $task['id'], 'project_id' => $task['project_id'], 'link_id' => 9)) ?>
	</h3>
    </div>
    <div class="accordion-content">
        <?= $this->render('milestone/table', array(
            'milestone' => $milestone,
            'task' => $task,
            'project' => $project,
            'editable' => $editable,
            'is_public' => $is_public,
        )) ?>
    </div>
</section>
