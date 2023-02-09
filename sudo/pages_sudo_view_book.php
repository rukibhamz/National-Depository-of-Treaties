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
    $book_id = $_GET['book_id'];
    $ret = "SELECT * FROM  iL_Books WHERE b_id = ?";
    $stmt = $mysqli->prepare($ret);
    $stmt->bind_param('s', $book_id);
    $stmt->execute(); //ok
    $res = $stmt->get_result();
    while ($row = $res->fetch_object()) {
        //load default book cover page if book is missing a cover image
        if ($row->b_coverimage == '') {
            $cover_image = "<img src='assets/img/books/Image12.jpg' alt='Book Image'>";
        } else {
            $cover_image = "<img src='assets/img/books/$row->b_coverimage' alt='Book Image'>";
        }
    ?>
        <div id="page_content">
            <!--Breadcrums-->
            <div id="top_bar">
                <ul id="breadcrumbs">
                    <li><a href="pages_sudo_dashboard.php">Dashboard</a></li>
                    <li><a href="pages_sudo_manage_books.php">Treaties</a></li>
                    <li><span><?php echo $row->b_title; ?></span></li>
                </ul>
            </div>
            <div id="page_content_inner">
                <div class="uk-grid" data-uk-grid-margin data-uk-grid-match id="user_profile">
                    <div class="uk-width-large-10-10">
                        <div class="md-card">
                            <div class="user_heading user_heading_bg" style="background-image: url('assets/img/books/<?php echo $row->b_coverimage; ?>')">
                                <div class="bg_overlay">
                                    <div class="user_heading_menu hidden-print">
                                        <div class="uk-display-inline-block"><i class="md-icon md-icon-light material-icons" id="page_print">&#xE8ad;</i></div>
                                    </div>
                                    <div class="user_heading_content">
                                        <div class="space-10"></div>
                                        <h2 class="heading_b uk-margin-bottom"><span class="uk-text-truncate"><?php echo $row->b_title; ?></span>
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
                                <ul id="user_profile_tabs" class="uk-tab" data-uk-tab="{connect:'#user_profile_tabs_content', animation:'slide-horizontal'}">
                                <!-- data-uk-sticky="{ top: 48, media: 960 }"  -->
                                    <li class="preview uk-active"><a href="#"><?php echo $row->b_title; ?> Details</a></li>
                                    <!--
                                    <li><a href="#">Photos</a></li>
                                    <li><a href="#">Posts</a></li>
                                    -->
                                </ul>
                                <ul id="user_profile_tabs_content" class="uk-switcher uk-margin">
                                    <li>
                                        <?php echo $row->b_summary; ?>
                                        <div class="uk-grid uk-margin-medium-top uk-margin-large-bottom" data-uk-grid-margin>
                                            <div class="uk-width-large-1-2">
                                                <h4 class="heading_c uk-margin-small-bottom">Treaty Information</h4>
                                                <ul class="md-list md-list-addon">
                                                    <li>
                                                        <div class="md-list-addon-element">
                                                            <i class="md-list-addon-icon uk-text-success material-icons">person</i>
                                                        </div>
                                                        <div class="md-list-content">
                                                            <span class="md-list-heading"><?php echo $row->b_author; ?></span>
                                                            <span class="uk-text-small uk-text-muted">Author</span>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="md-list-addon-element">
                                                            <i class="md-list-addon-icon  uk-text-success material-icons">theaters</i>
                                                        </div>
                                                        <div class="md-list-content">
                                                            <span class="md-list-heading"><?php echo $row->b_publisher; ?></span>
                                                            <span class="uk-text-small uk-text-muted">Publisher</span>
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
                                                            <i class="md-list-addon-icon uk-text-success material-icons">spellcheck</i>
                                                        </div>
                                                        <div class="md-list-content">
                                                            <span class="md-list-heading"><?php echo $row->b_copies; ?></span>
                                                            <span class="uk-text-small uk-text-muted">Number Of Copies Available</span>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="md-list-addon-element">
                                                            <i class="md-list-addon-icon uk-text-success material-icons">description</i>
                                                        </div>
                                                        <div class="md-list-content">
                                                            <span class="md-list-heading"><?php echo $row->bc_name; ?></span>
                                                            <span class="uk-text-small uk-text-muted">Book Category</span>
                                                        </div>
                                                    </li>

                                                </ul>

                                            </div>
                                        </div>

                                    </li>

                                </ul>
                                <h4 class="heading_c uk-margin-small-bottom">Preview</h4>
                                <hr>
                                <div class="md-card">
                                    <div id="<?= 'preview-', $_GET['book_id'] ?>"></div>
                                </div>
                            </div>
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


    <script>
        $(function() {
            if (isHighDensity()) {
                $.getScript("assets/js/custom/dense.min.js", function(data) {
                    // enable hires images
                    altair_helpers.retina_images();
                });
            }
            if (Modernizr.touch) {
                // fastClick (touch devices)
                FastClick.attach(document.body);
            }
        });
        $window.load(function() {
            // ie fixes
            altair_helpers.ie_fix();
        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.2.8/pdfobject.min.js" integrity="sha512-MoP2OErV7Mtk4VL893VYBFq8yJHWQtqJxTyIAsCVKzILrvHyKQpAwJf9noILczN6psvXUxTr19T5h+ndywCoVw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        PDFObject.embed("assets/magazines/<?= 'Preview-', $_GET['book_id'] ?>.pdf", "#<?= 'preview-', $_GET['book_id'] ?>");
    </script>
</body>

</html>