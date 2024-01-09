<h3>Пользователи</h3>
<ul>
	<li><?=anchor('admin/users', 'Все пользователи');?></li>
	<?php if($this->user->admin) : ?>
	<li><?=anchor('admin/users_top_purchase', 'ТОП по оплатам');?></li>
	<li><?=anchor('admin/payments', 'Оплаты');?></li>
    <li><?=anchor('admin/payout', 'Выплаты');?></li>
    <li><?=anchor('admin/refunds', 'Возвраты');?></li>
	<?php endif; ?>
	<li>
		<?=anchor('admin/users_top', 'ТОП по выполнениям задач');?>
		<ul>
			<li><?=anchor('admin/users_top/'.TASK_VIEW, 'по просмотрам');?></li>
			<li><?=anchor('admin/users_top/'.TASK_LIKE, 'по лайкам');?></li>
			<li><?=anchor('admin/users_top/'.TASK_COMMENT, 'по комментам');?></li>
			<li><?=anchor('admin/users_top/'.TASK_SUBSCRIBE, 'по подпискам');?></li>
			<li><?=anchor('admin/users_top/'.TASK_GPSHARE, 'по G+');?></li>
		</ul>
	</li>
</ul>

<h3>Логи Cron</h3>
<ul>
	<li><?=anchor('admin/cron_log/subscribe', 'Штрафы по подпискам');?></li>
	<li><?=anchor('admin/cron_log/like', 'Штрафы по лайкам');?></li>
</ul>