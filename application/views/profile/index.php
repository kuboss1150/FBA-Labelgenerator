<?php
append_js_file([
    'firebase-app.js',
    'firebase-firestore.js'
], 'https://www.gstatic.com/firebasejs/7.2.1/');
?>
<div class="panel panel-default tabs">
    <ul class="nav nav-tabs" role="tablist">
        <li class="active"><a href="#tab-post" role="tab" data-toggle="tab" aria-expanded="false">Post</a></li>
        <li class=""><a href="#tab-message" role="tab" data-toggle="tab" aria-expanded="false">Message</a></li>
    </ul>
    <div class="panel-body tab-content">
        <div class="tab-pane active" id="tab-post">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed dictum dolor sem, quis pharetra dui ultricies vel. Cras non pulvinar tellus, vel bibendum magna. Morbi tellus nulla, cursus non nisi sed, porttitor dignissim erat. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc facilisis commodo lectus. Vivamus vel tincidunt enim, non vulputate ipsum. Ut pellentesque consectetur arcu sit amet scelerisque. Fusce commodo leo eros, ut eleifend massa congue at.</p>
        </div>
        <div class="tab-pane" id="tab-message">
            <p>Donec tristique eu sem et aliquam. Proin sodales elementum urna et euismod. Quisque nisl nisl, venenatis eget dignissim et, adipiscing eu tellus. Sed nulla massa, luctus id orci sed, elementum consequat est. Proin dictum odio quis diam gravida facilisis. Sed pharetra dolor a tempor tristique. Sed semper sed urna ac dignissim. Aenean fermentum leo at posuere mattis. Etiam vitae quam in magna viverra dictum. Curabitur feugiat ligula in dui luctus, sed aliquet neque posuere.</p>
        </div>
    </div>
</div>
<?php
ob_start();
?>
<script>
    firebase.initializeApp({
        apiKey: 'AIzaSyDJIhY4Jbo8y1WaTLi1PajHioW1jnbnIf0',
        authDomain: '*',s
        projectId: 'ioschattingapp-c3a52'
    });

    var firestore = firebase.firestore();

    $(function() {
        
        var user_id = '<?= $user_id; ?>';
        $(document).on('click', '.user_delete', function() {
            return;
            var id = $(this).data('id');
            var type = $(this).data('type');
            // if(!confirm('Are you sure?')){
            // return false;
            // }
            $.ajax({
                url: '<?= current_url(); ?>?' + $.param({
                    id: id,
                    type: type
                }),
                type: 'delete',
                dataType: 'json',
                success: function(data) {
                    if (data.success == true) {
                        notify_msg('成功しました。');
                        $(`#tr_${id}`).remove();
                    } else {
                        notify_msg('エラー。', 'error');
                    }
                },
                error: function() {
                    notify_msg('エラー。', 'error');
                }

            });
        });
    });
</script>
<?php
$page_script =  ob_get_contents();
ob_end_clean();
append_js($page_script);
?>