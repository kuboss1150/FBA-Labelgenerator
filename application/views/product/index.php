<?php
append_js_file("{$assets_url}js/plugins/bootstrap/bootstrap-file-input.js");
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="text-info">Products</h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-xs-12 col-md-4">
                <form class="pull-left" method="POST" enctype="multipart/form-data" action="<?=site_url('product/import');?>" id="csv_form">
                    <div class="btn-group btn-group-lg">
                        <a class="btn btn-warning" href="<?= site_url('product/create'); ?>">Add Product</a>
                        <input type="file" class="fileinput btn-primary" name="csv" id="csv" accept=".csv" title="Import"/>
                        <a class="btn btn-info" href="<?= site_url('product/export'); ?>">Export</a>
                        <button class="btn btn-danger" type="button" id="clear_btn">Clear</button>
                    </div>
                </form>
            </div>
            <div class="col-xs-12 col-md-4 col-md-offset-4">
                <form class="form-horizontal pull-right" id="filter_form" style="margin-bottom: 50px;">
                    <div class="input-group pull-right" style="width: 100%;" >
                        <span class="input-group-addon" style="background: #f9f9f9; border-color:#d5d5d5;color:#000">
                            <select name="filter[field]" style="background: transparent; border:none;">
                                <option value="jan">JAN</option>
                                <option value="asin">ASIN</option>
                                <option value="sku">SKU</option>
                                <option value="fnsku">FNSKU</option>
                                <option value="name">Name</option>
                                <option value="name_en">English Name</option>
                            </select>
                        </span>
                        <input type="text" name="filter[value]" placeholder="" class="form-control" onchange="getData()" >
                        <span class="input-group-btn">
                            <button class="btn btn-success" onclick="getData()">Search</button>
                        </span>
                    </div>

                    <input type="hidden" name="sort_field" id="sort_field">
                    <input type="hidden" name="sort_direction" id="sort_direction" value="desc">
                </form>
            </div>
        </div>
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
        $('#csv').on('change', function(){
            $('#csv_form').ajaxSubmit({
                success: function(){
                    if($.isFunction('getData')){
                        $('#csv_form')[0].reset();
                        getData();
                    }else{
                        location.reload();
                    }
                }
            })
        });
        $('#clear_btn').on('click', function(){
            if (!confirm("Are you sure you want to remove all products?")) {
                return false;
            }
            $.ajax({
                url: '<?= current_url(); ?>?' + $.param({
                    id: 'all'
                }),
                type: 'delete',
                dataType: 'json',
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
        });
        $('#filter_form').submit(()=>false);
        $(document.body).on('click', 'button.delete', function() {
            if (!confirm("Are you sure delete this record?")) {
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