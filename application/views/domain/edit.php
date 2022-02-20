
<?php echo form_open(current_url(), ['class'=>'form-horizontal']); ?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="text-info"><?= lang('edit_domain'); ?></h3>
		</div>
		<div class="panel-body">
			<p><?= $error; ?></p>
		</div>
		<div class="panel-body">
			<div class="form-group">
				<label class="col-md-3 col-xs-12 control-label"><?= lang('site_name'); ?></label>
				<div class="col-md-6 col-xs-12">
					<div class="input-group">
                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                        <input type="text" name="name" id="name" class="form-control" value="<?= set_value('name', $domain['name']); ?>" />
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 col-xs-12 control-label"><?= lang('domain'); ?></label>
				<div class="col-md-6 col-xs-12">
					<div class="input-group">
                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                        <input type="text" name="domain" id="domain" class="form-control" value="<?= set_value('domain', $domain['domain']); ?>" />
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 col-xs-12 control-label"><?= lang('login_url'); ?></label>
				<div class="col-md-6 col-xs-12">
					<div class="input-group">
                        <span class="input-group-addon"><span class="fa fa-desktop"></span></span>
                        <input type="text" name="login_url" id="login_url" class="form-control" value="<?= set_value('login_url', $domain['login_url']); ?>" />
					</div>
				</div>
			</div>
			<!-- <div class="form-group">
				<label class="col-md-3 col-xs-12 control-label"><?= lang('user_field'); ?></label>
				<div class="col-md-6 col-xs-12">
					<div class="input-group">
                        <span class="input-group-addon"><span class="fa fa-user"></span></span>
                        <input type="text" name="user_field" id="user_field" class="form-control" value="<?= set_value('user_field', $domain['user_field']); ?>" />
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 col-xs-12 control-label"><?= lang('password_field'); ?></label>
				<div class="col-md-6 col-xs-12">
					<div class="input-group">
                        <span class="input-group-addon"><span class="fa fa-lock"></span></span>
                        <input type="text" name="password_field" id="password_field" class="form-control" value="<?= set_value('password_field', $domain['password_field']); ?>" />
					</div>
				</div>
			</div> -->
		</div>
		<div class="panel-footer text-center">
			<button class="btn btn-primary"><?= lang('save'); ?></button>
		</div>
	</div>
<?php echo form_close(); ?>