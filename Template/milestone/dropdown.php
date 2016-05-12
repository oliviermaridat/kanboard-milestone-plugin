<?php if (isset($task['link_id'])): ?>
<li>
      <i class="fa fa-code-fork fa-fw"></i>
      <?= $this->url->link(t('Edit the internal link'), 'TaskInternalLink', 'edit', array('link_id' => $task['link_id'], 'task_id' => $task['id'], 'project_id' => $task['project_id']), false, 'popover') ?>
</li>
<?php endif ?>
