<?php foreach ($posts as $post) : ?>
    <tr style="">
        <td class="text-nowrap"><label><?= date('Y.m.d H:i', $post['created_date'] / 1000); ?></label></td>
        <td><label><?= $post['from_user']['user_name']; ?></label></td>
        <?php
            $content = $post['desc_content'];
            if(!empty($post['deleted'])){
                $ng_words = explode("\n", $this->settings->get('ng_words_3'));
                $f = false;
                foreach($ng_words as $ng_word){
                    $content = highlight_phrase($content, $ng_word, '<mark style="background-color: red;color: white;">', '</mark>');
                    if(preg_match("/$ng_word/", $content) && $f==false){
                        $f = true;
                        $content .= '<button class="btn btn-0 btn-sm btn-success pull-right post_approve" data-id="'.$post['id'].'">承認する</button>';
                    }
                }
            }
        ?>
        <td><span class="label label-danger label-form" style="background-color:#C39A6B;"><?= isset($post['to_user']) ? 'to: ' . $post['to_user']['user_name'] : ''; ?></span><?= $content; ?></td>
    </tr>
<?php endforeach; ?>