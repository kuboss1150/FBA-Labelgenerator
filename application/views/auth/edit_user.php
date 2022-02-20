<?php echo form_open(uri_string(), ['class' => 'form-horizontal']); ?>
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="text-info"><?= lang('edit_user_heading'); ?></h3>
	</div>
	<div class="panel-body">
		<p><?= $message; ?></p>
	</div>
	<div class="panel-body">
		<div class="form-group">
			<label class="col-md-3 col-xs-12 control-label"><?= lang('edit_user_fname_label'); ?></label>
			<div class="col-md-6 col-xs-12">
				<div class="input-group">
					<span class="input-group-addon"><span class="fa fa-user"></span></span>
					<?= form_input($first_name); ?>
				</div>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-3 col-xs-12 control-label"><?= lang('edit_user_email_label'); ?></label>
			<div class="col-md-6 col-xs-12">
				<div class="input-group">
					<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
					<?= form_input($email); ?>
				</div>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-3 col-xs-12 control-label"><?= lang('edit_user_phone_label'); ?></label>
			<div class="col-md-6 col-xs-12">
				<div class="input-group">
					<span class="input-group-addon"><span class="fa fa-phone"></span></span>
					<?= form_input($phone); ?>
				</div>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-3 col-xs-12 control-label"><?= lang('edit_user_password_label'); ?></label>
			<div class="col-md-6 col-xs-12">
				<div class="input-group">
					<span class="input-group-addon"><span class="fa fa-lock"></span></span>
					<?= form_input($password); ?>
				</div>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-3 col-xs-12 control-label"><?= lang('edit_user_password_confirm_label'); ?></label>
			<div class="col-md-6 col-xs-12">
				<div class="input-group">
					<span class="input-group-addon"><span class="fa fa-lock"></span></span>
					<?= form_input($password_confirm); ?>
				</div>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-3 col-xs-12 control-label"><?= lang('edit_user_groups_heading'); ?></label>
			<div class="col-md-6 col-xs-12">
				<?php if ($this->ion_auth->is_admin()) : ?>
					<?php foreach ($groups as $group) : ?>
						<div class="form-check">
						</div>
							<?php
									$gID = $group['id'];
									$checked = null;
									$item = null;
									foreach ($currentGroups as $grp) {
										if ($gID == $grp->id) {
											$checked = ' checked="checked"';
											break;
										}
									}
									?>
							<input type="checkbox" class="form-check-input" name="groups[]" id="grb_<?=$group['id'];?>" value="<?php echo $group['id']; ?>" <?php echo $checked; ?>>
							<label class="form-check-label" for="grb_<?=$group['id'];?>"><?= htmlspecialchars($group['name'], ENT_QUOTES, 'UTF-8'); ?></label>
					<?php endforeach ?>
				<?php endif ?>
			</div>
		</div>
		<?php echo form_hidden('id', $user->id); ?>
		<?php echo form_hidden($csrf); ?>
	</div>
	<div class="panel-footer text-center">
		<button class="btn btn-primary"><?= lang('edit_user_submit_btn'); ?></button>
	</div>
</div>
<?php echo form_close(); ?>