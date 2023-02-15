<?php
session_start();
include('assets/config/config.php');
include('assets/config/checklogin.php');
check_login();
//generate random librarian number
$length = 3;
$Number =  substr(str_shuffle('0123456789'), 1, $length);

//create a librarian account
if (isset($_POST['add_staff'])) {
    $error = 0;
    if (isset($_POST['staff_name']) && !empty($_POST['staff_name'])) {
        $l_name = mysqli_real_escape_string($mysqli, trim($_POST['staff_name']));
    } else {
        $error = 1;
        $err = "Staff name cannot be empty";
    }
    if (isset($_POST['email']) && !empty($_POST['email'])) {
        $l_email = mysqli_real_escape_string($mysqli, trim($_POST['email']));
    } else {
        $error = 1;
        $err = "Staff email cannot be empty";
    }
    if (isset($_POST['staff_number']) && !empty($_POST['staff_number'])) {
        $l_number = mysqli_real_escape_string($mysqli, trim($_POST['staff_number']));
    } else {
        $error = 1;
        $err = "Staff number cannot be empty";
    }
    if (!$error) {
        $sql = "SELECT * FROM  fmoj_staff WHERE  staff_number='$l_number' || email ='$l_email' ";
        $res = mysqli_query($mysqli, $sql);
        if (mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            if ($l_number == $row['l_number']) {
                $err = "Staff number already exists";
            } else {
                $err = "Staff email already exists";
            }
        } else {

            $l_number = $_POST['staff_number'];
            $l_name = $_POST['staff_name'];
            $l_phone = $_POST['phone'];
            $l_email = $_POST['email'];
            $l_pwd = sha1(md5($_POST['pwd']));
            $l_adr = $_POST['adr'];
            $l_bio = $_POST['bio'];
            $l_acc_status = $_POST['acc_status'];

            //Insert Captured information to a database table
            $query = "INSERT INTO fmoj_staff (staff_number, staff_name, phone, email, pwd, adr, bio, acc_status) VALUES (?,?,?,?,?,?,?,?)";
            $stmt = $mysqli->prepare($query);
            //bind paramaters
            $rc = $stmt->bind_param('ssssssss', $l_number, $l_name, $l_phone, $l_email, $l_pwd, $l_adr, $l_bio, $l_acc_status);
            $stmt->execute();

            //declare a varible which will be passed to alert function
            if ($stmt) {
                $success = "Staff Account Created";
            } else {
                $err = "Please Try Again Or Try Later";
            }
        }
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
                <li><a href="#">Upload Access</a></li>
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
                                    <input type="text" required name="staff_name" class="md-input" />
                                </div>
                                <div class="uk-form-row">
                                    <label>Email Address</label>
                                    <input type="email" required name="email" class="md-input" />
                                </div>
                                <div class="uk-form-row">
                                    <label>Phone Number</label>
                                    <input type="text" required name="acc_status" class="md-input" />
                                </div>
                                <div class="uk-form-row">
                                    <label>Password</label>
                                    <input type="password" requied name="adr" class="md-input" />
                                </div>
                            </div>

                            <div class="uk-width-medium-1-2">
                                <div class="uk-form-row">
                                    <label>Staff ID Number</label>
                                    <input type="text" required readonly value="FMOJ-<?php echo $Number; ?>" name="staff_number" class="md-input label-fixed" />
                                </div>
                                <div class="uk-form-row">
                                    <label>User Address</label>
                                    <input type="text" required name="addr" class="md-input" />
                                </div>
                                <div class="uk-form-row">
                                    <label>Short Description Bio</label>
                                    <input type="text" required name="bio" class="md-input" />
                                    <!-- <textarea cols="30" required rows="3" class="md-input" name="l_bio"></textarea> -->
                                </div>
                                <div class="uk-form-row">
                                    <label>Account Status</label>
                                    <input type="text" required name="acc_status" class="md-input" />
                                </div>
                            </div>
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