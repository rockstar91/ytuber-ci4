<?= $this->extend('Shitcode/layout'); ?>

<?= $this->section('main') ?>

<div id="task_form_container">

    <?= \Config\Services::validation()->listErrors('list'); ?>


<?=form_open('web/task/add', array('id' => 'task_form')); ?>
	<input type="hidden" name="change_type" id="change_type" value="0" />
	<div class="row">

		<?php if($types) : ?>
		<div class="form-group col-sm-6">
			<label for="type_id"><?= lang('Task.type'); ?></label>
			<select class="form-control" name="type_id" id="type_id">
				<?php foreach ($types as $type) : ?>
				<option value="<?=$type->id;?>" <?=set_select('type_id', $type->id);?>><?=$type->name;?></option>
				<?php endforeach; ?>
		    </select>
		</div>
		<?php endif; ?>

		<?php if($categories) : ?>
		<div class="form-group col-sm-6">
			<label for="category_id"><?= lang('Task.category'); ?></label>
			<select class="form-control" name="category_id">
				<?php foreach ($categories as $category) : ?>
				<option value="<?=$category->id;?>" <?=set_select('category_id', $category->id);?>><?=$category->name;?></option>
				<?php endforeach; ?>
		    </select>
		</div>
		<?php endif; ?>
	</div>
	<div class="row">
		<div class="form-group col-sm-6">
			<label for="url"><?= lang('Task.url'); ?></label>
			<input type="text" class="form-control" name="url" value="<?=set_value('url');?>" size="50" placeholder="<?php if(false && $url_placeholder) {echo $url_placeholder;} else {echo 'https://www.youtube.com/watch?v=rtR2eJXb4U0';} ?>" />
		</div>
		<div class="form-group col-sm-6">
			<label for="name"><?= lang('Task.name'); ?></label>
			<input type="text" class="form-control" name="name" value="<?=set_value('name');?>" size="50" placeholder="<?=lang('Task.name_placeholder');?>" />
		</div>
	</div>

	<div class="row">
		<!-- Цены -->
		<div class="form-group col-sm-3">
			<label for="total_cost"><?= lang('Task.total_cost'); ?></label>
			<input type="text" class="form-control" name="total_cost" id="total_cost" value="<?=set_value('total_cost');?>" size="15" placeholder="200" autocomplete="off" />
		</div>
		<div class="form-group col-sm-3">
			<label for="action_cost"><?= lang('Task.action_cost'); ?></label>
			<input type="text" class="form-control" name="action_cost" id="action_cost" value="<?=set_value('action_cost');?>" size="15" placeholder="1" autocomplete="off" />
			<p style="margin-top: 5px; font-size: 0.9em;"><?= lang('Task.position'); ?><span id="action_cost_position" style="font-weight: bold;">&infin;</span></p>
		</div>
		<div class="form-group col-sm-3">
			<label for="action_target"><?= lang('Task.action_target'); ?></label>
			<input type="text" class="form-control" name="action_target" id="action_target" value="<?=set_value('action_target');?>" size="15" placeholder="0" autocomplete="off" />
		</div>
		<div class="form-group col-sm-3">
			<label for="hour_limit"><?= lang('Task.hour_limit'); ?></label>
			<input type="text" class="form-control" name="hour_limit" value="<?=set_value('hour_limit');?>" size="15" placeholder="<?= lang('Task.hour_limit_tip'); ?>" />
		</div>
	</div>

	<?php if($types) : ?>

	<div class="form_extend">
		<?php 
		$type_id = $_POST['type_id'] ?? 1;
		$path = dirname(__FILE__).'/extend/'.$type_id.'.php';
		if(is_file($path)) {require($path);}
		?>
	</div>
	<?php endif; ?>

	<div class="form-group">
		<input type="submit" class="btn btn-success" value="<?= lang('Task.add_task'); ?>" />
	</div>
</form>
</div>
<?php $this->endSection(); ?>