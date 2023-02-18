<?php
    session_start();
    include('assets/config/config.php');
    include('assets/config/checklogin.php');
    check_login();

    //update staff account
    if(isset($_POST['staff_update']))
    {

        $id = $_SESSION['l_id'];
        $l_name =$_POST['l_name'];
        $l_phone = $_POST['l_phone'];
        $l_email = $_POST['l_email'];
        $l_bio = $_POST['l_bio'];
        $pic  = $_FILES["pic"]["name"];
        move_uploaded_file($_FILES["pic"]["tmp_name"],"../sudo/assets/img/avatars/librarians/".$_FILES["pic"]["name"]);
        $l_pwd= sha1(md5($_POST['l_pwd']));
        //$number = $_POST['number'];
        
        //Insert Captured information to a database table
        $query="UPDATE  tbl_staff SET l_name = ?, l_phone = ?, l_email = ?,  l_bio = ?, pic = ?, l_pwd =? WHERE l_id = ? ";
        $stmt = $mysqli->prepare($query);
        //bind paramaters
        $rc=$stmt->bind_param('ssssssi', $l_name, $l_phone, $l_email, $l_bio, $pic, $l_pwd, $id);
        $stmt->execute();
  
        //declare a varible which will be passed to alert function
        if($stmt)
        {
            $success = "Details Updated" && header("refresh:1;url=pages_staff_profile.php");
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

            $id = $_SESSION['l_id'];
            $ret="SELECT * FROM  tbl_staff  WHERE id = ? "; 
            $stmt= $mysqli->prepare($ret) ;
            $stmt->bind_param('i', $id);
            $stmt->execute() ;//ok
            $res=$stmt->get_result();
            while($row=$res->fetch_object())
            {
                //set automatically logged in user default image if they have not updated their pics
                if($row->pic == '')
                {
                    $profile_picture = "

                        <img src='../sudo/assets/img/avatars/user_icon.png' alt='User Image'>
                        ";
                }
                else
                {
                    $profile_picture = 
                    "
                        <img src='../sudo/assets/img/avatars/librarians/$row->pic' alt='user avatar'/>
                    ";
                }

        ?>
    <!-- main sidebar end -->
        <div id="page_content">
            <div id="page_content_inner">
                <form method="post" enctype="multipart/form-data" class="uk-form-stacked" id="user_edit_form">
                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-large-10-10">
                            <div class="md-card">
                                <div class="user_heading" data-uk-sticky="{ top: 48, media: 960 }">
                                    <div class="user_heading_avatar fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail">
                                            <?php
                                                //profile picture
                                                echo $profile_picture;
                                            ?>
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                        <div class="user_avatar_controls">
                                            <span class="btn-file">
                                                <span class="fileinput-new"><i class="material-icons">&#xE2C6;</i></span>
                                                <span class="fileinput-exists"><i class="material-icons">&#xE86A;</i></span>
                                                <input type="file" name="pic">
                                            </span>
                                            <a href="#" class="btn-file fileinput-exists" data-dismiss="fileinput"><i class="material-icons">&#xE5CD;</i></a>
                                        </div>
                                    </div>
                                    <div class="user_heading_content">
                                        <h2 class="heading_b"><span class="uk-text-truncate" id="user_edit_uname"><?= $row->name;?></span><span class="sub-heading" id="user_edit_position">Staff @Fmoj</span></h2>
                                    </div>

                                </div>
                                <div class="user_content">
                                    <ul id="user_edit_tabs" class="uk-tab" data-uk-tab="{connect:'#user_edit_tabs_content'}">
                                        <li class="uk-active"><a href="#"><?= $row->name;?> Update Staff Account</a></li>
                                    </ul>
                                    <ul id="user_edit_tabs_content" class="uk-switcher uk-margin">
                                        <li>
                                            <div class="uk-margin-top">
                                                <h3 class="full_width_in_card heading_c">
                                                    General info
                                                </h3>

                                                <div class="uk-grid" data-uk-grid-margin>
                                                    <div class="uk-width-medium-1-3">
                                                        <label for="user_edit_uname_control">Name</label>
                                                        <input class="md-input" required type="text" name="l_name" value="<?= $row->name;?>" />
                                                    </div>
                                                    <div class="uk-width-medium-1-3">
                                                        <label for="user_edit_position_control">Email</label>
                                                        <input class="md-input" required type="email" value="<?= $row->email;?>"  name="l_email" />
                                                    </div>
                                                    <div class="uk-width-medium-1-3">
                                                        <label for="user_edit_position_control">Phone Number</label>
                                                        <input type="text" required class="md-input" name="l_phone" value="<?= $row->phone;?>" />
                                                    </div>
                                                    
                                                </div>

                                                <div class="uk-grid" data-uk-grid-margin>   
                                                        <div class="uk-width-medium-1-3">
                                                            <label for="user_edit_uname_control">Old Password</label>
                                                            <input class="md-input" type="password" required  />
                                                        </div>
                                                        <div class="uk-width-medium-1-3">
                                                            <label for="user_edit_position_control">New Password</label>
                                                            <input class="md-input" type="password"  required  name="l_pwd" />
                                                        </div>
                                                        <div class="uk-width-medium-1-3">
                                                            <label for="user_edit_position_control">Confirm New Password</label>
                                                            <input type="password" class="md-input" required />
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="uk-grid">
                                                    <div class="uk-width-1-1">
                                                        <label for="user_edit_personal_info_control">About | Bio</label>
                                                        <textarea class="md-input" name="l_bio"  cols="30" required rows="4"><?= $row->bio;?></textarea>
                                                    </div>
                                                </div>
                                                
                                                <div class="uk-grid">
                                                    <div class="uk-width-1-1">
                                                        <div class="uk-grid uk-grid-width-1-1 uk-grid-width-large-1-2" data-uk-grid-margin>
                                                            <div>
                                                                
                                                                <div class="uk-input-group">
                                                                    <input type="submit" class="md-btn md-btn-success" name="staff_update" value="Update Profile" />
                                                                </div>
                                                            </div>

                                                            <!--
                                                            <div>
                                                                <div class="uk-input-group">
                                                                    <span class="uk-input-group-addon">
                                                                        <i class="md-list-addon-icon uk-icon-facebook-official"></i>
                                                                    </span>
                                                                    <label>Facebook</label>
                                                                    <input type="text" class="md-input" name="user_edit_facebook" value="facebook.com/envato" />
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <div class="uk-input-group">
                                                                    <span class="uk-input-group-addon">
                                                                        <i class="md-list-addon-icon uk-icon-twitter"></i>
                                                                    </span>
                                                                    <label>Twitter</label>
                                                                    <input type="text" class="md-input" name="user_edit_twitter" value="twitter.com/envato" />
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <div class="uk-input-group">
                                                                    <span class="uk-input-group-addon">
                                                                        <i class="md-list-addon-icon uk-icon-linkedin"></i>
                                                                    </span>
                                                                    <label>Linkdin</label>
                                                                    <input type="text" class="md-input" name="user_edit_linkdin" value="linkedin.com/company/envato" />
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <div class="uk-input-group">
                                                                    <span class="uk-input-group-addon">
                                                                        <i class="md-list-addon-icon uk-icon-google-plus"></i>
                                                                    </span>
                                                                    <label>Google+</label>
                                                                    <input type="text" class="md-input" name="user_edit_google_plus" value="plus.google.com/+envato/about" />
                                                                </div>
                                                            </div>
                                                            -->

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                    </div>

                </form>

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

    <!-- page specific plugins -->
    <!-- file input -->
    <script src="assets/js/custom/uikit_fileinput.min.js"></script>

    <!--  user edit functions -->
    <script src="assets/js/pages/page_user_edit.min.js"></script>
    
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

    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','http://www.google-analytics.com/analytics.js','ga');
        ga('create', 'UA-65191727-1', 'auto');
        ga('send', 'pageview');
    </script>
</body>

</html>