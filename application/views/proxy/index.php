<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="text-info"><?= lang('proxy_list'); ?></h3>
            </div>
            <div class="panel-body">
                <form id="filter_form" style="display: none">
                    <input type="hidden" name="sort_field" id="sort_field">
                    <input type="hidden" name="sort_direction" id="sort_direction" value="desc">
                </form>
                <div id="table"><?= $table; ?></div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <?php if($count_all<$ip_num): ?>
        <form class="form-horizontal ajax_form" action="<?= site_url('proxy/index'); ?>" method="post">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="text-info"><?= lang('proxy_register'); ?></h3>
                </div>
                <div class="panel-body">
                    <textarea name="ips" id="ips" style="height: 500px;" class="form-control"></textarea>
                </div>
                <div class="panel-footer text-center">
                    <input type="file" data-filename-placement="inside" class="fileinput btn-success" name="csv" id="csv" title="<?= lang('csv_import'); ?>" />
                    <button class="btn btn-info"><i class="fa fa-save"></i><?= lang('save'); ?></button>
                </div>
            </div>
        </form>
        <?php endif; ?>
    </div>
</div>

<?php
append_js_file("{$assets_url}js/plugins/bootstrap/bootstrap-file-input.js");

ob_start();
?>
<script>
    $(function() {
        $('.ajax_form').ajaxForm({
            clearForm: true,
            success: function(data) {
                if (data.success == true) {
                    notify_msg('成功しました。');
                    getData();
                } else {
                    notify_msg('エラー。', 'error');
                }
            },
            error: function() {
                notify_msg('エラー。', 'error');
            }
        });

        $(document.body).on('click', 'th.sorting, th.sorting_desc, th.sorting_asc', function() {
            let field = $(this).data('field');
            if (field == $('#sort_field').val()) {
                $('#sort_direction').val($('#sort_direction').val() == 'desc' ? 'asc' : 'desc');
            } else {
                $('#sort_field').val(field);
            }
            getData();
        });

        $(document.body).on('click', 'button.delete', function() {
            if($(this).parent('td').parent('tr').data('assign')=='1'){
                if(!confirm("<?= lang('confirm_used_ip_delete'); ?>")){
                    return false;
                }
            }
            var ip = $(this).parent('td').parent('tr').data('ip');
            $.ajax({
                url: '<?= current_url(); ?>?' + $.param({ip: ip}),
                type: 'delete',
                dataType: 'json',
                success: function(data){
                    if (data.success == true) {
                        notify_msg('成功しました。');
                        $(`tr[data-ip='${ip}']`).remove();
                    } else {
                        notify_msg('エラー。', 'error');
                    }
                },
                error: function(){
                    notify_msg('エラー。', 'error');
                }
            });
        });

        $('#csv').on('change', function() {
            let reader = new FileReader();
            reader.onload = function() {
                $('#ips').val(reader.result);
            };
            reader.readAsBinaryString($(this)[0].files[0]);
        })

    });
</script>
<?php
$page_script =  ob_get_contents();
ob_end_clean();
append_js($page_script);
?>