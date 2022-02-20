<?php foreach ($alerts as $alert) : ?>
    <tr id="tr_<?= $alert['id']; ?>" style="">
        <td class="align-middle"><?= date('Y.m.d', $alert['created_date'] / 1000); ?></td>
        <td class="align-middle"><?= $alert['title']; ?></td>
        <td class="align-middle"><?= $alert['content']; ?></td>
        <td class="align-middle">
            <button class="btn btn-0 btn-danger user_delete" data-id="<?= $alert['id']; ?>">消去</button>
        </td>
    </tr>
<?php endforeach; ?>