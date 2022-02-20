
<?php echo form_open(current_url(), ['class'=>'form-horizontal']); ?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="text-info">Add Account</h3>
		</div>
		<div class="panel-body">
			<p><?= $error; ?></p>
		</div>
		<div class="panel-body">
			<div class="form-group">
				<label class="col-md-3 col-xs-12 control-label">Seller ID</label>
				<div class="col-md-6 col-xs-12">
					<div class="input-group">
                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                        <input type="text" name="seller_id" id="seller_id" class="form-control" value="<?= set_value('seller_id'); ?>" />
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 col-xs-12 control-label">ShipToCountry</label>
				<div class="col-md-6 col-xs-12">
					<div class="input-group">
                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                        <input type="text" name="shiptocountry" id="shiptocountry" class="form-control" value="<?= set_value('shiptocountry'); ?>" />
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 col-xs-12 control-label">AddressName</label>
				<div class="col-md-6 col-xs-12">
					<div class="input-group">
                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                        <input type="text" name="addressname" id="addressname" class="form-control" value="<?= set_value('addressname'); ?>" />
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 col-xs-12 control-label">AddressFieldOne</label>
				<div class="col-md-6 col-xs-12">
					<div class="input-group">
                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                        <input type="text" name="addressfieldone" id="addressfieldone" class="form-control" value="<?= set_value('addressfieldone'); ?>" />
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 col-xs-12 control-label">AddressFieldTwo</label>
				<div class="col-md-6 col-xs-12">
					<div class="input-group">
                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                        <input type="text" name="addressfieldtwo" id="addressfieldtwo" class="form-control" value="<?= set_value('addressfieldtwo'); ?>" />
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 col-xs-12 control-label">AddressCity</label>
				<div class="col-md-6 col-xs-12">
					<div class="input-group">
                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                        <input type="text" name="addresscity" id="addresscity" class="form-control" value="<?= set_value('addresscity'); ?>" />
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 col-xs-12 control-label">AddressCountryCode</label>
				<div class="col-md-6 col-xs-12">
					<div class="input-group">
                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                        <input type="text" name="addresscountrycode" id="addresscountrycode" class="form-control" value="<?= set_value('addresscountrycode'); ?>" />
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 col-xs-12 control-label">AddressStateOrRegion</label>
				<div class="col-md-6 col-xs-12">
					<div class="input-group">
                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                        <input type="text" name="addressstateorregion" id="addressstateorregion" class="form-control" value="<?= set_value('addressstateorregion'); ?>" />
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 col-xs-12 control-label">AddressPostalCode</label>
				<div class="col-md-6 col-xs-12">
					<div class="input-group">
                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                        <input type="text" name="addresspostalcode" id="addresspostalcode" class="form-control" value="<?= set_value('addresspostalcode'); ?>" />
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 col-xs-12 control-label">AddressDistrict</label>
				<div class="col-md-6 col-xs-12">
					<div class="input-group">
                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                        <input type="text" name="addressdistrict" id="addressdistrict" class="form-control" value="<?= set_value('addressdistrict'); ?>" />
					</div>
				</div>
			</div>
		</div>
		<div class="panel-footer text-center">
			<button class="btn btn-primary"><?= lang('save'); ?></button>
		</div>
	</div>
<?php echo form_close(); ?>
