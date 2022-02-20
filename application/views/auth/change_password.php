<?php echo form_open("auth/change_password", ['class' => 'form-horizontal']); ?>
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="text-info"><?= lang('change_password_heading'); ?></h3>
	</div>
	<div class="panel-body">
		<p><?= $message; ?></p>
	</div>
	<div class="panel-body">
		<div class="form-group">
			<label class="col-md-3 col-xs-12 control-label"><?= lang('change_password_old_password_label'); ?></label>
			<div class="col-md-6 col-xs-12">
				<div class="input-group">
					<span class="input-group-addon"><span class="fa fa-user"></span></span>
					<?= form_input($old_password); ?>
				</div>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-3 col-xs-12 control-label"><?= sprintf(lang('change_password_new_password_label'), $min_password_length); ?></label>
			<div class="col-md-6 col-xs-12">
				<div class="input-group">
					<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
					<?= form_input($new_password); ?>
				</div>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-3 col-xs-12 control-label"><?= lang('change_password_new_password_confirm_label'); ?></label>
			<div class="col-md-6 col-xs-12">
				<div class="input-group">
					<span class="input-group-addon"><span class="fa fa-phone"></span></span>
					<?= form_input($new_password_confirm); ?>
				</div>
			</div>
		</div>
		<?php echo form_input($user_id); ?>
	</div>
	<div class="panel-footer text-center">
		<button class="btn btn-primary"><?= lang('change_password_submit_btn'); ?></button>
	</div>
</div>
<?php echo form_close(); ?>