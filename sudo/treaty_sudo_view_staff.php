<?php
session_start();
include('assets/config/config.php');
include('assets/config/checklogin.php');
check_login();
?>
<!doctype html>
<!--[if lte IE 9]> <html class="lte-ie9" lang="en"> <![endif]-->
<!--[if gt IE 9]><!-->
<html lang="en"> <!--<![endif]-->
<?php
include("assets/inc/head.php");
?>

<body class="disable_transitions sidebar_main_open sidebar_main_swipe">
    <!-- main header -->
    <?php
    include("assets/inc/nav.php");
    ?>
    <!-- main header end -->

    <!-- main sidebar -->
    <?php
    include("assets/inc/sidebar.php");
    ?>
    <!-- main sidebar end -->
    <?php
    $id = $_GET['id'];
    $ret = "SELECT * FROM  tbl_staff WHERE id = ?";
    $stmt = $mysqli->prepare($ret);
    $stmt->bind_param('s', $id);
    $stmt->execute(); //ok
    $res = $stmt->get_result();
    while ($row = $res->fetch_object()) {
        //display default profile picture
        if ($row->pic == '') {
            $profile_pic = "<img src='assets/profile_img/user_icon.png' alt='user avatar'/>";
        } else {
            $profile_pic = "<img src='assets/profile_img/$row->pic' alt='user avatar'/>";
        }

        //use .danger, .warning, .success according to account status
        if ($row->acc_status == 'active') {
            $account_status = "<span class='md-list-heading uk-text-success'>Active</span>";
        } else {
            $account_status = "<span class='md-list-heading uk-text-warning'>Suspended</span>";
        }
    ?>
        <div id="page_content">
            <!--Breadcrumb-->
            <div id="top_bar hidden-print">
                <ul id="breadcrumbs">
                    <li><a href="pages_sudo_dashboard.php">Dashboard</a></li>
                    <li><a href="treaty_sudo_upload_manage_access.php">Manage Staffs</a></li>
                    <li><span><?= $row->name; ?> Account</span></li>
                </ul>
            </div>
            <div id="page_content_inner">
                <div class="uk-grid" data-uk-grid-margin data-uk-grid-match id="user_profile">
                    <div class="uk-width-large-10-10">
                        <div class="md-card">
                            <div class="user_heading user_heading_bg" style="background-image: url('assets/img/Menu_bg.png')">
                                <div class="bg_overlay">
                                    <div class="user_heading_menu hidden-print">
                                        <div class="uk-display-inline-block"><i class="md-icon md-icon-light material-icons" id="page_print">&#xE8ad;</i></div>
                                    </div>
                                    <div class="user_heading_avatar">
                                        <div class="thumbnail">
                                            <?= $profile_pic; ?>
                                        </div>
                                    </div>
                                    <div class="user_heading_content">
                                        <h2 class="heading_b uk-margin-bottom"><span class="uk-text-truncate"><?= $row->name; ?></span><span class="sub-heading"><?= $row->email; ?></span></h2>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="md-card">
                            <div class="user_heading">
                                <div class="user_heading_menu hidden-print">
                                    <div class="uk-display-inline-block" data-uk-dropdown="{pos:'left-top'}">
                                    </div>
                                </div>
                            </div>
                            <div class="user_content">
                                <ul id="user_profile_tabs" class="uk-tab" data-uk-tab="{connect:'#user_profile_tabs_content', animation:'slide-horizontal'}" data-uk-sticky="{ top: 48, media: 960 }">
                                    <li class="uk-active"><a href="#"><?= $row->name; ?>'s Profile</a></li>
                                </ul>
                                <ul id="user_profile_tabs_content" class="uk-switcher uk-margin">
                                    <li>
                                        <?= $row->bio; ?>
                                        <div class="uk-grid uk-margin-medium-top uk-margin-large-bottom" data-uk-grid-margin>
                                            <div class="uk-width-large-1-2">
                                                <h4 class="heading_c uk-margin-small-bottom">Contact And Personal Info</h4>
                                                <ul class="md-list md-list-addon">
                                                    <li>
                                                        <div class="md-list-addon-element">
                                                            <i class="md-list-addon-icon material-icons">&#xE158;</i>
                                                        </div>
                                                        <div class="md-list-content">
                                                            <span class="md-list-heading"><?= $row->email; ?></span>
                                                            <span class="uk-text-small uk-text-muted">Email</span>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="md-list-addon-element">
                                                            <i class="md-list-addon-icon material-icons">&#xE0CD;</i>
                                                        </div>
                                                        <div class="md-list-content">
                                                            <span class="md-list-heading"><?= $row->phone; ?></span>
                                                            <span class="uk-text-small uk-text-muted">Phone</span>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="md-list-addon-element">
                                                            <i class="md-list-addon-icon material-icons">add_location</i>
                                                        </div>
                                                        <div class="md-list-content">
                                                            <span class="md-list-heading"><?= $row->adr; ?></span>
                                                            <span class="uk-text-small uk-text-muted">Address</span>
                                                        </div>
                                                    </li>

                                                </ul>
                                            </div>

                                            <div class="uk-width-large-1-2">
                                                <h4 class="heading_c uk-margin-small-bottom"></h4>
                                                <br>
                                                <ul class="md-list md-list-addon">
                                                    <li>
                                                        <div class="md-list-addon-element">
                                                            <i class="md-list-addon-icon material-icons">verified_user</i>
                                                        </div>
                                                        <div class="md-list-content">
                                                            <span class="md-list-heading"><?= $row->number; ?></span>
                                                            <span class="uk-text-small uk-text-muted">Staff Number</span>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="md-list-addon-element">
                                                            <i class="md-list-addon-icon material-icons">settings</i>
                                                        </div>
                                                        <div class="md-list-content">
                                                            <?= $account_status; ?>
                                                            <span class="uk-text-small uk-text-muted">Account Status</span>
                                                        </div>
                                                    </li>

                                                </ul>
                                            </div>
                                        </div>

                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    <?php } ?>
    <!--Footer-->
    <?php require_once('assets/inc/footer.php'); ?>
    <!--Footer-->

    <!-- google web fonts -->
    <script data-cfasync="false" src="cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script>
        WebFontConfig = {
            google: {
                families: [
                    'Source+Code+Pro:400,700:latin',
                    'Roboto:400,300,500,700,400italic:latin'
                ]
            }
        };
        (function() {
            var wf = document.createElement('script');
            wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
                '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
            wf.type = 'text/javascript';
            wf.async = 'true';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(wf, s);
        })();
    </script>

    <!-- common functions -->
    <script src="assets/js/common.min.js"></script>
    <!-- uikit functions -->
    <script src="assets/js/uikit_custom.min.js"></script>
    <!-- altair common functions/helpers -->
    <script src="assets/js/altair_admin_common.min.js"></script>

</body>

</html>