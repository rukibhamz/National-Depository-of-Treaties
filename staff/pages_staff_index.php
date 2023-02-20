<?php
/*
        *   Handle staff Authentication Logic Here
    */

session_start();
$_SESSION['loading'] = false;
include('assets/config/config.php');

//password reset token
$length = 20;
$token =  substr(str_shuffle('0123456789QWERTYUIOPLKJHGFDSAZXCVBNM'), 1, $length);
$ln = 6;
$dummy_pwd =  substr(str_shuffle('0123456789QWERTYUIOPLKJHGFDSAZXCVBNM'), 1, $ln);

//signin
if (isset($_POST['staff_login'])) {
    $_SESSION['loading'] = true;
    $l_email = $_POST['l_email'];
    $l_pwd = sha1(md5($_POST['l_pwd'])); //double encrypt to increase security
    print_r($l_email,$l_pwd);
    $stmt = $mysqli->prepare("SELECT email, number, pwd, id  FROM tbl_staff  WHERE (email=? || number =?) AND pwd=?"); //sql to log in user
    $stmt->bind_param('sss', $l_email, $l_email, $l_pwd); //bind fetched parameters
    $stmt->execute(); //execute bind
    $stmt->bind_result($l_email, $l_email, $l_pwd, $id); //bind result
    $rs = $stmt->fetch();
    $_SESSION['id'] = $id; //assaign session to sudo id

    if ($rs) {
        //if its sucessfull
        header("location:pages_staff_dashboard.php");
        $_SESSION['loading'] = false;
    } else {
        $err = "Access Denied Please Check Your Credentials";
        $_SESSION['loading'] = false;
    }
}

//reset password
if (isset($_POST['Reset_pwd'])) {

    $pr_useremail = $_POST['pr_useremail'];
    $pr_usertype = $_POST['pr_usertype'];
    $pr_token = sha1(md5($_POST['pr_token']));
    $pr_dummypwd = $_POST['pr_dummypwd'];
    $pr_status = $_POST['pr_status'];

    //Insert Captured information to a database table
    $query = "INSERT INTO il_passwordresets (pr_useremail, pr_usertype, pr_dummypwd, pr_token, pr_status) VALUES (?,?,?,?,?)";
    $stmt = $mysqli->prepare($query);
    //bind parameters
    $rc = $stmt->bind_param('sssss', $pr_useremail, $pr_usertype, $pr_dummypwd, $pr_token, $pr_status);
    $stmt->execute();

    //declare a variable which will be passed to alert function
    if ($stmt) {
        $success = "Password Reset Instructions has been sent to the administrator";
    } else {
        $err = "Please Try Again Or Try Later";
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

    <div class="login_page_wrapper">
        <div class="md-card" id="login_card">
            <div class="md-card-content large-padding" id="login_form">
                <div class="login_heading">
                    <h3 class="text">Upload treaties portal</h3>
                </div>
                <form method="post">
                    <div class="uk-form-row">
                        <label for="login_username">Email or Staff Number</label>
                        <input class="md-input" required type="text" id="login_username" name="l_email" />
                    </div>

                    <div class="uk-form-row password_level">
                        <label for="login_password">Password</label>
                        <input class="md-input" required type="password" id="login_password" name="l_pwd" />
                        <span class="uk-form-password-toggle password_toggle" onclick="handleToggle('login_password')">&#128065;</span>
                    </div>

                    <div class="uk-margin-medium-top">
                            <div id="loading-spinner" style="display:none;">
                                <input type="button" class="md-btn md-btn-success md-btn-block md-btn-large" value="Logging in..." type="button" disabled id="loading" />
                            </div>
                            
                        <input type="submit" id="staff_login" name="staff_login" value="Sign In to Upload" class="md-btn md-btn-success md-btn-block md-btn-large" />
                    </div>

                </form>
            </div>
            <div class="md-card-content large-padding uk-position-relative" id="register_form" style="display: none">
                <button type="button" class="uk-position-top-right uk-close uk-margin-right uk-margin-top back_to_login"></button>
                <h2 class="heading_b uk-text-success">Can't log in?</h2>
                <p>Here’s the info to get you back in to your account as quickly as possible.</p>
                <p>First, try the easiest thing: if you remember your password but it isn’t working, make sure that Caps
                    Lock is turned off, and that your username is spelled correctly, and then try again.</p>
                <p>If your password still isn’t working, it’s time to <a href="#" id="password_reset_show">Reset Your Staff
                        password</a>.</p>
            </div>
            <div class="md-card-content large-padding" id="login_password_reset" style="display: none">
                <button type="button" class="uk-position-top-right uk-close uk-margin-right uk-margin-top back_to_login"></button>
                <h2 class="heading_a uk-margin-large-bottom">Reset password</h2>
                <form method="POST">
                    <div class="uk-form-row">
                        <label for="login_email_reset">Your email address</label>
                        <input class="md-input" required name="pr_useremail" type="email" id="login_email_reset" />
                    </div>
                    <div class="uk-form-row" style="display:none">
                        <label for="login_email_reset">User Type</label>
                        <input class="md-input" name="pr_usertype" value="Staff" type="text" id="login_email_reset" />
                    </div>
                    <div class="uk-form-row" style="display:none">
                        <label for="login_email_reset">Token</label>
                        <input class="md-input" name="pr_token" value="<?= $token; ?>" type="text" id="login_email_reset" />
                    </div>
                    <div class="uk-form-row" style="display:none">
                        <label for="login_email_reset">New Password</label>
                        <input class="md-input" name="pr_dummypwd" value="<?= $dummy_pwd; ?>" type="text" id="login_email_reset" />
                    </div>
                    <div class="uk-form-row" style="display:none">
                        <label for="login_email_reset">Reset Status</label>
                        <input class="md-input" name="pr_status" value="Pending" type="text" id="login_email_reset" />
                    </div>
                    <div class="uk-margin-medium-top">
                        <input type="submit" value="Reset password" name="Reset_pwd" class="md-btn md-btn-success md-btn-block" />
                    </div>
                </form>
            </div>

        </div>

        <div class="uk-margin-top uk-text-center">
            <a href="#" id="signup_form_show">Forgot Password</a>
        </div>
        <div class="uk-margin-top uk-text-center">
            <a href="../">Home</a>
        </div>
    </div>
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
        var button = document.getElementById('staff_login');
        var loadingSpinner = document.getElementById('loading-spinner');

        button.addEventListener('click', function() {
            button.style.display = 'none';
            loadingSpinner.style.display = 'block';
        });
    </script>

</body>

</html>