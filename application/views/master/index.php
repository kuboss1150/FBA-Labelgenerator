<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="text-info">管理者</h3>
    </div>
    <div class="panel-body">
        <div id="table"><?= $table; ?></div>
        <?php
        ob_start();
        ?>
        <script>
            $(function() {
                $(document).on('click', 'a.delete', function(){
                    return confirm('<?=lang("confirm_account_delete");?>');
                });
            });
        </script>
        <?php
        $page_script =  ob_get_contents();
        ob_end_clean();
        append_js($page_script);
        ?>
    </div>
    <div class="panel-footer text-center">
        <p><?php echo anchor('master/create', '管理者を追加') ?></p>
    </div>
</div>