<?php
    append_js_file("{$assets_url}theme/js/plugins/datatables/jquery.dataTables.min.js");
?>

<form class="form-horizontal ajax_form" action="<?= current_url(); ?>" method="post" enctype="multipart/form-data">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="text-info">お知らせ登録</h3>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="col-md-2 control-label">タイトル</label>
                        <div class="col-md-9">
                                <input type="text" class="form-control" name="title" required />
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label class="col-md-2 control-label">内容</label>
                        <div class="col-md-9 col-xs-12">
                            <textarea class="form-control" rows="5" name="content" required></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-footer text-center">
            <button class="btn btn-warning btn-0 btn-color-1">登録する</button>
        </div>
    </div>
</form>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="text-info">お知らせ一覧</h3>
    </div>
    <div class="panel-body">
        <div id="table">
            <table class="table text-center table-striped table-condensed datatable_simple">
                <thead>
                    <tr>
                        <th class="text-center">日付</th>
                        <th class="text-center">タイトル</th>
                        <th class="text-center">内容</th>
                        <th class="text-center">消去</th>
                    </tr>
                </thead>
                <tbody>
                    <?= $table; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php

ob_start();
?>
<script>
    $(function() {
        $('.ajax_form').ajaxForm({
            clearForm: true,
            success: function(data) {
                if (data.success == true) {
                    notify_msg('成功しました。');
                    // getData();
                    location.reload();
                } else {
                    notify_msg(data.error, 'error');
                }
            },
            error: function() {
                notify_msg('エラー。', 'error');
            }
        });

        $(document).on('click', '.user_delete', function(){
            var id = $(this).data('id');
            $.ajax({
                url: '<?= current_url(); ?>?' + $.param({id: id}),
                type: 'delete',
                dataType: 'json',
                success: function(data){
                    if (data.success == true) {
                        notify_msg('成功しました。');
                        $(`#tr_${id}`).remove();
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

ob_start();
?>
<style>
    .radio-group-button {
        position: absolute;
        visibility: hidden;
        display: none;
    }

    .radio-group-label {
        color: lighten(#eee, 40%);
        display: inline-block;
        cursor: pointer;
        font-weight: bold;
        padding: 5px 20px;
        margin: 0px;
    }

    .radio-group-button:checked+.radio-group-label {
        color: lighten(#eee, 60%);
        background: #aaa;
    }

    .radio-group-label+.radio-group-button+.radio-group-label {
        border-left: solid 1px #aaa;
    }

    .radio-group {
        border: solid 1px #aaa;
        display: inline-block;
        margin: 0px 10px;
        border-radius: 10px;
        overflow: hidden;
    }
</style>

<?php
$page_style =  ob_get_contents();
ob_end_clean();
append_css($page_style);
?>