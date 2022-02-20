
<?php echo form_open(current_url(), ['class'=>'form-horizontal']); ?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="text-info">Edit Account</h3>
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
                        <input type="text" name="seller_id" id="seller_id" class="form-control" value="<?= set_value('seller_id', $account['seller_id']); ?>" readonly />
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 col-xs-12 control-label">ShipToCountry</label>
				<div class="col-md-6 col-xs-12">
					<div class="input-group">
                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                        <input type="text" name="shiptocountry" id="shiptocountry" class="form-control" value="<?= set_value('shiptocountry', $account['shiptocountry']); ?>" />
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 col-xs-12 control-label">AddressName</label>
				<div class="col-md-6 col-xs-12">
					<div class="input-group">
                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                        <input type="text" name="addressname" id="addressname" class="form-control" value="<?= set_value('addressname', $account['addressname']); ?>" />
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 col-xs-12 control-label">AddressFieldOne</label>
				<div class="col-md-6 col-xs-12">
					<div class="input-group">
                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                        <input type="text" name="addressfieldone" id="addressfieldone" class="form-control" value="<?= set_value('addressfieldone', $account['addressfieldone']); ?>" />
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 col-xs-12 control-label">AddressFieldTwo</label>
				<div class="col-md-6 col-xs-12">
					<div class="input-group">
                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                        <input type="text" name="addressfieldtwo" id="addressfieldtwo" class="form-control" value="<?= set_value('addressfieldtwo', $account['addressfieldtwo']); ?>" />
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 col-xs-12 control-label">AddressCity</label>
				<div class="col-md-6 col-xs-12">
					<div class="input-group">
                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                        <input type="text" name="addresscity" id="addresscity" class="form-control" value="<?= set_value('addresscity', $account['addresscity']); ?>" />
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 col-xs-12 control-label">AddressCountryCode</label>
				<div class="col-md-6 col-xs-12">
					<div class="input-group">
                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                        <input type="text" name="addresscountrycode" id="addresscountrycode" class="form-control" value="<?= set_value('addresscountrycode', $account['addresscountrycode']); ?>" />
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 col-xs-12 control-label">AddressStateOrRegion</label>
				<div class="col-md-6 col-xs-12">
					<div class="input-group">
                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                        <input type="text" name="addressstateorregion" id="addressstateorregion" class="form-control" value="<?= set_value('addressstateorregion', $account['addressstateorregion']); ?>" />
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 col-xs-12 control-label">AddressPostalCode</label>
				<div class="col-md-6 col-xs-12">
					<div class="input-group">
                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                        <input type="text" name="addresspostalcode" id="addresspostalcode" class="form-control" value="<?= set_value('addresspostalcode', $account['addresspostalcode']); ?>" />
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 col-xs-12 control-label">AddressDistrict</label>
				<div class="col-md-6 col-xs-12">
					<div class="input-group">
                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                        <input type="text" name="addressdistrict" id="addressdistrict" class="form-control" value="<?= set_value('addressdistrict', $account['addressdistrict']); ?>" />
					</div>
				</div>
			</div>
		</div>
		<div class="panel-footer text-center">
			<button class="btn btn-primary"><?= lang('save'); ?></button>
		</div>
	</div>
<?php echo form_close(); ?>
