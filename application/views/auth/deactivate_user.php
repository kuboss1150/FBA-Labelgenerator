<?php echo form_open(current_url(), ['class' => 'form-horizontal']); ?>
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="text-info"><?= lang('deactivate_heading'); ?></h3>
  </div>
  <div class="panel-body">
    <p><?php echo sprintf(lang('deactivate_subheading'), $user->username); ?></p>
  </div>
  <div class="panel-body">

    <p>
      <?php echo lang('deactivate_confirm_y_label', 'confirm'); ?>
      <input type="radio" name="confirm" value="yes" checked="checked" />
      <?php echo lang('deactivate_confirm_n_label', 'confirm'); ?>
      <input type="radio" name="confirm" value="no" />
    </p>

    <?php echo form_hidden($csrf); ?>
    <?php echo form_hidden(['id' => $user->id]); ?>
  </div>
  <div class="panel-footer text-center">
    <button class="btn btn-primary"><?= lang('deactivate_submit_btn'); ?></button>
  </div>
</div>
<?php echo form_close(); ?>