<form class="form-horizontal settings_form" action="<?= site_url('privacy/save/terms_service'); ?>" method="post">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title text-info"><strong>利用規約</strong></h3>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label class="col-md-1 col-xs-12 control-label">本文テキスト</label>
                <div class="col-md-11 col-xs-12">
                    <textarea class="form-control" rows="8" name="terms_service"><?= $terms_service; ?></textarea>
                </div>
            </div>

        </div>
        <div class="panel-footer text-center">
            <button class="btn btn-warning btn-0 btn-color-1">更新する</button>
        </div>
    </div>
</form>

<form class="form-horizontal settings_form" action="<?= site_url('privacy/save/privacy_policy'); ?>" method="post">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title text-info"><strong>プライバシーポリシー</strong></h3>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label class="col-md-1 col-xs-12 control-label">本文テキスト</label>
                <div class="col-md-11 col-xs-12">
                    <textarea class="form-control" rows="8" name="privacy_policy"><?= $privacy_policy; ?></textarea>
                </div>
            </div>

        </div>
        <div class="panel-footer text-center">
            <button class="btn btn-warning btn-0 btn-color-1">更新する</button>
        </div>
    </div>
</form>

<form class="form-horizontal settings_form" action="<?= site_url('privacy/save/faq'); ?>" method="post">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title text-info"><strong>FAQ</strong></h3>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label class="col-md-1 col-xs-12 control-label">本文テキスト</label>
                <div class="col-md-11 col-xs-12">
                    <textarea class="form-control" rows="8" name="faq"><?= $faq; ?></textarea>
                </div>
            </div>

        </div>
        <div class="panel-footer text-center">
            <button class="btn btn-warning btn-0 btn-color-1">更新する</button>
        </div>
    </div>
</form>

<?php
    ob_start();
?>
<script>
    $(function(){
        $('.settings_form').ajaxForm(function(data){
            if(data.success==true){
                noty({text: 'Successful action', layout: 'topRight', type: 'success', timeout: 2000});
            }else{
                noty({text: 'There was an error', layout: 'topRight', type: 'error', timeout: 2000});
            }
        });
    });
</script>
<?php
    $page_script =  ob_get_contents();
    ob_end_clean();
    append_js($page_script);
?>