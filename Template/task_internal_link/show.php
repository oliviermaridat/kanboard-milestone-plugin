<?php if (!empty($links['is a milestone of'])): ?>
<?= $this->render('milestone/show', array(
    'milestone' => $links['is a milestone of'],
    'task' => $task,
    'project' => $project,
    'editable' => $editable,
    'is_public' => $is_public,
    'link_label_list' => isset($link_label_list) ? $link_label_list : array(),
)) ?>
<?php unset($links['is a milestone of']); ?>
<?php endif ?>

<?= $this->render('kanboard:task_internal_link/show', array(
    'links' => $links,
    'task' => $task,
    'project' => $project,
    'editable' => $editable,
    'is_public' => $is_public,
    'link_label_list' => isset($link_label_list) ? $link_label_list : array(),
)) ?>
