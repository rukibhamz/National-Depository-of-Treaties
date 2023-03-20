<?php
/*
        *   Handle staff Authentication Logic Here
    */

session_start();
$_SESSION['loading'] = false;
include('assets/config/config.php');
$is_validated = false;
// VALIDATE TOKEN
if (isset($_GET['validate_token'])) {
    $pr_token = $_GET['validate_token'];

    // Query the database to check if the token exists and is valid
    $query = "SELECT pr_token FROM il_passwordresets WHERE pr_token = ? AND pr_status = 'Pending' LIMIT 1";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('s', $pr_token);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows == 1) {
        $success = "Token is valid";
        $is_validated = true;
    } else {
        $err = "Invalid Token";
    }
}

//RESET PASSWORD 
if (isset($_POST['change_pwd_btn'])) {
    $error = 0;
    if (isset($_POST['new_pwd']) && !empty($_POST['new_pwd'])) {
        $new_pwd = $_POST['new_pwd'];

        // Check if password is alphanumeric
        if (!ctype_alnum($new_pwd)) {
            $error = 1;
            $err = "Password should only contain letters and numbers";
        }

        if (isset($_POST['c_new_pwd']) && !empty($_POST['c_new_pwd'])) {
            $confirm_pwd = $_POST['c_new_pwd'];

            // Check if confirm password matches new password
            if ($new_pwd !== $confirm_pwd) {
                $error = 1;
                $err = "Passwords do not match";
            }

            // Check if there were no validation errors
            if (!$error) {
                // Query the database to check if the token exists and is valid
                $query = "SELECT pr_useremail FROM il_passwordresets WHERE pr_token = ? AND pr_status = 'Pending' LIMIT 1";
                $stmt = $mysqli->prepare($query);
                $stmt->bind_param('s', $pr_token);
                $stmt->execute();
                $result_set = $stmt->get_result();

                if ($result_set->num_rows == 1) {
                    $row = $result_set->fetch_assoc();
                    $pr_useremail = $row['pr_useremail'];
                    $hash_pwd = sha1(md5($new_pwd));

                    // Query to update password in the database tbl_staff
                    $query = "UPDATE tbl_staff SET pwd=? WHERE email=?";
                    $stmt = $mysqli->prepare($query);
                    $stmt->bind_param('ss', $hash_pwd, $pr_useremail);
                    $stmt->execute();

                    // Query to update the pr_status column in il_passwordresets table to "Changed"
                    $query = "UPDATE il_passwordresets SET pr_status = 'Changed' WHERE pr_token = ?";
                    $status_stmt = $mysqli->prepare($query);
                    $status_stmt->bind_param('s', $pr_token);

                    $status_stmt->execute();

                    $success = "Password Successfully Changed" && header("refresh:1;url=pages_staff_index.php");
                } else {
                    $err = "Error Changing Password";
                }
            }
        } else {
            $error = 1;
            $err = "Confirm Password cannot be empty";
        }
    } else {
        $error = 1;
        $err = "Password cannot be empty";
    }
}

?>
<!doctype html>
<!--[if lte IE 9]> <html class="lte-ie9" lang="en"> <![endif]-->
<!--[if gt IE 9]><!-->
<html lang="en">
<!--<![endif]-->

<?php
//load head partial
include("assets/inc/head.php");
?>

<body class="login_page">

    <?php if ($is_validated == true) : ?>
        <div class="login_page_wrapper">
            <div class="md-card" id="login_card">
                <div class="md-card-content large-padding" id="login_form">
                    <div class="login_heading">
                        <h3 class="text">Change Password Portal</h3>
                    </div>


                    <div class="md-card-content large-padding" id="change_pwd">
                        <form method="POST">
                            <div class="uk-form-row password_level">
                                <label for="new_pwd">New Password</label>
                                <input class="md-input" required type="password" id="new_pwd" name="new_pwd" minlength="4" />
                                <span class="uk-form-password-toggle password_toggle" onclick="handleToggle('new_pwd')">&#128065;</span>
                            </div>

                            <div class="uk-form-row password_level">
                                <label for="c_new_pwd">Confirm Password</label>
                                <input class="md-input" required type="password" id="c_new_pwd" name="c_new_pwd" minlength="4" />
                                <span class="uk-form-password-toggle password_toggle" onclick="handleToggle('c_new_pwd')">&#128065;</span>
                            </div>

                            <div id="loading-spinner" style="display:none;">
                                <input type="button" class="md-btn md-btn-success md-btn-block md-btn-large" value="Loading..." type="button" disabled id="loading" />
                            </div>

                            <div class="uk-margin-medium-top">
                                <input type="submit" value="Change password" name="change_pwd_btn" id="change_pwd_btn" class="md-btn md-btn-success md-btn-block" />
                            </div>
                        </form>
                    </div>

                </div>


            </div>
        </div>
    <?php endif; ?>

    <!-- IF TOKEN IS NOT VALIDATED -->
    <?php if ($is_validated == false) : ?>
        <p>Hi Joyce</p>
    <?php endif; ?>
    <!--Footer-->
    <?php require_once('assets/inc/footer.php'); ?>
    <!--Footer-->

    <!-- common functions -->
    <script src="assets/js/common.min.js"></script>
    <!-- uikit functions -->
    <script src="assets/js/uikit_custom.min.js"></script>
    <!-- altair core functions -->
    <script src="assets/js/altair_admin_common.min.js"></script>

    <!-- altair login page functions -->
    <script src="assets/js/pages/login.min.js"></script>

    <script>
        // check for theme
        if (typeof(Storage) !== "undefined") {
            var root = document.getElementsByTagName('html')[0],
                theme = localStorage.getItem("altair_theme");
            if (theme == 'app_theme_dark' || root.classList.contains('app_theme_dark')) {
                root.className += ' app_theme_dark';
            }
        }
    </script>
    <script>
        // toggle password
        const handleToggle = (id) => {
            let input = document.getElementById(id);
            input.type = input.type === "text" ? "password" : "text";
        }
        const button = document.getElementById('change_pwd_btn');
        const loadingSpinner = document.getElementById('loading-spinner');

        button.addEventListener('click', function() {
            button.style.display = 'none';
            loadingSpinner.style.display = 'block';
        });
    </script>

</body>

</html>