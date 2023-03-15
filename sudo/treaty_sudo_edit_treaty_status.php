<?php
session_start();
include('assets/config/config.php');
include('assets/config/checklogin.php');
check_login();

//update a book category
// if (isset($_POST['update_treaty_status'])) {
//     $status_id = $_GET['id'];
//     $s_name = $_POST['name'];
//     $s_desc = $_POST['desc'];

//     //Insert Captured information to a database table
//     $query = "UPDATE tbl_status SET name=?, description=? WHERE id =?";
//     $stmt = $mysqli->prepare($query);
//     //bind parameters
//     $rc = $stmt->bind_param('ssi',  $s_name, $s_desc, $status_id);
//     $stmt->execute();

//     //declare a variable which will be passed to alert function
//     if ($stmt) {
//         $success = "Treaty Status Updated" && header("refresh:1;url=treaty_sudo_manage_status.php");
//     } else {
//         $err = "Please Try Again Or Try Later";
//     }
// }
if (isset($_POST['update_treaty_status'])) {
    $status_id = $_GET['id'];
    $s_name = $_POST['name'];
    $s_desc = $_POST['desc'];

    // Update the tbl_status table
    $query_status = "UPDATE tbl_status SET name=?, description=? WHERE id =?";
    $stmt_status = $mysqli->prepare($query_status);
    //bind parameters
    $rc = $stmt_status->bind_param('ssi',  $s_name, $s_desc, $status_id);
    $stmt_status->execute();

    // Update the tbl_treaties table
    $query_treaty = "UPDATE tbl_treaties SET s_id=?, s_status=? WHERE s_id=?";
    $stmt_treaty = $mysqli->prepare($query_treaty);
    $rc = $stmt_treaty->bind_param('isi', $status_id, $s_name, $status_id);
    $stmt_treaty->execute();

    //declare a variable which will be passed to alert function
    if ($stmt_status && $stmt_treaty) {
        $success = "Treaty Status Updated" && header("refresh:1;url=treaty_sudo_manage_status.php");
    } else {
        $err = "Please Try Again Or Try Later";
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
    <?php
    $status_id = $_GET['id'];
    $ret = "SELECT * FROM  tbl_status WHERE id = ?";
    $stmt = $mysqli->prepare($ret);
    $stmt->bind_param('s', $status_id);
    $stmt->execute(); //ok
    $res = $stmt->get_result();
    while ($row = $res->fetch_object()) {
    ?>
        <div id="page_content">
            <!--Breadcrums-->
            <div id="top_bar">
                <ul id="breadcrumbs">
                    <li><a href="pages_sudo_dashboard.php">Dashboard</a></li>
                    <li><a href="treaty_sudo_manage_status.php">Treaty Status</a></li>
                    <li><span>Update <?php echo $row->name; ?></span></li>
                </ul>
            </div>

            <div id="page_content_inner">
                <div class="space-30"></div>
                <div class="md-card">
                    <div class="md-card-content">
                        <h3 class="heading_a">Please Fill All Fields</h3>
                        <hr>
                        <form method="post">
                            <div class="uk-grid" data-uk-grid-margin>
                                <div class="uk-width-medium-2-2">
                                    <div class="uk-form-row">
                                        <label>Status Name</label>
                                        <input type="text" required name="name" value="<?= $row->name; ?>" class="md-input" />
                                    </div>

                                    <div class="uk-form-row">
                                        <label>Status Description</label>
                                        <textarea cols="30" rows="4" class="md-input" name="desc"><?php echo $row->description; ?></textarea>
                                    </div>
                                </div>
                                <div class="uk-width-medium-2-2">
                                    <div class="uk-form-row">
                                        <div class="uk-input-group">
                                            <input type="submit" class="md-btn md-btn-success" name="update_treaty_status" value="Update Treaty Status" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>

    <?php } ?>
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
    <script src="assets/js/altair_admin_common.min.js"></script>
</body>

</html>