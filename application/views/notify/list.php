<?php
append_js_file("{$assets_url}theme/js/plugins/datatables/jquery.dataTables.min.js");
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="text-info">お問い合わせ内容</h3>
    </div>
    <div class="panel-body">
        <div id="table">
            <table class="table text-center table-striped table-condensed datatable_simple" data-sort='0'>
                <thead>
                    <tr>
                        <th class="text-center">日付</th>
                        <th class="text-center">内容</th>
                        <th class="text-center">問い合わせユーザー</th>
                        <th class="text-center">通報されたユーザー</th>
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
    $(function(){

    });
</script>
<?php
    $page_script =  ob_get_contents();
    ob_end_clean();
    append_js($page_script);
?>