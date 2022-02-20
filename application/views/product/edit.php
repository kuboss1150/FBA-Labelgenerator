
<?php echo form_open(current_url(), ['class'=>'form-horizontal']); ?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="text-info">Edit Product</h3>
		</div>
		<div class="panel-body">
			<p><?= $error; ?></p>
		</div>
		<div class="panel-body">
			<div class="form-group">
				<label class="col-md-3 col-xs-12 control-label">JAN</label>
				<div class="col-md-6 col-xs-12">
					<div class="input-group">
                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                        <input type="text" name="jan" id="jan" class="form-control" value="<?= set_value('jan', $product['jan']); ?>" />
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 col-xs-12 control-label">ASIN</label>
				<div class="col-md-6 col-xs-12">
					<div class="input-group">
                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                        <input type="text" name="asin" id="asin" class="form-control" value="<?= set_value('asin', $product['asin']); ?>" />
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 col-xs-12 control-label">SKU</label>
				<div class="col-md-6 col-xs-12">
					<div class="input-group">
                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                        <input type="text" name="sku" id="sku" class="form-control" value="<?= set_value('sku', $product['sku']); ?>" />
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 col-xs-12 control-label">FNSKU</label>
				<div class="col-md-6 col-xs-12">
					<div class="input-group">
                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                        <input type="text" name="fnsku" id="fnsku" class="form-control" value="<?= set_value('fnsku', $product['fnsku']); ?>" />
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 col-xs-12 control-label">Product Name</label>
				<div class="col-md-6 col-xs-12">
					<div class="input-group">
                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                        <input type="text" name="name" id="name" class="form-control" value="<?= set_value('name', $product['name']); ?>" />
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 col-xs-12 control-label">Product Name(EN)</label>
				<div class="col-md-6 col-xs-12">
					<div class="input-group">
                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                        <input type="text" name="name_en" id="name_en" class="form-control" value="<?= set_value('name_en', $product['name_en']); ?>" />
					</div>
				</div>
			</div>
		</div>
		<div class="panel-footer text-center">
			<button class="btn btn-primary"><?= lang('save'); ?></button>
		</div>
	</div>
<?php echo form_close(); ?>
