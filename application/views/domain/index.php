<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="text-info"><?= lang('domains_list'); ?></h3>
    </div>
    <div class="panel-body">
        <form id="filter_form" style="display: none">
            <input type="hidden" name="sort_field" id="sort_field">
            <input type="hidden" name="sort_direction" id="sort_direction" value="desc">
        </form>
        <a class="btn btn-info" href="<?= site_url('domain/create'); ?>"><?= lang('create_domain'); ?></a>
        <div id="table"><?= $table; ?></div>
    </div>
</div>

<?php

ob_start();
?>
<script>
    $(function() {
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
            if (!confirm("<?= lang('confirm_domain_delete'); ?>")) {
                return false;
            }
            var id = $(this).parent('td').parent('tr').data('id');
            $.ajax({
                url: '<?= current_url(); ?>?' + $.param({
                    id: id
                }),
                type: 'delete',
                dataType: 'json',
                success: function(data) {
                    if (data.success == true) {
                        notify_msg('成功しました。');
                        $(`tr[data-id='${id}']`).remove();
                    } else {
                        notify_msg('エラー。', 'error');
                    }
                },
                error: function() {
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