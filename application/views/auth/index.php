<?php
append_js_file("{$assets_url}theme/js/plugins/datatables/jquery.dataTables.min.js");
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="text-info"><?= lang('index_heading'); ?></h3>
    </div>
    <div class="panel-body">
        <div id="table"><?= $table; ?></div>
        <?php
        ob_start();
        ?>
        <script>
            $(function() {

            });
        </script>
        <?php
        $page_script =  ob_get_contents();
        ob_end_clean();
        append_js($page_script);
        ?>
    </div>
    <div class="panel-footer text-center">
        <p><?php echo anchor('auth/create_user', lang('index_create_user_link')) ?> <?php // echo anchor('auth/create_group', lang('index_create_group_link')) ?></p>
    </div>
</div>