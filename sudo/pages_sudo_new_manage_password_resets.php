<?php
session_start();
include('assets/config/config.php');
include('assets/config/checklogin.php');
check_login();
//delete student account.
if (isset($_GET['deleteAccount'])) {
    $id = intval($_GET['deleteAccount']);
    $adn = "DELETE FROM  iL_Students  WHERE s_id = ?";
    $stmt = $mysqli->prepare($adn);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();

    if ($stmt) {
        $info = "Account Deleted";
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
                <li><a href="pages_sudo_dashboard.php">Dashboard</a></li>
                <li><a href="#">Students</a></li>
                <li><span>Manage Students</span></li>
            </ul>
        </div>
        <div id="page_content_inner">

            <h4 class="heading_a uk-margin-bottom">iLibrary Students Accounts</h4>
            <div class="md-card uk-margin-medium-bottom">
                <div class="md-card-content">
                    <div class="dt_colVis_buttons"></div>
                    <table id="dt_tableExport" class="uk-table" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>iLib Student No</th>
                                <th>Phone No.</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>Gender</th>
                                <th>Acc Status</th>
                                <th>Actions</th>
                            </tr>

                        <tbody>
                            <?php
                            $ret = "SELECT * FROM  iL_Students";
                            $stmt = $mysqli->prepare($ret);
                            $stmt->execute(); //ok
                            $res = $stmt->get_result();
                            while ($row = $res->fetch_object()) {
                                //use .danger, .warning, .success according to account status
                                if ($row->s_acc_status == 'Active') {
                                    $account_status = "<td class='uk-text-success'>$row->s_acc_status</td>";
                                } elseif ($row->s_acc_status == 'Pending') {
                                    $account_status = "<td class='uk-text-warning'>$row->s_acc_status</td>";
                                } else {
                                    $account_status = "<td class='uk-text-danger'>$row->s_acc_status</td>";
                                }
                            ?>
                                <tr>
                                    <td><?php echo $row->s_name; ?></td>
                                    <td><?php echo $row->s_number; ?></td>
                                    <td><?php echo $row->s_phone; ?></td>
                                    <td><?php echo $row->s_email; ?></td>
                                    <td><?php echo $row->s_adr; ?></td>
                                    <td><?php echo $row->s_sex; ?></td>
                                    <?php echo $account_status; ?>
                                    <td>
                                        <a href="pages_sudo_view_student.php?student_number=<?php echo $row->s_number; ?>">
                                            <span class='uk-badge uk-badge-success'>View</span>
                                        </a>
                                        <a href="pages_sudo_edit_student.php?student_number=<?php echo $row->s_number; ?>">
                                            <span class='uk-badge uk-badge-primary'>Update</span>
                                        </a>
                                        <a href="pages_sudo_manage_student.php?deleteAccount=<?php echo $row->s_id; ?>">
                                            <span class='uk-badge uk-badge-danger'>Delete</span>
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