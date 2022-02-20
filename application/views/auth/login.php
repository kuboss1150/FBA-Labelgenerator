<!DOCTYPE html>
<html lang="en" class="body-full-height">

<head>
  <!-- META SECTION -->
  <title><?= CI_title(); ?></title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <link rel="icon" href="favicon.ico" type="image/x-icon" />
  <!-- END META SECTION -->

  <!-- CSS INCLUDE -->
  <link rel="stylesheet" type="text/css" id="theme" href="<?= $assets_url; ?>/css/theme-default.css" />
  <!-- EOF CSS INCLUDE -->
</head>

<body>
  <div class="login-container">
    <div class="login-box animated fadeInDown">
      <h1 class="text-info text-center"><?= $this->site_title; ?></h1>
      <div class="login-body">
        <div class="login-title"><strong><?= lang('login_heading'); ?></strong></div>
        <?= empty($error) ? '' : "<div class='alert alert-danger'>{$error}</div>"; ?>
        <form action="<?= site_url('auth/login'); ?>" class="form-horizontal" method="post">
          <div class="form-group">
            <div class="col-md-12">
              <input type="text" class="form-control" placeholder="<?= lang('login_identity_label'); ?>" name="identity" id="identity" />
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-12">
              <input type="password" class="form-control" placeholder="<?= lang('login_password_label'); ?>" name="password" id="password" />
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-12">
              <?php echo lang('login_remember_label', 'remember',['class'=>'text-info']); ?>
              <input type="checkbox" name="remember" value="1" id="remember">
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-6">
              <a class="btn btn-danger btn-block" href="<?= site_url('auth/create_user'); ?>"><?= lang('create_account'); ?></a>
            </div>
            <div class="col-md-6">
              <button class="btn btn-info btn-block"><?= lang('login_submit_btn'); ?></button>
            </div>
          </div>
          <div class="login-subtitle">
            <a href="forgot_password" class="btn btn-link btn-block"><?= lang('login_forgot_password'); ?></a>
          </div>
        </form>
      </div>
      <div class="login-footer">
      </div>
    </div>

  </div>

</body>

</html>