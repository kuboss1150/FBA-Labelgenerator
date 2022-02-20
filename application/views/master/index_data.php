<table class="table user_table table-striped table-condensed">
    <thead>
        <tr>
            <th><?= lang('index_fname_th'); ?></th>
            <th><?= lang('index_email_th'); ?></th>
            <th><?= lang('phone_number'); ?></th>
            <th><?= lang('ip_num'); ?></th>
            <th><?= lang('user_num'); ?></th>
            <th><?= lang('created_on'); ?></th>
            <th><?= lang('last_login'); ?></th>
            <th><?= lang('index_status_th'); ?></th>
            <th><?= lang('index_action_th'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user):?>
            <tr>
                <td><?php echo htmlspecialchars($user->first_name,ENT_QUOTES,'UTF-8');?></td>
                <td><?php echo htmlspecialchars($user->email,ENT_QUOTES,'UTF-8');?></td>
                <td><?php echo htmlspecialchars($user->phone,ENT_QUOTES,'UTF-8');?></td>
                <td><?php echo htmlspecialchars($user->last_name,ENT_QUOTES,'UTF-8');?></td>
                <td><?php echo htmlspecialchars($user->company,ENT_QUOTES,'UTF-8');?></td>
                <td><?= date('Y-m-d H:i:s', $user->created_on);?></td>
                <td><?= empty($user->last_login) ? '' : date('Y-m-d H:i:s', $user->last_login);?></td>
                <td>
                    <?php if($user->active):?>
                    <a href="<?= site_url("master/deactivate/{$user->id}"); ?>" class="btn btn-success btn-rounded btn-sm"><?= lang('index_active_link'); ?></a>
                    <?php else:?>
                    <a href="<?= site_url("master/activate/{$user->id}"); ?>" class="btn btn-danger btn-rounded btn-sm"><?= lang('index_inactive_link'); ?></a>
                    <?php endif;?>
                </td>
                <td>
                    <a href="<?= site_url("master/delete/{$user->id}"); ?>" class="btn btn-primary btn-rounded btn-sm delete"><?= lang('delete'); ?></a>
                    <a href="<?= site_url("master/edit/{$user->id}"); ?>" class="btn btn-info btn-rounded btn-sm"><?= lang('edit'); ?></a>
                </td>
            </tr>
        <?php endforeach;?>
    </tbody>
</table>

<?php echo $this->ajax_pagination->create_links(); ?>