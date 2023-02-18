<?php 
    session_start();
    include('assets/config/config.php');
    include('assets/config/checklogin.php');
    check_login();
    
    //update librarian password
    if(isset($_POST['changePassword']))
    {

        $email = $_GET['email'];
        $pass =sha1(md5($_GET['pass']));
        $pr_id = $_GET['pr_id'];
        $pr_status = $_GET['pr_status'];

        //Insert Captured information to a database table
        $query="UPDATE fmoj_staff SET pwd = ? WHERE email = ? ";
        $query1 = "UPDATE il_passwordresets SET pr_status = ? WHERE pr_id =?";
        $stmt = $mysqli->prepare($query);
        $stmt1 = $mysqli->prepare($query1);
        //bind paramaters
        $rc=$stmt->bind_param('ss', $pass, $email);
        $rc=$stmt1->bind_param('si', $pr_status, $pr_id);
        $stmt->execute();
        $stmt1->execute();
        //declare a variable which will be passed to alert function
        if($stmt && $stmt1)
        {
            $success = "Staff Account Password Reset" && header("refresh:1;url=pages_sudo_manage_staff_password_resets.php");
        }
        else 
        {
            $err = "Please Try Again Or Try Later";
        }      
    }
?>

<!doctype html>
<!--[if lte IE 9]> <html class="lte-ie9" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html lang="en"> <!--<![endif]-->
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
        $pr_id = $_GET['pr_id'];
        $ret="SELECT * FROM  il_passwordresets WHERE pr_id = ?"; 
        $stmt= $mysqli->prepare($ret) ;
        $stmt->bind_param('i', $pr_id);
        $stmt->execute() ;//ok
        $res=$stmt->get_result();
        while($row=$res->fetch_object())
        {
    ?>
        <div id="page_content">
            <!--Breadcrums-->
            <div id="top_bar">
                <ul id="breadcrumbs">
                    <li><a href="pages_sudo_dashboard.php">Dashboard</a></li>
                    <li><a href="pages_sudo_manage_librarian_password_resets.php">Password Resets</a></li>
                    <li><span>Update Password</span></li>
                </ul>
            </div>

            <div id="page_content_inner">

                <div class="md-card">
                    <div class="md-card-content">
                        <h3 class="heading_a">Please Fill All Fields</h3>
                        <hr>
                        <form method="post">
                            <div class="uk-grid" data-uk-grid-margin>
                                <div class="uk-width-medium-2-2">
                                    <div class="uk-form-row">
                                        <label>Staff Email</label>
                                        <input type="email" value="<?= $row->pr_useremail;?>" readonly required  class="md-input"  />
                                    </div>
                                    <div class="uk-form-row">
                                        <label>Staff Account New Password</label>
                                        <input type="text" required value="<?= $row->pr_dummypwd;?>" readonly  class="md-input"  />
                                    </div>
                                </div>
                                <div class="uk-width-medium-2-2">
                                    <div class="uk-form-row">
                                        <div class="uk-input-group">
                                            <input type="submit" class="md-btn md-btn-warning" name="changePassword" value="Submit" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>

    <?php }?>
    <!--Footer-->
    <?php require_once('assets/inc/footer.php');?>
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
            if(isHighDensity()) {
                $.getScript( "assets/js/custom/dense.min.js", function(data) {
                    // enable hires images
                    altair_helpers.retina_images();
                });
            }
            if(Modernizr.touch) {
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