<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- META SECTION -->
    <title><?= CI_title() ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="<?= $assets_url ?>favicon.ico" type="image/x-icon" />
    <!-- END META SECTION -->

    <!-- CSS INCLUDE -->
    <link rel="stylesheet" type="text/css" id="theme" href="<?= $assets_url ?>css/theme-default.css" />
    <!-- EOF CSS INCLUDE -->

    <!-- VueJS INCLUDE -->
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        const http = axios.create({
            baseURL: `<?= base_url(); ?>`,
        });
    </script>
    <!-- EOF VueJS INCLUDE -->

    <!-- START CUSTOM HEADER -->
    <?= CI_head() ?>
    <!-- END CUSTOM HEADER -->
    <style>
        .btn-0 {
            border-radius: 3px;
            -webkit-border-radius: 3px;
        }

        .btn-color-1 {
            background-color: #E94E19;
            border-color: #E94E19;
        }

        .align-baseline {
            vertical-align: baseline !important;
        }

        .align-top {
            vertical-align: top !important;
        }

        .align-middle {
            vertical-align: middle !important;
        }

        .align-bottom {
            vertical-align: bottom !important;
        }

        .align-text-bottom {
            vertical-align: text-bottom !important;
        }

        .align-text-top {
            vertical-align: text-top !important;
        }

        #overlay {
            position: fixed;
            top: 0;
            z-index: 100;
            width: 100%;
            height: 100%;
            display: none;
            background: rgba(0, 0, 0, 0.6);
        }

        .cv-spinner {
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .spinner {
            width: 40px;
            height: 40px;
            border: 4px #ddd solid;
            border-top: 4px #2e93e6 solid;
            border-radius: 50%;
            animation: sp-anime 0.8s infinite linear;
        }

        @keyframes sp-anime {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(359deg);
            }
        }

        .is-hide {
            display: none;
        }

        .panel {
            margin-left: 10px;
            width: calc( 100% - 20px);
        }

        *{
            font-family:"ヒラギノ角ゴ Pro W3", "Hiragino Kaku Gothic Pro",Osaka, "メイリオ", Meiryo, "ＭＳ Ｐゴシック", "MS PGothic", sans-serif;
        }
    </style>
</head>

