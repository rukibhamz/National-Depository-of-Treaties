<?php
session_start();
include('assets/config/config.php');
include('assets/config/checklogin.php');
check_login();
?>
<!doctype html>
<!--[if lte IE 9]> <html class="lte-ie9" lang="en"> <![endif]-->
<!--[if gt IE 9]><!-->
<html lang="en">
<!--<![endif]-->
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
    $doc_id = $_GET['doc_id'];
    $ret = "SELECT * FROM  tbl_treaties WHERE id = ?";
    $stmt = $mysqli->prepare($ret);
    $stmt->bind_param('s', $doc_id);
    $stmt->execute(); //ok
    $res = $stmt->get_result();
    while ($row = $res->fetch_object()) {
    ?>
        <div id="page_content">
            <!--Breadcrums-->
            <div id="top_bar">
                <ul id="breadcrumbs">
                    <li><a href="pages_sudo_dashboard.php">Dashboard</a></li>
                    <li><a href="treaty_sudo_all_treaties.php">All Treaty</a></li>
                      <!-- <li><span><?= $row->title; ?></span></li> -->
                      <li><span><?= strlen($row->title) > 60 ? substr($row->title, 0, 50) . '...' : $row->title; ?></span></li>
                </ul>
            </div>

            <div id="page_content_inner">
                <div class="space-10"></div>
                <div class="uk-grid" data-uk-grid-margin data-uk-grid-match id="user_profile">
                    <div class="uk-width-large-10-10">
                        <div class="md-card">
                            <div class="user_heading user_heading_bg">
                                <div class="bg_overlay">
                                    <div class="user_heading_menu hidden-print">
                                        <div class="uk-display-inline-block"><i class="md-icon md-icon-light material-icons" id="page_print">&#xE8ad;</i></div>
                                    </div>
                                    <div class="user_heading_content">
                                        <h2 class="heading_b uk-margin-bottom"><span class="uk-text-truncate"><?= $row->title; ?></span><span class="sub-heading">Year: <?= $row->treaty_year ?></span></h2>

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
                                    <li class="uk-active"><a href="#"><?php echo $row->title; ?> Details</a></li>
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
                                                <h4 class="heading_c uk-margin-small-bottom">Document Information</h4>
                                                <ul class="md-list md-list-addon">
                                                    <li>
                                                        <div class="md-list-addon-element">
                                                            <i class="md-list-addon-icon uk-text-primary material-icons">person</i>
                                                        </div>
                                                        <div class="md-list-content">
                                                            <span class="md-list-heading"><?php echo $row->b_publisher; ?></span>
                                                            <span class="uk-text-small uk-text-muted">Author</span>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="md-list-addon-element">
                                                            <i class="md-list-addon-icon  uk-text-primary material-icons">theaters</i>
                                                        </div>
                                                        <div class="md-list-content">
                                                            <span class="md-list-heading"><?php echo $row->s_status; ?></span>
                                                            <span class="uk-text-small uk-text-muted">Status</span>
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
                                                            <i class="md-list-addon-icon uk-text-primary material-icons">spellcheck</i>
                                                        </div>
                                                        <div class="md-list-content">
                                                            <span class="md-list-heading"><?php echo $row->signatory; ?></span>
                                                            <span class="uk-text-small uk-text-muted">Signatory</span>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="md-list-addon-element">
                                                            <i class="md-list-addon-icon uk-text-primary material-icons">description</i>
                                                        </div>
                                                        <div class="md-list-content">
                                                            <span class="md-list-heading"><?php echo $row->tc_name; ?></span>
                                                            <span class="uk-text-small uk-text-muted">Treaty Category</span>
                                                        </div>
                                                    </li>

                                                </ul>

                                            </div>
                                        </div>

                                    </li>

                                </ul>

                                <div class="space-30"></div>
                                <div class="row">
                                    <div class="col-xs-12 col-md-12">
                                        <div class="category-item well green">
                                            <div class="media">
                                                <div class="md-card">
                                                    <?php
                                                    $file_ext = pathinfo($row->b_file, PATHINFO_EXTENSION);
                                                    $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif');

                                                    if (in_array($file_ext, $allowed_extensions)) {
                                                        echo "<div style='margin-bottom: 2rem; max-height: 25%; max-width: 25%; padding-bottom: 1rem;'>
                                                    <img src='assets/magazines/{$row->b_file}' alt='{$row->b_file}' width='img-responsive' />
                                                    <a download class='btn btn-primary' href='assets/magazines/{$row->b_file}' class='download-imag'>
                                                    <i class='icofont icofont-download-alt'></i>&nbsp;Download</a>
                                                </div>";
                                                    }
                                                    ?>
                                                </div>
                                                <div class="md-card">
                                                    <div data-value="<?= $row->b_file ?>" id="<?= 'preview-', $_GET['doc_id'] ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.2.8/pdfobject.min.js" integrity="sha512-MoP2OErV7Mtk4VL893VYBFq8yJHWQtqJxTyIAsCVKzILrvHyKQpAwJf9noILczN6psvXUxTr19T5h+ndywCoVw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        const docsContainer = document.getElementById('<?= 'preview-', $_GET['doc_id'] ?>')
        const fileName = docsContainer.getAttribute('data-value');
        const fileExt = fileName.split(".").pop();
        if (screen.width < 768 && fileExt === 'pdf') {
            var pdfUrl = `assets/magazines/${fileName}`;
            // var pdfHtml = '<object data="' + pdfUrl + '" type="application/pdf" width="100%" height="100%"></object>';
            let pdfHtml = `<a href="${pdfUrl}" download="${fileName}" class="btn btn-primary"><i class="icofont icofont-download-alt"></i>&ensp;Download PDF</a>`;
            document.getElementById("pdf-container").innerHTML = pdfHtml;
        } else if (fileExt === 'pdf' && screen.width >= 768) {
            PDFObject.embed(`assets/magazines/${fileName}`, "#<?= 'preview-', $_GET['doc_id'] ?>");
        }
    </script>
</body>

</html>