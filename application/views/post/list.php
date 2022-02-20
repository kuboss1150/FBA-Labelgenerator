<?php
append_js_file("{$assets_url}theme/js/plugins/datatables/jquery.dataTables.min.js");
?>

<div class="row">
    <div class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="text-info">現在のつぶやく一覧</h3>
            </div>
            <div class="panel-body">
                <div id="table">
                    <table class="table table-striped  datatable_simple" data-sort='0'>
                        <thead style="display:none">
                            <tr>
                                <th>1</th>
                                <th>2</th>
                                <th>3</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?= $table; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <form class="form-horizontal settings_form" action="<?= site_url('user/set_ngwords/ng_words_3'); ?>" method="post">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="text-info">禁止ワード設定</h3>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="col-md-12">
                            <textarea class="form-control" rows="35" name="ng_words_3"><?= $ng_words_3; ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">

                        <div class="col-md-2">
                            <button class=" btn btn-0 btn-info pull-left">保存する</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<?php
ob_start();
?>
<script>
    $(function() {
        $('.settings_form').ajaxForm(function(data) {
            if (data.success == true) {
                notify_msg('成功しました。');
            } else {
                notify_msg('エラー。', 'error');
            }
        });

        $(document).on('click', '.post_approve', function(){
            var id = $(this).data('id');
            var btn = $(this);
            $.ajax({
                url: '<?= site_url('post/approve/'); ?>?' + $.param({id: id}),
                type: 'get',
                dataType: 'json',
                success: function(data){
                    if (data.success == true) {
                        notify_msg('成功しました。');
                        btn.hide();
                    } else {
                        notify_msg('エラー。', 'error');
                    }
                },
                error: function(){
                    notify_msg('エラー。', 'error');
                }
            });
        });
    });
</script>
<?php
$page_script =  ob_get_contents();
ob_end_clean();
append_js($page_script);
?>