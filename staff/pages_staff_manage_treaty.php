<?php
session_start();
include('assets/config/config.php');
include('assets/config/checklogin.php');
check_login();
if (isset($_SESSION['id'])) {
    // Get the user's ID and other details from the session
    $user_id = $_SESSION['id'];
    $result = "SELECT * FROM tbl_staff WHERE id = ?";
    $stmt = $mysqli->prepare($result);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_object();
    $stmt->close();
}
//delete book  
if (isset($_GET['deleteBook'])) {
    $id = intval($_GET['deleteBook']);
    $adn = "DELETE FROM tbl_treaties  WHERE id = ?";
    $stmt = $mysqli->prepare($adn);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();

    if ($stmt) {
        $success = "Treaty Deleted";
?>
        <script>
            // Remove the query parameter from the URL
            window.history.replaceState({}, document.title, window.location.pathname);
        </script>
<?php
    } else {
        $err = "Try Again Later";
    }
}
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

    <div id="page_content">
        <!--BreadCrumps-->
        <div id="top_bar">
            <ul id="breadcrumbs">
                <li><a href="pages_staff_dashboard.php">Dashboard</a></li>
                <li><span>Manage Treaties</span></li>
            </ul>
        </div>
        <div id="page_content_inner">

            <div style="display:flex; justify-content:space-between">
                <h4 class="heading_a uk-margin-bottom">Treaty Catalog</h4>

                <div class="uk-form-row" style="display: none">
                    <select required onChange="getTreatyId(this.value);" name="tc_name" id="tc_name" class="md-input" />
                    <option value="">Select Category</option>
                    <?php
                    $ret = "SELECT * FROM  tbl_treatiescategory";
                    $stmt = $mysqli->prepare($ret);
                    $stmt->execute(); //ok
                    $res = $stmt->get_result();
                    while ($row = $res->fetch_object()) {
                    ?>
                        <option value="<?= $row->name; ?>"><?= $row->code; ?> - <?= $row->name; ?></option>
                    <?php } ?>
                    </select>
                </div>
            </div>
            <!-- ----------- -->
            <div class="md-card uk-margin-medium-bottom">
                <div class="md-card-content">
                    <div class="dt_colVis_buttons"></div>
                    <table id="dt_tableExport" class="uk-table" cellspacing="0" width="100%">
                        <thead>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Author</th>
                            <th>Category</th>
                            <th>Action</th>
                        </thead>

                        <tbody>
                            <?php
                            $ret = "SELECT * FROM tbl_treaties WHERE b_publisher= '$user->name'";
                            $stmt = $mysqli->prepare($ret);
                            $stmt->execute(); //ok
                            $res = $stmt->get_result();
                            while ($row = $res->fetch_object()) {
                                if ($row->approved == 1) {
                                    $btn_status = "<td><span class='uk-badge uk-badge-primary'>Approved</span>
                            </td>";
                                } else {
                                    $btn_status = "<td><span class='uk-badge uk-badge-default'>Pending</span>
                            </td>";
                                }
                            ?>
                                <tr>
                                    <td><span class="trim"><?= $row->title; ?></span></td>
                                    <?= $btn_status ?>
                                    <td><?= $row->b_publisher; ?></td>
                                    <td><?= $row->tc_name; ?></td>
                                    <td>
                                        <a href="pages_staff_view_treaty.php?doc_id=<?= $row->id; ?>">
                                            <span class='uk-badge uk-badge-success'>View</span>
                                        </a>
                                        <a href="pages_staff_edit_treaty.php?doc_id=<?= $row->id; ?>">
                                            <span class='uk-badge uk-badge-primary'>Update</span>
                                        </a>

                                    </td>
                                </tr>

                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
    <!--Footer-->
    <?php require_once('assets/inc/footer.php'); ?>
    <!--Footer-->

    <!-- google web fonts -->
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

    <!-- page specific plugins -->
    <!-- datatables -->
    <script src="bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
    <!-- datatables buttons-->
    <script src="bower_components/datatables-buttons/js/dataTables.buttons.js"></script>
    <script src="assets/js/custom/datatables/buttons.uikit.js"></script>
    <script src="bower_components/jszip/dist/jszip.min.js"></script>
    <script src="bower_components/pdfmake/build/pdfmake.min.js"></script>
    <script src="bower_components/pdfmake/build/vfs_fonts.js"></script>
    <script src="bower_components/datatables-buttons/js/buttons.colVis.js"></script>
    <script src="bower_components/datatables-buttons/js/buttons.html5.js"></script>
    <script src="bower_components/datatables-buttons/js/buttons.print.js"></script>

    <!-- datatables custom integration -->
    <script src="assets/js/custom/datatables/datatables.uikit.min.js"></script>

    <!--  datatables functions -->
    <script src="assets/js/pages/plugins_datatables.min.js"></script>
</body>

</html>