<?php if (isset($task['link_id'])): ?>
<li>
    <?= $this->modal->medium('edit', t('Edit the internal link'), 'TaskInternalLinkController', 'edit', array('link_id' => $task['link_id'], 'task_id' => $task['id'], 'project_id' => $task['project_id'])) ?>
</li>
<?php endif ?>
