<?php if (! empty($milestone)): ?>
<table class="task-links-table table-stripped">
    <thead>
    <tr>
        <th class="column-45" colspan="2"><?= t('Title') ?></th>
        <th class="column-15"><?= t('Assignee') ?></th>
        <th><?= t('Time tracking') ?></th>
        <?php if ($editable): ?>
            <th class="column-5"></th>
        <?php endif ?>
    </tr>
    </thead>
    <tbody>
    <?php $total_progress = 0; ?>
    <?php $total_time_spent = 0; ?>
    <?php $total_time_estimated = 0; ?>
    <?php $total_time_spent_cumul = 0; ?>
    <?php foreach ($milestone as $link): ?>
        <?php $total_progress += $this->task->getProgress($link); ?>
        <?php $total_time_spent += $link['task_time_spent']; ?>
        <?php $total_time_estimated += $link['task_time_estimated']; ?>
        <?php $total_time_spent_cumul += min($link['task_time_spent'], $link['task_time_estimated']); ?>
        <tr>
            <td>
                <div class="task-board color-<?= $link['color_id'] ?>"
                     data-task-url="<?= $this->url->href('TaskViewController', 'show', array('task_id' => $link['task_id'], 'project_id' => $link['project_id'])) ?>">
                    <?php if ($editable): ?>
                        <div class="task-board-collapsed<?= ($link['is_active'] ? '' : ' task-link-closed') ?>">
                            <?= $this->render('task/dropdown', array('task' => array('id' => $link['task_id'], 'project_id' => $link['project_id'], 'is_active' => $link['is_active'], 'link_id' => $link['id']))) ?>
                            <?= $this->url->link(
                                $this->text->e($link['title']),
                                'TaskViewController',
                                'show',
                                array('task_id' => $link['task_id'], 'project_id' => $link['project_id']),
                                false,
                                'task-board-collapsed-title'
                            ) ?>
                        </div>
                   <?php else: ?>
                        <div class="task-board-collapsed<?= ($link['is_active'] ? '' : ' task-link-closed') ?>">
                            <?= $this->url->link(
                                $this->text->e('#'.$link['task_id'].' '.$link['title']),
                                'TaskViewController',
                                $is_public ? 'readonly' : 'show',
                                $is_public ? array('task_id' => $link['task_id'], 'token' => $project['token']) : array('task_id' => $link['task_id'], 'project_id' => $link['project_id']),
                                false,
                                'task-board-collapsed-title'
                            ) ?>
                        </div>
                    <?php endif ?>
                </div>
            </td>
            <td><?= $this->text->e($link['column_title']) ?></td>
            <td>
                <?php if (! empty($link['task_assignee_username'])): ?>
                    <?php if ($editable): ?>
                        <?= $this->url->link($this->text->e($link['task_assignee_name'] ?: $link['task_assignee_username']), 'UserViewController', 'show', array('user_id' => $link['task_assignee_id'])) ?>
                    <?php else: ?>
                        <?= $this->text->e($link['task_assignee_name'] ?: $link['task_assignee_username']) ?>
                    <?php endif ?>
                <?php endif ?>
            </td>
            <td>
                <?php if (! empty($link['task_time_spent'])): ?>
                    <strong><?= $this->text->e($link['task_time_spent']).'h' ?></strong> <?= t('spent') ?>
                <?php endif ?>

                <?php if (! empty($link['task_time_estimated'])): ?>
                    <strong><?= $this->text->e($link['task_time_estimated']).'h' ?></strong> <?= t('estimated') ?>
		<?php endif ?>

		<?php if (! empty($link['date_started']) || ! empty($link['date_due'])): ?>
			<?php if (! empty($link['date_started'])): ?>
			        <span title="<?= t('Start date') ?>" class="task-date">
			            <i class="fa fa-clock-o"></i>
			            <?= $this->dt->date($link['date_started']) ?>
			        </span>
			<?php endif ?>

		        <?php if (! empty($link['date_due'])): ?>
	        		<span title="<?= t('Due date') ?>" class="task-date
					<?php if (time() > $link['date_due']): ?>
			                     task-date-overdue
					<?php elseif (date('Y-m-d') == date('Y-m-d', $link['date_due'])): ?>
					     task-date-today
					<?php endif ?>
					">
					<i class="fa fa-calendar"></i>
					<?= $this->dt->datetime($link['date_due']) ?>
				</span>
			<?php endif ?>
		<?php endif ?>
            </td>
            <?php if ($editable): ?>
            <td>
                <div class="dropdown">
                <a href="#" class="dropdown-menu dropdown-menu-link-icon"><i class="fa fa-cog fa-fw"></i><i class="fa fa-caret-down"></i></a>
                <ul>
                    <li>
                        <?= $this->modal->medium('edit', t('Edit'), 'TaskInternalLinkController', 'edit', array('link_id' => $link['id'], 'task_id' => $task['id'], 'project_id' => $task['project_id'])) ?>
                    </li>
                    <li>
                        <?= $this->modal->medium('trash-o', t('Remove'), 'TaskInternalLinkController', 'confirm', array('link_id' => $link['id'], 'task_id' => $task['id'], 'project_id' => $task['project_id'])) ?>
                    </li>
                </ul>
                </div>
            </td>
            <?php endif ?>
        </tr>
    <?php endforeach ?>
    </tbody>
    <tfoot>
    <tr>
        <th colspan="3" class="total"><?= t('Total progress') ?></th>
        <td<?php if ($editable): ?> colspan="2"<?php endif ?>>
            <div class="progress-bar">
                <?php $percentage = (!$total_progress ? 0 : round($total_progress/count($milestone))); ?>
                <div class="task-board progress color-<?= $task['color_id'] ?>" style="width:<?= min(99, $percentage) ?>%;">
                    &#160;<?= $percentage ?>%
                </div>
            </div>
        </td>
    </tr>
    <?php if (! empty($total_time_spent) || ! empty($total_time_estimated)): ?>
    <tr>
        <th colspan="3" class="total"><?= t('Total time tracking') ?></th>
        <td<?php if ($editable): ?> colspan="2"<?php endif ?>>
            <?php if (! empty($total_time_spent)): ?>
                <strong><?= $this->text->e($total_time_spent).'h' ?></strong> <?= t('spent') ?>
            <?php endif ?>

            <?php if (! empty($total_time_estimated)): ?>
                <strong><?= $this->text->e($total_time_estimated).'h' ?></strong> <?= t('estimated') ?>
            <?php endif ?>

            <?php if (! empty($total_time_spent) && ! empty($total_time_estimated)): ?>
                <strong><?= $this->text->e($total_time_estimated-$total_time_spent).'h' ?></strong> <?= t('remaining') ?>
            <?php endif ?>

            <div class="progress-bar">
                <?php $percentage = (!$total_time_estimated ? 0 : round($total_time_spent_cumul/$total_time_estimated*100.0)); ?>
                <div class="task-board progress color-<?= $task['color_id'] ?>" style="width:<?= min(99, $percentage) ?>%;">
                    &#160;<?= $percentage ?>%
                </div>
            </div>
        </td>
    </tr>
    </tfoot>
    <?php endif ?>
</table>
<?php endif ?>
