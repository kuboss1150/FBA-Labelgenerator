<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="text-info">Accounts</h3>
    </div>
    <div class="panel-body">
        <form class="form-horizontal" id="filter_form" style="margin-bottom: 50px;">
        <a class="btn btn-info" href="<?= site_url('account/create'); ?>">Add Account</a>
            <input type="text" name="filter[seller_id]" class="form-control pull-right" onchange="getData()" style="width: 300px;" >
            <input type="hidden" name="sort_field" id="sort_field">
            <input type="hidden" name="sort_direction" id="sort_direction" value="desc">
        </form>
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
        $('#filter_form').submit(()=>false);
        $(document.body).on('click', 'button.delete', function() {
            if (!confirm("Are you sure delete this record?")) {
                return false;
            }
            var seller_id = $(this).parent('td').parent('tr').data('seller_id');
            $.ajax({
                url: '<?= current_url(); ?>?' + $.param({
                    seller_id: seller_id
                }),
                type: 'delete',
                dataType: 'json',
                success: function(data) {
                    if (data.success == true) {
                        notify_msg('成功しました。');
                        $(`tr[data-seller_id='${seller_id}']`).remove();
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