<body <?= CI_body_attr() ?>>
    <!-- START PAGE CONTAINER -->
    <div class="page-container page-navigation-top-fixed">

        <!-- START PAGE SIDEBAR -->
        <div class="page-sidebar page-sidebar-fixed scroll">
            <!-- START X-NAVIGATION -->
            <ul class="x-navigation">
                <li class="xn-logo">
                    <a href="<?= site_url(); ?>" style="font-weight: bold; background-color: #1d2127;"><?= $this->site_title; ?></a>
                    <a href="#" class="x-navigation-control"></a>
                </li>

                <?php
                $cur_select = $this->roles[$this->slug]['menu_select'] ?? $this->slug;
                foreach ($this->roles as $k => $role) {
                    if (!$role['menu']) continue;
                    if ($role['groups'] !== '*' && !$this->ion_auth->in_group($role['groups'])) continue;
                ?>
                    <li class="<?= $k === $cur_select ? 'active' : ''; ?>">
                        <a href="<?= $role['url']; ?>"><span class="<?= $role['icon']; ?>"></span> <span class="xn-text"><?= $role['title']; ?></span></a>
                    </li>
                <?php } ?>
            </ul>
            <!-- END X-NAVIGATION -->
        </div>
        <!-- END PAGE SIDEBAR -->

        <!-- PAGE CONTENT -->
        <div class="page-content">
            <!-- START X-NAVIGATION VERTICAL -->
            <ul class="x-navigation x-navigation-horizontal x-navigation-panel">
                <!-- TOGGLE NAVIGATION -->
                <li class="xn-icon-button">
                    <a href="#" class="x-navigation-minimize"><span class="fa fa-dedent"></span></a>
                </li>
                <!-- END TOGGLE NAVIGATION -->
                <!-- SEARCH -->
                <!-- <li class="xn-search">
                    <form role="form">
                        <input type="text" name="search" placeholder="Search..." />
                    </form>
                </li> -->
                <!-- END SEARCH -->
                <!-- SIGN OUT -->
                <li class="xn-icon-button pull-right">
                    <a href="#" class="mb-control" data-box="#mb-signout"><span class="fa fa-sign-out"></span></a>
                </li>
                <!-- END SIGN OUT -->

                <!-- ACCOUNT SELECT -->
                <li class="xn-icon-button pull-right">
                    <a href="#" style="width: auto;"><?= $this->seller_id; ?></a>
                    <div class="panel panel-primary animated zoomIn xn-drop-left xn-panel-dragging">
                        <div class="panel-body list-group list-group-contacts scroll" style="height: 400px;">
                            <?php
                            foreach ($list_accounts as $account) {
                                echo "
                                    <a href='" . site_url("account/set_account/{$account['seller_id']}") . "?url=" . current_url() . "' class='list-group-item'>
                                        <div class='list-group-status status-online'></div>
                                        <span class='contacts-title'>{$account['seller_id']}</span>
                                    </a>";
                            }
                            ?>
                        </div>
                    </div>
                </li>
                <!-- END ACCOUNT -->

            </ul>
            <!-- END X-NAVIGATION VERTICAL -->

            <!-- PAGE CONTENT WRAPPER -->
            <div class="page-content-wrap" style="padding-top:30px;">
                <div class="row">
                    <div class="col-md-12">
                        <?= $page_content ?>
                    </div>
                </div>
            </div>
            <!-- END PAGE CONTENT WRAPPER -->
        </div>
        <!-- END PAGE CONTENT -->
    </div>
    <!-- END PAGE CONTAINER -->

    <!-- MESSAGE BOX-->
    <div class="message-box animated fadeIn" data-sound="alert" id="mb-signout">
        <div class="mb-container">
            <div class="mb-middle">
                <div class="mb-title"><span class="fa fa-sign-out"></span> <strong>ログアウト</strong></div>
                <div class="mb-content">
                    <p>本当にログアウトしますか？</p>
                </div>
                <div class="mb-footer">
                    <div class="pull-right">
                        <a href="<?= site_url('auth/logout'); ?>" class="btn btn-success btn-lg">はい</a>
                        <button class="btn btn-default btn-lg mb-control-close">いいえ</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MESSAGE BOX-->


    <div id="overlay">
        <div class="cv-spinner">
            <span class="spinner"></span>
        </div>
    </div>

    <!-- START PRELOADS -->
    <audio id="audio-alert" src="<?= $assets_url; ?>audio/alert.mp3" preload="auto"></audio>
    <audio id="audio-fail" src="<?= $assets_url; ?>audio/fail.mp3" preload="auto"></audio>
    <!-- END PRELOADS -->

    <!-- START SCRIPTS -->
    <!-- START PLUGINS -->
    <script type="text/javascript" src="<?= $assets_url; ?>js/plugins/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="<?= $assets_url; ?>js/plugins/jquery/jquery-ui.min.js"></script>
    <script type="text/javascript" src="<?= $assets_url; ?>js/plugins/bootstrap/bootstrap.min.js"></script>
    <!-- END PLUGINS -->

    <!-- THIS PAGE PLUGINS -->
    <script type="text/javascript" src="<?= $assets_url; ?>js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>
    <script type="text/javascript" src="<?= $assets_url; ?>js/jquery.form.min.js"></script>
    <script type="text/javascript" src="<?= $assets_url; ?>js/plugins/noty/jquery.noty.js"></script>
    <script type="text/javascript" src="<?= $assets_url; ?>js/plugins/noty/layouts/topCenter.js"></script>
    <script type="text/javascript" src="<?= $assets_url; ?>js/plugins/noty/layouts/topLeft.js"></script>
    <script type="text/javascript" src="<?= $assets_url; ?>js/plugins/noty/layouts/topRight.js"></script>
    <script type="text/javascript" src="<?= $assets_url; ?>js/plugins/noty/themes/default.js"></script>

    <!-- END PAGE PLUGINS -->

    <!-- START TEMPLATE -->
    <script type="text/javascript" src="<?= $assets_url; ?>js/plugins.js?v=1.3"></script>
    <script type="text/javascript" src="<?= $assets_url; ?>js/actions.js?v=1.4"></script>
    <!-- END TEMPLATE -->
    
    <!-- START CUSTOM SCRIPT -->
    <?= CI_footer() ?>
    <!-- END CUSTOM SCRIPT -->

    <!-- END SCRIPTS -->

    <script>
        function notify_msg(msg, type = 'success') {
            noty({
                text: msg,
                layout: 'topRight',
                type: type,
                timeout: 5000
            });
        }
        $(function() {
            <?php
            if (!empty($message)) {
                echo "notify_msg('{$message['message']}', '{$message['type']}');";
            }
            ?>
            $(document).ajaxStart(function() {
                $("#overlay").fadeIn(300);
            }).ajaxStop(function() {
                $("#overlay").fadeOut(300);
                page_content_onresize();
            });


            $(document).on('click', '.ajax-pagination', function(e) {
                e.preventDefault();
                var $this = $(this);
                var $page = $this.data('page');
                $.ajax({
                    method: "POST",
                    url: $this.attr('href'),
                    data: {
                        page: $page
                    },
                    beforeSend: function() {
                        $this.hide();
                    },
                    success: function(data) {
                        $($this.data('target') + '>tr').show();
                        page_content_onresize();
                        if ($page != 1) {
                            $("html, body").animate({
                                scrollTop: $(document).height() - $(window).height()
                            }, 1000);
                        }
                        if (data != '') {
                            $($this.data('target')).append(data);
                            $this.data('page', Number($page) + 1).show();
                        }
                    }
                });
            });
            // $('.ajax-pagination').trigger('click');
        });
    </script>
</body>

</html>