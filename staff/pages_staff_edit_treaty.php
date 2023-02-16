<?php
session_start();
include('assets/config/config.php');
include('assets/config/checklogin.php');
check_login();

//generate random isbn number
$length = 6;
$Number =  substr(str_shuffle('0123456789'), 1, $length);

if (isset($_SESSION['id'])) {
    // Get the user's ID and other details from the session
    $user_id = $_SESSION['id'];
    $result = "SELECT * FROM fmoj_staff WHERE id = ?";
    $stmt = $mysqli->prepare($result);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_object();
    $stmt->close();
}

//edit treaty
if (isset($_POST['update_treaty'])) {
    $doc_id = $_GET['doc_id'];
    $title  = $_POST['title'];
    $signatory = $_POST['signatory'];
    $b_publisher = $_POST['b_publisher'];
    $tc_id = $_POST['tc_id'];
    $tc_name = $_POST['tc_name'];
    $b_summary = $_POST['b_summary'];
    $treaty_year = $_POST['treaty_year'];
    $s_status = $_POST['s_status'];


    // $b_file = $_FILES["b_file"]["name"];
    // move_uploaded_file($_FILES["b_file"]["tmp_name"], "../sudo/assets/magazines/" . $_FILES["b_file"]["name"]);

    //Insert Captured information to a database table
    $query = "UPDATE tbl_treaties SET title=?, signatory=?, b_publisher=?, tc_id=?, tc_name=?, b_summary=?, treaty_year=?, s_status=? WHERE id =?";
    $stmt = $mysqli->prepare($query);
    //bind paramaters
    $rc = $stmt->bind_param('ssssssssi', $title, $signatory, $b_publisher, $tc_id, $tc_name, $b_summary, $treaty_year, $s_status, $doc_id);
    $stmt->execute();

    //declare a varible which will be passed to alert function
    if ($stmt) {
        $success = "Treaty Updated Successfully" && header("refresh:1;url=pages_staff_manage_treaty.php");
    } else {
        $err = "Please Try Again Or Try Later";
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
    $doc_id = $_GET['doc_id'];
    $ret = "SELECT * FROM  tbl_treaties WHERE id = ?";
    $stmt = $mysqli->prepare($ret);
    $stmt->bind_param('i', $doc_id);
    $stmt->execute(); //ok
    $res = $stmt->get_result();
    while ($row = $res->fetch_object()) {

    ?>
        <div id="page_content">
            <!--Breadcrums-->
            <div id="top_bar">
                <ul id="breadcrumbs">
                    <li><a href="pages_staff_dashboard.php">Dashboard</a></li>
                    <li><a href="pages_staff_manage_treaty.php">Treaty Inventory</a></li>
                    <li><span>Update Treaty</span></li>
                </ul>
            </div>

            <div id="page_content_inner">

                <div class="md-card">
                    <div class="md-card-content">
                        <h3 class="heading_a">Please Fill All Fields</h3>
                        <hr>
                        <form method="post" enctype="multipart/form-data">
                            <div class="uk-grid" data-uk-grid-margin>
                                <div class="uk-width-medium-1-2">
                                    <div class="uk-form-row">
                                        <label>Treaty Title</label>
                                        <input type="text" value="<?= $row->title; ?>" required name="title" class="md-input" />
                                    </div>
                                    <div class="uk-form-row">
                                        <label>Treaty Signatory</label>
                                        <input type="text" value="<?= $row->signatory; ?>" required name="signatory" class="md-input" />
                                    </div>
                                    <div class="uk-form-row">
                                        <label>Treaty Status</label>
                                        <select required name="s_status" id="s_status" class="md-input">
                                            <?php
                                            $ret = "SELECT DISTINCT s_status FROM tbl_treaties";
                                            $stmt = $mysqli->prepare($ret);
                                            $stmt->execute(); //ok
                                            $res = $stmt->get_result();
                                            $selected_status = $row->s_status ? $row->s_status : '';
                                            while ($row1 = $res->fetch_object()) {
                                                $selected = ($row1->s_status == $selected_status) ? 'selected' : '';
                                            ?>
                                                <option value="<?= $row1->s_status ?>" <?= $selected ?>><?= $row1->s_status ?></option>
                                            <?php } ?>
                                        </select>

                                    </div>
                                </div>

                                <div class="uk-width-medium-1-2">
                                    <div class="uk-form-row">
                                        <label>Treaty Publisher</label>
                                        <input type="text" value="<?= $user->name ?>" readonly class="md-input" name="b_publisher" />
                                    </div>

                                    <div class="uk-form-row">
                                        <label>Treaty Category</label>
                                        <select value="<?= $row->tc_name; ?>" required onChange="getTreatyId(this.value);" name="tc_name" id="tc_name" class="md-input" />
                                        <?php
                                        $ret = "SELECT * FROM tbl_treatiescategory";
                                        $stmt = $mysqli->prepare($ret);
                                        $stmt->execute(); //ok
                                        $res = $stmt->get_result();
                                        $selected_status = $row->tc_name ? $row->tc_name : '';
                                        while ($row2 = $res->fetch_object()) {
                                            $selected = ($row2->name == $selected_status) ? 'selected' : '';
                                        ?>
                                            <option value="<?= $row2->name ?>" <?= $selected ?>><?= $row2->name ?></option>
                                        <?php } ?>
                                        </select>
                                    </div>
                                    <div class="uk-form-row" style="display:none">
                                        <label>Treaty Category ID</label>
                                        <input type="text" id="TreatyCategoryID" value="<?= $row->tc_id ?>" required name="tc_id" class="md-input" readonly />
                                    </div>

                                    <div class="uk-form-row">
                                        <label>Treaty Year</label>
                                        <input type="text" id="treaty_year" value="<?= $row->treaty_year ?>" required name="treaty_year" class="md-input" />
                                    </div>

                                </div>

                                <!-- <div class="uk-width-medium-2-2">
                                    <div id="file_upload-drop" class="uk-file-upload">
                                        <p class="uk-text">Drop Treaty Document</p>
                                        <p class="uk-text-muted uk-text-small uk-margin-small-bottom">or</p>
                                        <a class="uk-form-file md-btn">Choose File<input id="file_upload-select" name="b_file" type="file" accept="image/*, .pdf"></a>
                                    </div>
                                </div> -->

                                <div class="uk-width-medium-2-2">
                                    <div class="uk-form-row">
                                        <label>Treaty Description</label>
                                        <?php
                                        $doc_id = $_GET['doc_id'];
                                        $ret = "SELECT * FROM  tbl_treaties WHERE id = ?";
                                        $stmt = $mysqli->prepare($ret);
                                        $stmt->bind_param('i', $doc_id);
                                        $stmt->execute(); //ok
                                        $res = $stmt->get_result();
                                        while ($row = $res->fetch_object()) {

                                        ?>
                                            <textarea cols="30" rows="10" class="md-input" name="b_summary"><?= $row->b_summary; ?></textarea>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="uk-width-medium-2-2">
                                    <div class="uk-form-row">
                                        <div class="uk-input-group">
                                            <input type="submit" class="md-btn md-btn-success" name="update_treaty" value="Update Book" />
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