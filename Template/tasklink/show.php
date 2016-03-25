<?php if (!empty($links['is a milestone of'])): ?>
<?= $this->render('milestone/show', array(
    'task' => $task,
    'milestone' => $links['is a milestone of'],
    'project' => $project,
    'link_label_list' => isset($link_label_list) ? $link_label_list : array(),
    'editable' => $editable,
    'is_public' => $is_public,
)) ?>
<?php unset($links['is a milestone of']); ?>
<?php endif ?>

<?= $this->render('kanboard:tasklink/show', array(
    'task' => $task,
    'links' => $links,
    'project' => $project,
    'link_label_list' => isset($link_label_list) ? $link_label_list : array(),
    'editable' => $editable,
    'is_public' => $is_public,
)) ?>
