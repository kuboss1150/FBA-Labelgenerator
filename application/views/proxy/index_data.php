<table class="table proxy_table table-striped table-condensed">
    <thead>
        <tr>
            <th class="<?= isset($_POST['sort_field']) ? 'sorting' : 'sorting_asc'; ?>" data-field="ip"><?= lang('ip'); ?></th>
            <th class="sorting" data-field="assign"><?= lang('assigned'); ?></th>
            <th>#</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($ips as $ip) :
            ?>
            <tr data-ip="<?= $ip->ip; ?>" data-assign="<?= $ip->assign; ?>">
                <td><?= $ip->ip; ?></td>
                <td><?= $ip->assign==1 ? '<i class="fa fa-check"></i>' : ''; ?></td>
                <td><button class="btn btn-danger btn-rounded btn-sm delete"><?= lang('delete'); ?></button></td>
            </tr>
        <?php
        endforeach;
        ?>
    </tbody>
</table>

<?php echo $this->ajax_pagination->create_links(); ?>