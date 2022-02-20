<table class="table product_table table-striped table-condensed">
    <thead>
        <tr>
            <th>#</th>
            <th data-field="seller_id">SellerID</th>
            <th class="sorting" data-field="asin">ASIN</th>
            <th class="sorting" data-field="jan">JAN</th>
            <th class="sorting" data-field="sku">SKU</th>
            <th class="sorting" data-field="fnsku">FNSKU</th>
            <th class="sorting" data-field="name" style="width: 39%">Product Name</th>
            <th class="sorting" data-field="name_en">Product Name(EN)</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $pagination = $this->ajax_pagination->create_links();
        $start_index = $this->ajax_pagination->per_page * ($this->ajax_pagination->cur_page-1);
        $i = 0;
        foreach ($products as $product) :
            $i++;
            ?>
            <tr data-id="<?= $product['id']; ?>">
                <td><?= $start_index + $i;?></td>
                <td><?= $product['seller_id']; ?></td>
                <td><?= $product['asin']; ?></td>
                <td><?= $product['jan']; ?></td>
                <td><?= $product['sku']; ?></td>
                <td><?= $product['fnsku']; ?></td>
                <td><?= $product['name']; ?></td>
                <td><?= $product['name_en']; ?></td>
                <td>
                    <a href="<?= site_url("product/edit/{$product['id']}"); ?>" class="btn btn-info btn-rounded btn-sm"><i class="fa fa-edit"></i><?=lang('edit');?></a>
                    <button class="btn btn-danger btn-rounded btn-sm delete"><i class="fa fa-trash-o"></i><?=lang('delete');?></button>
                </td>
            </tr>
        <?php
        endforeach;
        ?>
    </tbody>
</table>
<?= $pagination; ?>