<table class="table account_table table-striped table-condensed">
    <thead>
        <tr>
            <th class="sorting" data-field="seller_id">Seller ID</th>
            <th class="sorting" data-field="shiptocountry">ShipToCountry</th>
            <th class="sorting" data-field="addressname">AddressName</th>
            <th class="sorting" data-field="addressfieldone">AddressFieldOne</th>
            <th class="sorting" data-field="addressfieldtwo">AddressFieldTwo</th>
            <th class="sorting" data-field="addresscity">AddressCity</th>
            <th class="sorting" data-field="addresscountrycode">AddressCountryCode</th>
            <th class="sorting" data-field="addressstateorregion">AddressStateOrRegion</th>
            <th class="sorting" data-field="addresspostalcode">AddressPostalCode</th>
            <th class="sorting" data-field="addressdistrict">AddressDistrict</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($accounts as $account) :
            ?>
            <tr data-seller_id="<?= $account['seller_id']; ?>">
                <td><?= $account['seller_id']; ?></td>
                <td><?= $account['shiptocountry']; ?></td>
                <td><?= $account['addressname']; ?></td>
                <td><?= $account['addressfieldone']; ?></td>
                <td><?= $account['addressfieldtwo']; ?></td>
                <td><?= $account['addresscity']; ?></td>
                <td><?= $account['addresscountrycode']; ?></td>
                <td><?= $account['addressstateorregion']; ?></td>
                <td><?= $account['addresspostalcode']; ?></td>
                <td><?= $account['addressdistrict']; ?></td>
                <td>
                    <a href="<?= site_url("account/edit/{$account['seller_id']}"); ?>" class="btn btn-info btn-rounded btn-sm">Edit</a>
                    <button class="btn btn-danger btn-rounded btn-sm delete">Delete</button>
                </td>
            </tr>
        <?php
        endforeach;
        ?>
    </tbody>
</table>

<?php echo $this->ajax_pagination->create_links(); ?>