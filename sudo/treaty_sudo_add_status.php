<?php
session_start();
include('assets/config/config.php');
include('assets/config/checklogin.php');
check_login();
//generate random librarian number
$length = 5;
$Number =  substr(str_shuffle('QWERTYUIOPLKJHGFDSAZXCVBNM'), 1, $length);

//create a Treaty Status
if (isset($_POST['add_status'])) {
    $error = 0;
    if (isset($_POST['s_name']) && !empty($_POST['s_name'])) {
        $s_name = mysqli_real_escape_string($mysqli, trim($_POST['s_name']));
    } else {
        $error = 1;
        $err = "Treaty status name cannot be empty";
    }
    if (isset($_POST['s_desc']) && !empty($_POST['s_desc'])) {
        $s_desc = mysqli_real_escape_string($mysqli, trim($_POST['s_desc']));
    } else {
        $error = 1;
        $err = "Treaty status description cannot be empty";
    }

    if (!$error) {
        $sql = "SELECT * FROM tbl_status WHERE name='$s_name' ";
        $res = mysqli_query($mysqli, $sql);
        if (mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            if ($s_name == $row['s_name']) {
                $err =  "Treaty Status name already exists";
            } else {
                $err =  "Treaty Status code already exists";
            }
        } else {
            $s_name = $_POST['s_name'];
            $s_desc = $_POST['s_desc'];

            //Insert Captured information to a database table
            $query = "INSERT INTO tbl_status (name, description) VALUES (?,?)";
            $stmt = $mysqli->prepare($query);
            //bind paramaters
            $rc = $stmt->bind_param('ss', $s_name, $s_desc);
            $stmt->execute();

            //declare a variable which will be passed to alert function
            if ($stmt) {
                $success = "Treaty Status Added";
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
                <li><a href="treaty_sudo_manage_status.php">Treaty Status</a></li>
                <li><span>Manage Treaty Status</span></li>
            </ul>
        </div>

        <div id="page_content_inner">
            <div class="space-50"></div>
            <div class="md-card">
                <div class="md-card-content">
                    <h3 class="heading_a">Please Fill All Fields</h3>
                    <hr>
                    <form method="post">
                        <div class="uk-grid" data-uk-grid-margin>
                            <div class="uk-width-medium-2-2">
                                <div class="uk-form-row">
                                    <label>Status Name</label>
                                    <input type="text" required name="s_name" class="md-input" />
                                </div>

                                <div class="uk-form-row">
                                    <label>Status Description</label>
                                    <textarea cols="30" rows="4" class="md-input" name="s_desc"></textarea>
                                </div>
                            </div>
                            <div class="uk-width-medium-2-2">
                                <div class="uk-form-row">
                                    <div class="uk-input-group">
                                        <input type="submit" class="md-btn md-btn-success" name="add_status" value="Create Status" />
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

</body>

</html>