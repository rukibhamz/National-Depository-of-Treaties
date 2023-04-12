<?php
session_start();
include('assets/config/config.php');
include('assets/config/checklogin.php');
check_login();
$_SESSION['loading'] = false;

if (isset($_SESSION['sudo_id'])) {
    // Get the user's ID and other details from the session
    $user_id = $_SESSION['sudo_id'];
    $result = "SELECT * FROM il_sudo WHERE id = ?";
    $stmt = $mysqli->prepare($result);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_object();
    $stmt->close();
}

//generate random staff number
$length = 5;
$Number =  substr(str_shuffle('0123456789'), 1, $length);

//add new treaty
if (isset($_POST['add_treaty'])) {
    $_SESSION['loading'] = true;
    $error = 0;
    if (isset($_POST['title']) && !empty($_POST['title'])) {
        $title = mysqli_real_escape_string($mysqli, trim($_POST['title']));
    } else {
        $error = 1;
        $err = "Treaty title cannot be empty";
        $_SESSION['loading'] = false;
    }
    if (isset($_POST['signatory']) && !empty($_POST['signatory'])) {
        $signatory = mysqli_real_escape_string($mysqli, trim($_POST['signatory']));
    } else {
        $error = 1;
        $err = "Treaty signatory cannot be empty";
        $_SESSION['loading'] = false;
    }
    if (isset($_POST['s_status']) && !empty($_POST['s_status'])) {
        $s_status = mysqli_real_escape_string($mysqli, trim($_POST['s_status']));
    } else {
        $error = 1;
        $err = "Treaty status cannot be empty";
        $_SESSION['loading'] = false;
    }
    if (isset($_POST['tc_name']) && !empty($_POST['tc_name'])) {
        $tc_name = mysqli_real_escape_string($mysqli, trim($_POST['tc_name']));
    } else {
        $error = 1;
        $err = "Treaty category cannot be empty";
        $_SESSION['loading'] = false;
    }

    if (!$error) {
        $title  = $_POST['title'];
        $sql = "SELECT * FROM tbl_treaties WHERE title='$title' ";
        $res = mysqli_query($mysqli, $sql);
        if (mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            if ($title == $row['title']) {
                $err =  "Treaty title already exists";
            } else {
                $err =  "Treaty title already exists";
            }
        } else {
            $signatory = $_POST['signatory'];
            $b_publisher = $_POST['b_publisher'];
            $tc_id = $_POST['tc_id'];
            $tc_name = $_POST['tc_name'];
            $b_summary = $_POST['b_summary'];
            $treaty_year = $_POST['treaty_year'];
            $s_status = $_POST['s_status'];
            $s_id = $_POST['s_id'];
            $b_file = $_FILES["b_file"]["name"];
            $domesticated = $_POST["domesticated"];
            $signed_date = $_POST["signed_date"];
            $ratification = $_POST["ratification_date"];
            $approved = true;

            // Convert date format from "24/04/2023" to "YYYY-MM-DD"
            $signed_date = date("Y-m-d", strtotime($signed_date));
            $ratification = date("Y-m-d", strtotime($ratification));

            if (!empty($b_file)) {
                // move_uploaded_file($_FILES["b_file"]["tmp_name"], "assets/magazines/" . $_FILES["b_file"]["name"]);
                move_uploaded_file($_FILES["b_file"]["tmp_name"], "assets" . DIRECTORY_SEPARATOR . "magazines" . DIRECTORY_SEPARATOR . $_FILES["b_file"]["name"]);
            } else {
                $err = "Please select a file to upload.";
            }

            // $b_file = $_FILES["b_file"]["name"];
            // move_uploaded_file($_FILES["b_file"]["tmp_name"], "../sudo/assets/magazines/" . $_FILES["b_file"]["name"]);

            //Insert Captured information to a database table
            $query = "INSERT INTO tbl_treaties (title, signatory, b_publisher, b_file, tc_id, tc_name, b_summary, treaty_year, s_status, s_id, domesticated, signed_date, ratification, approved) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $notification = "INSERT INTO il_notifications (content, user_id) VALUES(?,?)";

            $stmt = $mysqli->prepare($query);
            //---Post a notification that someone has reported a book lost--//
            $content = "Treaty <strong>$title</strong>, created successfully.";
            $notification = "INSERT INTO il_notifications (content, user_id) VALUES(?,?)";
            $notification_stmt = $mysqli->prepare($notification);

            //bind parameters
            $rc = $stmt->bind_param('ssssssssssssss', $title, $signatory, $b_publisher, $b_file, $tc_id, $tc_name, $b_summary, $treaty_year, $s_status, $s_id, $domesticated, $signed_date, $ratification, $approved);
            $rc = $notification_stmt->bind_param('ss', $content, $user_id);

            // Execute
            $stmt->execute();
            $notification_stmt->execute();

            //declare a variable which will be passed to alert function
            if ($stmt && $notification_stmt) {
                $success = "Treaty Created Successfully";
                $_SESSION['loading'] = false;
            } else {
                $err = "Please Try Again Or Try Later";
                $_SESSION['loading'] = false;
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
                <li><span>Treaty Upload Form</span></li>
            </ul>
        </div>

        <div id="page_content_inner">
            <div class="space-40"></div>

            <div class="md-card">
                <div class="md-card-content">
                    <h3 class="heading_a">Please Fill All Fields</h3>
                    <hr>
                    <form method="post" enctype="multipart/form-data">
                        <div class="uk-grid" data-uk-grid-margin>
                            <div class="uk-width-medium-2-2">
                                <div class="uk-form-row">
                                    <label>Treaty Title</label>
                                    <input type="text" required name="title" class="md-input" />
                                </div>
                            </div>

                            <div class="uk-width-medium-1-2">
                                <div class="uk-form-row">
                                    <label>Treaty Signatory</label>
                                    <input type="text" required name="signatory" class="md-input" />
                                </div>

                                <div class="uk-form-row">
                                    <label>Treaty Status</label>
                                    <select required name="s_status" onChange="getStatusId(this.value);" id="s_status" class="md-input">
                                        <option value="" disabled selected>Select Treaty Status</option>
                                        <?php
                                        $ret = "SELECT * FROM  tbl_status";
                                        $stmt = $mysqli->prepare($ret);
                                        $stmt->execute();
                                        $res = $stmt->get_result();
                                        while ($row2 = $res->fetch_object()) {
                                        ?>
                                            <option value="<?= $row2->name; ?>"><?= $row2->name; ?></option>
                                        <?php } ?>
                                    </select>

                                </div>
                                <div class="uk-form-row" style="display:none">
                                    <label>Treaty Status ID</label>
                                    <input type="text" id="sudoTreatyStatusID" required name="s_id" class="md-input" readonly />
                                </div>

                                <div class="uk-form-row">
                                    <label>Domesticated ?</label>
                                    <select required name="domesticated" id="domesticated" class="md-input">
                                        <option value="" disabled selected>--Select An Option--</option>
                                        <option value="no">NO</option>
                                        <option value="yes">YES</option>
                                        <option value="n/a">N/A</option>
                                    </select>
                                </div>

                                <div class="uk-form-row">
                                    <label>Signed Date</label>
                                    <input id="signed_date" required name="signed_date" type="text" data-uk-datepicker class="md-input" />
                                </div>
                            </div>

                            <div class="uk-width-medium-1-2">
                                <div class="uk-form-row">
                                    <label>Treaty Publisher</label>
                                    <input type="text" required class="md-input" name="b_publisher" value="<?= $user->username ?>" readonly />
                                </div>

                                <div class="uk-form-row">
                                    <label>Treaty Category</label>
                                    <select required onChange="getTreatyId(this.value);" name="tc_name" id="tc_name" class="md-input" />
                                    <option value="" disabled selected>Select Category</option>
                                    <?php
                                    $ret = "SELECT * FROM  tbl_treatiescategory";
                                    $stmt = $mysqli->prepare($ret);
                                    $stmt->execute(); //ok
                                    $res = $stmt->get_result();
                                    while ($row = $res->fetch_object()) {
                                    ?>
                                        <option value="<?= $row->name; ?>"><?= $row->code; ?> - <?= $row->name; ?></option>
                                    <?php } ?>
                                    </select>
                                </div>
                                <div class="uk-form-row" style="display:none">
                                    <label>Treaty Category ID</label>
                                    <input type="text" id="sudoTreatyCategoryID" required name="tc_id" class="md-input" readonly />
                                </div>

                                <div class="uk-form-row">
                                    <label>Treaty Year</label>
                                    <input type="text" id="treaty_year" required name="treaty_year" class="md-input" />
                                </div>

                                <div class="uk-form-row">
                                    <label>Ratification Date</label>
                                    <input id="ratification_date" required name="ratification_date" type="text" data-uk-datepicker class="md-input" value="" />
                                </div>

                            </div>

                            <div class="uk-width-medium-2-2">
                                <div id="file_upload-drop" class="uk-file-upload">
                                    <p class="uk-text">Drop Treaty Document</p>
                                    <p class="uk-text-muted uk-text-small uk-margin-small-bottom">or</p>
                                    <a class="uk-form-file md-btn">choose file<input id="file_upload-select" name="b_file" type="file" accept="image/*,.pdf" required></a>
                                    <div class="space-20"></div>
                                    <div id="file_name"></div>
                                </div>
                                <div id="file_upload-progressbar" class="uk-progress uk-hidden">
                                    <div class="uk-progress-bar" style="width:0">0</div>
                                </div>
                            </div>

                            <div class="uk-width-medium-2-2">
                                <div class="uk-form-row">
                                    <label>Treaty Description</label>
                                    <textarea cols="30" rows="10" class="md-input" name="b_summary"></textarea>
                                </div>
                            </div>
                            <div class="uk-width-medium-2-2">
                                <div class="uk-form-row">
                                    <div id="loading-spinner" style="display:none;">
                                        <input type="button" class="md-btn md-btn-success" value="Creating new treaty..." type="button" disabled id="loading" />
                                    </div>

                                    <div class="uk-input-group">
                                        <input type="submit" id="submit_button" class="md-btn md-btn-success" name="add_treaty" value="Add Treaty" />
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
    <script src="assets/js/pages/forms_file_upload.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // Set ratification date input value to empty string
            document.getElementById("ratification_date").value = "";
            document.getElementById("signed_date").value = "";
        });

        const fileUpload = document.getElementById("file_upload-select");
        const fileNameElement = document.getElementById("file_name");

        document.getElementById("file_upload-drop").addEventListener("change", (event) => {
            const fileName = event.target.files[0].name;
            fileNameElement.innerText = `Selected File Name : ${fileName}`;
        });


        var button = document.getElementById('submit_button');
        var loadingSpinner = document.getElementById('loading-spinner');

        button.addEventListener('click', function() {
            button.style.display = 'none';
            loadingSpinner.style.display = 'block';
        });
    </script>

</body>

</html>