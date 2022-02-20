<table class="table account_table table-striped table-condensed">
    <thead>
        <tr>
            <th class="sorting_asc" data-field="name"><?= lang('site_name'); ?></th>
            <th class="sorting" data-field="domain"><?= lang('domain'); ?></th>
            <th class="sorting" data-field="login_url"><?= lang('login_url'); ?></th>
            <!-- <th class="sorting" data-field="user_field"><?= lang('user_field'); ?></th> -->
            <!-- <th class="sorting" data-field="password_field"><?= lang('password_field'); ?></th> -->
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($domains as $domain) :
            ?>
            <tr data-id="<?= $domain->id; ?>">
                <td><?= $domain->name; ?></td>
                <td><?= $domain->domain; ?></td>
                <td><?= substr($domain->login_url, 0, 100); ?></td>
                <!-- <td><?= $domain->user_field; ?></td> -->
                <!-- <td><?= $domain->password_field; ?></td> -->
                <td>
                    <a href="<?= site_url("domain/edit/{$domain->id}"); ?>" class="btn btn-info btn-rounded btn-sm"><?= lang('edit'); ?></a>
                    <button class="btn btn-danger btn-rounded btn-sm delete"><?= lang('delete'); ?></button>
                </td>
            </tr>
        <?php
        endforeach;
        ?>
    </tbody>
</table>

<?php echo $this->ajax_pagination->create_links(); ?>