<?php
session_start();
include('assets/config/config.php');
include('assets/config/checklogin.php');
check_login();
//generate random student number
$length = 5;
$Number =  substr(str_shuffle('0123456789'), 1, $length);

//create a librarian account
if (isset($_POST['update_staff'])) {

    $id = $_GET['id'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $adr = $_POST['adr'];
    $bio = $_POST['bio'];
    $acc_status = $_POST['acc_status'];

    //Insert Captured information to a database table
    $query = "UPDATE tbl_staff SET name = ?, phone = ?, adr = ?, bio = ?, acc_status = ? WHERE id = ? ";
    $stmt = $mysqli->prepare($query);
    //bind parameters
    $rc = $stmt->bind_param('sssssi', $name, $phone, $adr, $bio, $acc_status, $id);
    $stmt->execute();

    //declare a variable which will be passed to alert function
    if ($stmt) {
        $success = 'Staff Account Updated' && header("refresh:1;url=treaty_sudo_upload_manage_access.php");
    } else {
        $err = "Please Try Again Or Try Later" && header("refresh:1;url=treaty_sudo_upload_manage_access.php");;
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
    $id = $_GET['id'];
    $ret = "SELECT * FROM tbl_staff WHERE id = ?";
    $stmt = $mysqli->prepare($ret);
    $stmt->bind_param('s', $id);
    $stmt->execute(); //ok
    $res = $stmt->get_result();
    while ($row = $res->fetch_object()) {
    ?>
        <div id="page_content">
            <!--Breadcrums-->
            <div id="top_bar">
                <ul id="breadcrumbs">
                    <li><a href="pages_sudo_dashboard.php">Dashboard</a></li>
                    <li><a href="treaty_sudo_upload_manage_access.php">Manage Access</a></li>
                    <li><span>Update <?= $row->name; ?>'s' Account</span></li>
                </ul>
            </div>

            <div id="page_content_inner">

                <div class="md-card">
                    <div class="md-card-content">
                        <h3 class="heading_a">Please Fill All Fields</h3>
                        <hr>
                        <form method="post">
                            <div class="uk-grid" data-uk-grid-margin>
                                <div class="uk-width-medium-1-2">
                                    <div class="uk-form-row">
                                        <label>Full Name</label>
                                        <input type="text" value="<?= $row->name; ?>" required name="name" class="md-input" />
                                    </div>
                                    <div class="uk-form-row">
                                        <label>Email Address</label>
                                        <input type="email" value="<?= $row->email; ?>" required readonly name="email" class="md-input" />
                                    </div>
                                    <div class="uk-form-row">
                                        <label>Phone Number</label>
                                        <input type="tel" required value="<?= $row->phone; ?>" name="phone" class="md-input" />
                                    </div>
                                </div>

                                <div class="uk-width-medium-1-2">
                                    <div class="uk-form-row">
                                        <label>Staff ID Number</label>
                                        <input type="text" value="<?= $row->number; ?>" required readonly class="md-input label-fixed" name="number" />
                                    </div>
                                    <div class="uk-form-row">
                                        <label>User Address</label>
                                        <input type="text" value="<?= $row->adr; ?>" required name="adr" class="md-input" />
                                    </div>
                                    <div class="uk-form-row">
                                        <label>Account Status</label>
                                        <select required name="acc_status" id="acc_status" class="md-input">
                                            <option value="">--Select Staff Status--</option>
                                            <option value="Active" <?php if ($row->acc_status == "Active") echo "selected"; ?>>Active</option>
                                            <option value="Suspended" <?php if ($row->acc_status == "Suspended") echo "selected"; ?>>Suspended</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="uk-width-medium-2-2">
                                    <div class="uk-form-row">
                                        <label>Staff Bio | About </label>
                                        <textarea cols="30" rows="4" class="md-input" name="bio"><?= $row->bio; ?></textarea>
                                    </div>
                                </div>
                                <div class="uk-width-medium-2-2">
                                    <div class="uk-form-row">
                                        <div class="uk-input-group">
                                            <input type="submit" class="md-btn md-btn-warning" name="update_staff" value="Update Staff Account" />
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
</body>

</html>