<section class="accordion-section <?= empty($milestone) ? 'accordion-collapsed' : '' ?>">
    <div class="accordion-title">
        <h3><a href="#" class="fa accordion-toggle"></a> <?= t('Milestone') ?></h3>
    </div>
    <div class="accordion-content">
    <div id="milestone">
        <?= $this->render('milestone/table', array(
            'milestone' => $milestone,
            'task' => $task,
            'project' => $project,
            'editable' => $editable,
            'is_public' => $is_public,
        )) ?>
    </div>
</section>
