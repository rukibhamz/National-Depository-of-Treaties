<?php
/*
        *   Handle staff Authentication Logic Here
    */

session_start();
$_SESSION['loading'] = false;
include('assets/config/config.php');

//password reset token

//signin


//reset password
if (isset($_POST['pwd_reset'])) {
    $pr_token = $_POST['pr_token'];
    
    //Query the database to check if the token exists and is valid
    $query = "SELECT pr_token FROM il_passwordresets WHERE pr_token = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('s', $pr_token);
    $stmt->execute();
    $stmt->bind_result($pr_token); //bind result
    $rs = $stmt->fetch();
    
    
    if ($rs) {
        $success = "Token is valid";
    } else {
        $err = "Invalid Token";
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
                    <h3 class="text">Password Reset portal</h3>
                </div>
                
            
            <div class="md-card-content large-padding" id="login_form">
                <form method="POST">
                    <div class="uk-form-row">
                        <label for="login_email_reset">Input Token</label>
                        <input class="md-input" required name="pr_tokem" type="text" id="login_email_reset" />
                    </div>
                    <div class="uk-margin-medium-top">
                        <input type="submit" value="Reset password" name="pwd_reset" class="md-btn md-btn-success md-btn-block" />
                    </div>
                </form>
            </div>

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