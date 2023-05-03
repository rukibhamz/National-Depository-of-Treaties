<?php
session_start();
include('assets/config/config.php');
include('assets/config/checklogin.php');
check_login();
//generate staff number

// Get the last staff ID from the database
// Query to find the last staff number entry in the table
$sql = "SELECT number FROM tbl_staff ORDER BY id DESC LIMIT 1";
$res = mysqli_query($mysqli, $sql);

if ($res) {
    $row = mysqli_fetch_assoc($res);
    $num = intval(substr($row['number'], 5)) + 1;
    $num_str = str_pad($num, 4, "0", STR_PAD_LEFT);
    $new_staff_id = "FMOJ-" . $num_str;
    $sql = "SELECT * FROM tbl_staff WHERE number = '$new_staff_id'";
    $res = mysqli_query($mysqli, $sql);
    if ($res && mysqli_num_rows($res) > 0) {
        // If the new staff ID already exists in the database, generate a new one
        mysqli_free_result($res);
        $num += 1;
        $num_str = str_pad($num, 4, "0", STR_PAD_LEFT);
        $new_staff_id = "FMOJ-" . $num_str;
    }
    $Number = $new_staff_id;
} else {
    // If the query fails, use FMOJ-0002 as the staff number
    $Number = "FMOJ-0002";
}

//create a staff account
if (isset($_POST['add_uploader'])) {
    $error = 0;
    if (isset($_POST['name']) && !empty($_POST['name'])) {
        $s_name = mysqli_real_escape_string($mysqli, trim($_POST['name']));
    } else {
        $error = 1;
        $err = "Staff name cannot be empty";
    }
    if (isset($_POST['email']) && !empty($_POST['email'])) {
        $s_email = mysqli_real_escape_string($mysqli, trim($_POST['email']));
    } else {
        $error = 1;
        $err = "Staff email cannot be empty";
    }
    if (isset($_POST['phone']) && !empty($_POST['phone'])) {
        $s_phone = mysqli_real_escape_string($mysqli, trim($_POST['phone']));
    } else {
        $error = 1;
        $err = "Staff phone number cannot be empty";
    }
    if (isset($_POST['acc_status']) && !empty($_POST['acc_status'])) {
        $s_acc_status = mysqli_real_escape_string($mysqli, trim($_POST['acc_status']));
    } else {
        $error = 1;
        $err = "Staff status cannot be empty";
    }

    if (!$error) {
        // count the number of active staff accounts
        $count_query = "SELECT COUNT(*) as count FROM tbl_staff WHERE acc_status = 'active'";
        $count_result = mysqli_query($mysqli, $count_query);
        $count_row = mysqli_fetch_assoc($count_result);
        $active_count = $count_row['count'];

        // if ($active_count < 2) {
        $sql = "SELECT * FROM tbl_staff WHERE email = '$email' OR name = '$name' OR number = '$number'";
        $res = mysqli_query($mysqli, $sql);
        if (mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            if ($number == $row['number']) {
                $err = "Staff number already exists";
            } else if ($email == $row['email']) {
                $err = "Staff email already exists";
            } else {
                $err = "Staff name already exists";
            }
        } else {

            $s_name = $_POST['name'];
            $s_email = $_POST['email'];
            $s_phone = $_POST['phone'];
            $s_pwd = sha1(md5($_POST['pwd']));
            $s_number = $_POST['number'];
            $s_adr = $_POST['adr'];
            $s_bio = $_POST['bio'];
            $s_acc_status = $_POST['acc_status'];

            // $s_pic = $_FILES["p_pic"]["name"];
            // move_uploaded_file($_FILES["p_pic"]["tmp_name"], "assets/profile_img/" . $_FILES["p_pic"]["name"]);

            //Insert Captured information to a database table
            $query = "INSERT INTO tbl_staff (name, email, phone, pwd, number, adr, bio, acc_status) VALUES (?,?,?,?,?,?,?,?)";
            $stmt = $mysqli->prepare($query);
            //bind parameters
            $rc = $stmt->bind_param('ssssssss', $s_name, $s_email, $s_phone, $s_pwd, $s_number, $s_adr, $s_bio, $s_acc_status);
            $stmt->execute();

            //declare a variable which will be passed to alert function
            if ($stmt) {
                $success = "Staff Account Created";
            } else {
                $err = "Please Try Again Or Try Later";
            }
        }
        // } else {
        //     $err = "Cannot create new staff account. The maximum number of (2) active staff accounts has been reached.";
        // }
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
        <!--Breadcrums-->
        <div id="top_bar">
            <ul id="breadcrumbs">
                <li><a href="pages_sudo_dashboard.php">Dashboard</a></li>
                <li><a href="treaty_sudo_upload_manage_access.php">Manage Access</a></li>
                <li><span>Add New Uploader</span></li>
            </ul>
        </div>

        <div id="page_content_inner">
            <h3 class="heading_a text">Please Fill All Fields</h3>
            <div class="md-card">
                <div class="md-card-content">
                    <hr>
                    <form method="post">
                        <div class="uk-grid" data-uk-grid-margin>
                            <div class="uk-width-medium-1-2">
                                <div class="uk-form-row">
                                    <label>Full Name</label>
                                    <input type="text" required name="name" class="md-input" />
                                </div>
                                <div class="uk-form-row">
                                    <label>Email Address</label>
                                    <input type="email" required name="email" class="md-input" />
                                </div>
                                <div class="uk-form-row">
                                    <label>Phone Number</label>
                                    <input type="tel" required name="phone" class="md-input" />
                                </div>
                                <div class="uk-form-row">
                                    <label>Password</label>
                                    <input type="password" required name="pwd" class="md-input" />
                                </div>
                            </div>

                            <div class="uk-width-medium-1-2">
                                <div class="uk-form-row">
                                    <label>Staff ID Number</label>
                                    <input type="text" required readonly value="<?= $Number; ?>" name="number" class="md-input label-fixed" />
                                </div>
                                <div class="uk-form-row">
                                    <label>User Address</label>
                                    <input type="text" required name="adr" class="md-input" autocomplete="street-address" />
                                </div>
                                <div class="uk-form-row">
                                    <label>Short Description Bio</label>
                                    <input type="text" required name="bio" class="md-input" />
                                    <!-- <textarea cols="30" required rows="3" class="md-input" name="l_bio"></textarea> -->
                                </div>
                                <div class="uk-form-row">
                                    <label>Account Status</label>
                                    <select required name="acc_status" id="acc_status" class="md-input">
                                        <option value="" disabled selected>--Select Staff Status--</option>
                                        <option value="active">Active</option>
                                        <option value="inactive">Suspended</option>
                                    </select>

                                </div>
                            </div>


                            <!-- <div class="uk-width-medium-2-2">
                                <div id="file_upload-drop" class="uk-file-upload">
                                    <p class="uk-text">Upload Profile Picture</p>
                                    <p class="uk-text-muted uk-text-small uk-margin-small-bottom">or</p>
                                    <a class="uk-form-file md-btn">choose file<input id="file_upload-select" required name="p_pic" type="file" accept="image/*"></a>
                                </div>
                                <div id="file_upload-progressbar" class="uk-progress uk-hidden">
                                    <div class="uk-progress-bar" style="width:100%">0%</div>
                                </div>
                            </div> -->

                            <div class="uk-width-medium-2-2">
                                <div class="uk-form-row">
                                    <div class="uk-input-group">
                                        <input type="submit" class="md-btn md-btn-success" name="add_uploader" value="Create User Account" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
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

    <script src="assets/js/altair_admin_common.min.js"></script>
</body>

</html>