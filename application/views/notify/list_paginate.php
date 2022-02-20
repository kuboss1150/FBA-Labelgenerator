<?php foreach ($notifies as $notify) : ?>
    <tr style="">
        <td class="align-middle">
            <?= date('Y.m.d', $notify['created_date'] / 1000); ?>
        </td>
        <td class="align-middle text-left">
            <?= $notify['content']; ?>
        </td>
        <td class="align-middle">
            <label><?= $notify['from_user']['user_name']; ?></label>
            <br />
            <?= $notify['from_user']['place']; ?>,
            <?= $notify['from_user']['age']; ?>,
            <?= $notify['from_user']['gender']; ?>
        </td>
        <td class="align-middle">
            <?php if (isset($notify['to_user'])) : ?>
                <label class="text-danger"><?= $notify['to_user']['user_name']; ?></label>
                <br />
                <?= $notify['to_user']['place']; ?>,
                <?= $notify['to_user']['age']; ?>,
                <?= $notify['to_user']['gender']; ?>
            <?php endif; ?>
        </td>
    </tr>
<?php endforeach; ?>