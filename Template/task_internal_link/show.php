<?php if (!empty($links['is a milestone of']) || isset($link_label_list) && isset($link_label_list[9]) && !empty($links[$link_label_list[9]])): ?>
<?= $this->render('milestone/show', array(
    'milestone' => !empty($links['is a milestone of']) ? $links['is a milestone of']: $links[$link_label_list[9]],
    'task' => $task,
    'project' => $project,
    'editable' => $editable,
    'is_public' => $is_public,
    'link_label_list' => isset($link_label_list) ? $link_label_list : array(),
)) ?>
<?php unset($links['is a milestone of']); ?>
<?php if (isset($link_label_list) && isset($link_label_list[9])): unset($links[$link_label_list[9]]); endif ?>
<?php endif ?>

<?= $this->render('kanboard:task_internal_link/show', array(
    'links' => $links,
    'task' => $task,
    'project' => $project,
    'editable' => $editable,
    'is_public' => $is_public,
    'link_label_list' => isset($link_label_list) ? $link_label_list : array(),
)) ?>
