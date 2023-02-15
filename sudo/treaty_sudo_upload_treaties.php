<?php
session_start();
include('assets/config/config.php');
include('assets/config/checklogin.php');
check_login();
//generate random librarian number
$length = 5;
$Number =  substr(str_shuffle('0123456789'), 1, $length);

//create a librarian account
if (isset($_POST['add_librarian'])) {
    $error = 0;
    if (isset($_POST['l_name']) && !empty($_POST['l_name'])) {
        $l_name = mysqli_real_escape_string($mysqli, trim($_POST['l_name']));
    } else {
        $error = 1;
        $err = "Librarian name cannot be empty";
    }
    if (isset($_POST['l_email']) && !empty($_POST['l_email'])) {
        $l_email = mysqli_real_escape_string($mysqli, trim($_POST['l_email']));
    } else {
        $error = 1;
        $err = "Librarian email cannot be empty";
    }
    if (isset($_POST['l_number']) && !empty($_POST['l_number'])) {
        $l_number = mysqli_real_escape_string($mysqli, trim($_POST['l_number']));
    } else {
        $error = 1;
        $err = "Librarian email cannot be empty";
    }
    if (!$error) {
        $sql = "SELECT * FROM  fmoj_staff WHERE  l_number='$l_number' || l_email ='$l_email' ";
        $res = mysqli_query($mysqli, $sql);
        if (mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            if ($l_number == $row['l_number']) {
                $err = "Librarian number already exists";
            } else {
                $err = "Librarian email already exists";
            }
        } else {

            $l_number = $_POST['l_number'];
            $l_name = $_POST['l_name'];
            $l_phone = $_POST['l_phone'];
            $l_email = $_POST['l_email'];
            $l_pwd = sha1(md5($_POST['l_pwd']));
            $l_adr = $_POST['l_adr'];
            $l_bio = $_POST['l_bio'];
            $l_acc_status = $_POST['l_acc_status'];

            //Insert Captured information to a database table
            $query = "INSERT INTO fmoj_staff (l_number, l_name, l_phone, l_email, l_pwd, l_adr, l_bio, l_acc_status) VALUES (?,?,?,?,?,?,?,?)";
            $stmt = $mysqli->prepare($query);
            //bind paramaters
            $rc = $stmt->bind_param('ssssssss', $l_number, $l_name, $l_phone, $l_email, $l_pwd, $l_adr, $l_bio, $l_acc_status);
            $stmt->execute();

            //declare a varible which will be passed to alert function
            if ($stmt) {
                $success = "Librarian Account Created";
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
                <li><a href="#">Treaties</a></li>
                <li><span>Treaty Upload Form</span></li>
            </ul>
        </div>

        <div id="page_content_inner">
            <h3 class="heading_a text">Treaty Upload Form</h3>
            <div class="md-card">
                <div class="md-card-content">
                    <form method="post">
                        <div class="uk-grid" data-uk-grid-margin>
                            <div class="uk-width-medium-1-2">
                                <div class="uk-form-row">
                                    <label>Treaty Name, Title, Keywords</label>
                                    <input type="text" required name="staff_name" class="md-input" />
                                </div>
                                <div class="uk-form-row">
                                    <label>Treaty Signatories</label>
                                    <input type="email" required name="email" class="md-input" />
                                </div>
                                <div class="uk-form-row">
                                    <label>Treaty Status</label>
                                    <select required onChange="getBookId(this.value);" name="treaty_name" class="md-input" />
                                    <option>Select Treaty Category</option>
                                    <?php
                                    $ret = "SELECT * FROM  	tbl_treatiescategory";
                                    $stmt = $mysqli->prepare($ret);
                                    $stmt->execute(); //ok
                                    $res = $stmt->get_result();
                                    while ($row = $res->fetch_object()) {
                                    ?>
                                        <option value="<?php echo $row->treaty_name; ?>"><?php echo $row->treaty_name; ?></option>
                                    <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="uk-width-medium-1-2">
                                <div class="uk-form-row">
                                    <label>Treaty Definition</label>
                                    <input type="text" required readonly name="treaty_number" class="md-input" />
                                </div>
                                <div class="uk-form-row">
                                    <label>Treaty Date</label>
                                    <input type="date" required name="date" class="md-input label-fixed" />
                                </div>
                                <div class="uk-form-row">
                                    <label>Minutes Of Negotiation</label>
                                    <input type="text" required name="bio" class="md-input" />
                                    <!-- <textarea cols="30" required rows="3" class="md-input" name="l_bio"></textarea> -->
                                </div>
                            </div>

                            <div class="uk-width-medium-2-2">
                                <div class="uk-form-row">
                                    <label>Brief of Discussion</label>
                                    <textarea cols="30" required rows="3" class="md-input" name="l_desc"></textarea>
                                </div>
                            </div>

                            <div class="uk-width-medium-2-2">
                                <div id="file_upload-drop" class="uk-file-upload">
                                    <p class="uk-text">Upload Treaty Document</p>
                                    <p class="uk-text-muted uk-text-small uk-margin-small-bottom">or</p>
                                    <a class="uk-form-file md-btn">choose file<input id="file_upload-select" name="b_coverimage" type="file"></a>
                                </div>
                                <div id="file_upload-progressbar" class="uk-progress uk-hidden">
                                    <div class="uk-progress-bar" style="width:0">0%</div>
                                </div>
                            </div>


                            <div class="uk-width-medium-2-2">
                                <div class="uk-form-row">
                                    <div class="uk-input-group">
                                        <input type="submit" class="md-btn md-btn-success" name="upload_treaty" value="Upload Treaty" />
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