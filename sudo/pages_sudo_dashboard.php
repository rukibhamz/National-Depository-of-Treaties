<?php
/*
    *Handle SUDO DASHBOARD page logic
    */
session_start();
include('assets/config/config.php');
include('assets/config/checklogin.php');
check_login();


/*
    Statics logic
        1.Books
            1.0 : Number of all book categories in the library
            1.1 : Number of all books no matter what category
            1.2 : Number of all Borrowed Books no matter what category
            1.3 : Number of all Lost Books no matter what category

        2.Library Users(Students and Librarians)
            2.0 : Number of Employed Librarians
            2.1 : Number of all Enrolled Students
            2.2 : Number of all Enrolled Students with pending account activation
            2.3 : Number of all Employed Librarians with pending accounts activations
        3.Misc
            3.0 : Number of all Librarians requestings for Password Resets
            3.1 : Number of all students requesting for password resets
            3.2 : Number of Unread Messsanges inbox
            3.3 : Number of all amount paid by students as a fine of loosing and damaging any book

    Charts
         1.Books
            1.0 : Number Of Books Per Book Category ->PieChart
            1.1 : Number of Borrowed Books Per Books Category ->Piechart or Donought Chart



    */
//1.Books

//1.0 : Number of all book categories in the library
$result = "SELECT count(*) FROM iL_BookCategories";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($book_categories);
$stmt->fetch();
$stmt->close();

//1.1 : Number of all books no matter what category
$result = "SELECT SUM(b_copies) FROM iL_Books";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($books);
$stmt->fetch();
$stmt->close();

//1.2 : Number of all Borrowed Books no matter what category
$result = "SELECT count(*) FROM iL_LibraryOperations WHERE lo_type = 'Borrow' AND lo_status = '' ";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($borrowed_books);
$stmt->fetch();
$stmt->close();

//1.3 : Number of all Lost Books no matter what category
$result = "SELECT count(*) FROM iL_LibraryOperations WHERE lo_status = 'Lost'  ";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($lost_books);
$stmt->fetch();
$stmt->close();

//1.3.1 : Number of all Damanged no matter what category
$result = "SELECT count(*) FROM iL_LibraryOperations WHERE  lo_status = 'Damanged' ";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($damanged_books);
$stmt->fetch();
$stmt->close();

//1.3.2 : Number of all returned books no matter what category
$result = "SELECT count(*) FROM iL_LibraryOperations WHERE lo_status = 'Returned'  ";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($Returned);
$stmt->fetch();
$stmt->close();

$damanged_and_lost_books = $lost_books + $damanged_books;


//2.Library Users(Students and Librarians)
//2.0 : Number of Employed Librarians
$result = "SELECT count(*) FROM iL_Librarians WHERE l_acc_status = 'Active' ";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($librarians);
$stmt->fetch();
$stmt->close();

//2.1 : Number of all Enrolled Students
$result = "SELECT count(*) FROM iL_Students WHERE s_acc_status = 'Active' ";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($students);
$stmt->fetch();
$stmt->close();

//2.2 : Number of all Enrolled Students with pending account activation
$result = "SELECT count(*) FROM iL_Students WHERE s_acc_status = 'Pending' ";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($pending_students);
$stmt->fetch();
$stmt->close();

//2.3 : Number of all Employed Librarians with pending accounts activations
$result = "SELECT count(*) FROM iL_Librarians WHERE l_acc_status = 'Pending' ";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($pending_librarians);
$stmt->fetch();
$stmt->close();

// 3.Misc

//3.0 : Number of all Librarians requestings for Password Resets
$result = "SELECT count(*) FROM iL_PasswordResets WHERE pr_usertype = 'Librarian' AND pr_status='Pending' ";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($pending_librarians_pwd_resets);
$stmt->fetch();
$stmt->close();

//3.1 : Number of all students requesting for password resets
$result = "SELECT count(*) FROM iL_PasswordResets WHERE pr_usertype = 'Student' AND pr_status='Pending' ";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($pending_student_pwd_resets);
$stmt->fetch();
$stmt->close();

//3.2 : Number of Subcribed media in the system
$result = "SELECT count(*) FROM iL_Subscriptions ";
$stmt = $mysqli->prepare($result);
//$stmt->bind_param('i', $id);
$stmt->execute();
$stmt->bind_result($subscriptions);
$stmt->fetch();
$stmt->close();

//3.3 : Number of all amount paid by students as a fine of loosing  any book
$result = "SELECT SUM(f_amt) FROM iL_Fines WHERE f_type = 'Lost Book'";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($lostBookfines);
$stmt->fetch();
$stmt->close();

//3.4 : Number of all amount paid by students as a fine of  damaging any book
$result = "SELECT SUM(f_amt) FROM iL_Fines WHERE f_type = 'Damaged Book' ";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($damangedBookfines);
$stmt->fetch();
$stmt->close();

//3.5 : Number of all amount paid by students as a fine of  damaging any book
$result = "SELECT SUM(f_amt) FROM iL_Fines WHERE f_status = 'Paid' ";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($paidFine);
$stmt->fetch();
$stmt->close();

$totalFine = $lostBookfines + $damangedBookfines;
$pendingFine = $totalFine - $paidFine;



/*
        The following block of codes implements Books Charts

        -->Books Category Will be HardCoded so my bad<--
    */

//1.0.1 : Number Of Books under Non-fiction Category
$result = "SELECT COUNT(*) FROM iL_Books WHERE bc_name = 'Non-fiction' ";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($non_fiction);
$stmt->fetch();
$stmt->close();

//1.0.2 : Number Of Books under Fiction Category
$result = "SELECT COUNT(*) FROM iL_Books WHERE bc_name = 'Fiction' ";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($fiction);
$stmt->fetch();
$stmt->close();

//1.0.3 : Number Of Books under References Category
$result = "SELECT COUNT(*) FROM iL_Books WHERE bc_name = 'References' ";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($References);
$stmt->fetch();
$stmt->close();

//1.1.0 : Number of Borrowed Books Per Books in Non-fiction Category ->Piechart or Donought Chart
$result = "SELECT COUNT(*) FROM iL_LibraryOperations WHERE bc_name = 'Non-fiction' AND lo_type ='Borrow' ";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($borrowed_non_fiction);
$stmt->fetch();
$stmt->close();

//1.1.1 : Number of Borrowed Books Per Books in fiction Category ->Piechart or Donought Chart
$result = "SELECT COUNT(*) FROM iL_LibraryOperations WHERE bc_name = 'Fiction' AND lo_type ='Borrow' ";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($borrowed_fiction);
$stmt->fetch();
$stmt->close();

//1.1.2 : Number of Borrowed Books Per Books in References Category ->Piechart or Donought Chart
$result = "SELECT COUNT(*) FROM iL_LibraryOperations WHERE bc_name = 'References' AND lo_type ='Borrow' ";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($borrowed_references);
$stmt->fetch();
$stmt->close();



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
        <!-- USE THIS FOR ALERTS -->
        <!-- <div class="uk-alert black" data-uk-alert>
            <a href="" class="uk-alert-close uk-close"></a>
            <p>Lorem Ipsum dpmpr.pdf has been published</p>
        </div>
        <div class="uk-alert danger" data-uk-alert>
            <a href="" class="uk-alert-close uk-close"></a>
            <p>Lorem Ipsum dpmpr.pdf has been published</p>
        </div> -->
        <div id="page_content_inner">

            <!--1.Treaty-->
            <h3 class="text">Treaty Database Analytics</h3>
            <div class="uk-grid uk-grid-width-large-1-4 uk-grid-width-medium-1-2 uk-grid-large uk-sortable sortable-handler hierarchical_show" data-uk-sortable data-uk-grid-margin>
                <div>
                    <div class="md-card">
                        <div class="md-card-content">
                            <div class="uk-float-right uk-margin-top uk-margin-small-right"></div>
                            <h2 class="uk-margin-remove"><span class="countUpMe">0<noscript><?php echo $book_categories; ?></noscript></span></h2>
                            <div class="space-10"></div>
                            <p class="text">Total treaties
                                In Depository</p>

                            <div class="space-10"></div>
                            <div class="title-bar black">
                                <ul class="list-inline list-unstyled">
                                    <li><i class="icofont icofont-square"></i></li>
                                </ul>
                            </div>
                            <div class="space-10"></div>
                            <a href="#">
                                <p class="text">View treaties <img src="assets/img/arrow_icon.png" alt="arrow icon" width="35px" /></p>
                            </a>
                        </div>
                    </div>
                    <div class="space-10"></div>
                </div>
                <div>
                    <div class="md-card">
                        <div class="md-card-content">
                            <div class="uk-float-right uk-margin-top uk-margin-small-right"></div>
                            <h2 class="uk-margin-remove"><span class="countUpMe">0<noscript><?php echo $book_categories; ?></noscript></span></h2>
                            <div class="space-10"></div>
                            <p class="text">Total treaties Published</p>

                            <div class="space-10"></div>
                            <div class="title-bar black">
                                <ul class="list-inline list-unstyled">
                                    <li><i class="icofont icofont-square"></i></li>
                                </ul>
                            </div>
                            <div class="space-10"></div>
                            <a href="#">
                                <p class="text">View treaties <img src="assets/img/arrow_icon.png" alt="arrow icon" width="35px" /></p>
                            </a>
                        </div>
                    </div>
                    <div class="space-10"></div>
                </div>
                <div>
                    <div class="md-card">
                        <div class="md-card-content">
                            <div class="uk-float-right uk-margin-top uk-margin-small-right"></div>
                            <h2 class="uk-margin-remove"><span class="countUpMe">0<noscript><?php echo $book_categories; ?></noscript></span></h2>
                            <div class="space-10"></div>
                            <p class="text">Total treaties
                                Revised</p>

                            <div class="space-10"></div>
                            <div class="title-bar black">
                                <ul class="list-inline list-unstyled">
                                    <li><i class="icofont icofont-square"></i></li>
                                </ul>
                            </div>
                            <div class="space-10"></div>
                            <a href="#">
                                <p class="text">View treaties <img src="assets/img/arrow_icon.png" alt="arrow icon" width="35px" /></p>
                            </a>
                        </div>
                    </div>
                    <div class="space-10"></div>
                </div>
                <div>
                    <div class="md-card">
                        <div class="md-card-content">
                            <div class="uk-float-right uk-margin-top uk-margin-small-right"></div>
                            <h2 class="uk-margin-remove"><span class="countUpMe">0<noscript><?php echo $book_categories; ?></noscript></span></h2>
                            <div class="space-10"></div>
                            <p class="text">Total treaties
                                Running</p>

                            <div class="space-10"></div>
                            <div class="title-bar black">
                                <ul class="list-inline list-unstyled">
                                    <li><i class="icofont icofont-square"></i></li>
                                </ul>
                            </div>
                            <div class="space-10"></div>
                            <a href="#">
                                <p class="text">View treaties <img src="assets/img/arrow_icon.png" alt="arrow icon" width="35px" /></p>
                            </a>
                        </div>
                    </div>
                    <div class="space-10"></div>
                </div>
            </div>

            <div class="space-30"></div>
            <div class="text-center">
                <div class="title-bar blue">
                    <ul class="list-inline list-unstyled">
                        <li><i class="icofont icofont-square"></i></li>
                        <li><i class="icofont icofont-square"></i></li>
                    </ul>
                </div>
            </div>

            <!--2.User Analytics-->
            <h3 class="text">User Analytics</h3>
            <div class="uk-grid uk-grid-width-large-1-4 uk-grid-width-medium-1-2 uk-grid-large uk-sortable sortable-handler hierarchical_show" data-uk-sortable data-uk-grid-margin>
                <div>
                    <div class="md-card card-alt">
                        <div class="md-card-content">
                            <div class="uk-float-right uk-margin-top uk-margin-small-right"></div>
                            <h2 class="uk-margin-remove"><span class="countUpMe">0<noscript><?php echo $book_categories; ?></noscript></span></h2>
                            <div class="space-10"></div>
                            <p class="text">Registered Users</p>

                            <div class="space-10"></div>
                            <div class="title-bar white">
                                <ul class="list-inline list-unstyled">
                                    <li><i class="icofont icofont-square"></i></li>
                                </ul>
                            </div>
                            <div class="space-10"></div>
                            <a href="#">
                                <p class="text">View users <img src="assets/img/arrow_icon_white.png" alt="arrow icon" width="35px" /></p>
                            </a>
                        </div>
                    </div>
                    <div class="space-10"></div>
                </div>
                <div>
                    <div class="md-card card-alt">
                        <div class="md-card-content">
                            <div class="uk-float-right uk-margin-top uk-margin-small-right"></div>
                            <h2 class="uk-margin-remove"><span class="countUpMe">0<noscript><?php echo $book_categories; ?></noscript></span></h2>
                            <div class="space-10"></div>
                            <p class="text">Suspended Users</p>

                            <div class="space-10"></div>
                            <div class="title-bar white">
                                <ul class="list-inline list-unstyled">
                                    <li><i class="icofont icofont-square"></i></li>
                                </ul>
                            </div>
                            <div class="space-10"></div>
                            <a href="#">
                                <p class="text">View users <img src="assets/img/arrow_icon_white.png" alt="arrow icon" width="35px" /></p>
                            </a>
                        </div>
                    </div>
                    <div class="space-10"></div>
                </div>
                <div>
                    <div class="md-card card-alt">
                        <div class="md-card-content">
                            <div class="uk-float-right uk-margin-top uk-margin-small-right"></div>
                            <h2 class="uk-margin-remove"><span class="countUpMe">0<noscript><?php echo $book_categories; ?></noscript></span></h2>
                            <div class="space-10"></div>
                            <p class="text">Active
                                User</p>

                            <div class="space-10"></div>
                            <div class="title-bar white">
                                <ul class="list-inline list-unstyled">
                                    <li><i class="icofont icofont-square"></i></li>
                                </ul>
                            </div>
                            <div class="space-10"></div>
                            <a href="#">
                                <p class="text">View users <img src="assets/img/arrow_icon_white.png" alt="arrow icon" width="35px" /></p>
                            </a>
                        </div>
                    </div>
                    <div class="space-10"></div>
                </div>
                <div>
                    <div class="md-card card-alt">
                        <div class="md-card-content">
                            <div class="uk-float-right uk-margin-top uk-margin-small-right"></div>
                            <h2 class="uk-margin-remove"><span class="countUpMe">0<noscript><?php echo $book_categories; ?></noscript></span></h2>
                            <div class="space-10"></div>
                            <p class="text">In-active
                                User</p>

                            <div class="space-10"></div>
                            <div class="title-bar white">
                                <ul class="list-inline list-unstyled">
                                    <li><i class="icofont icofont-square"></i></li>
                                </ul>
                            </div>
                            <div class="space-10"></div>
                            <a href="#">
                                <p class="text">View users <img src="assets/img/arrow_icon_white.png" alt="arrow icon" width="35px" /></p>
                            </a>
                        </div>
                    </div>
                    <div class="space-10"></div>
                </div>
            </div>

            <div class="uk-grid">
                <div class="uk-width-1-1">
                    <h4 class="heading_a uk-margin-bottom">Recent Uploads</h4>
                    <div class="md-card">
                        <div class="md-card-content uk-overflow-container">
                            <table id="dt_default" class="uk-table" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Staff Number</th>
                                        <th>Phone No.</th>
                                        <th>Email</th>
                                        <th>Address</th>
                                        <th>Account Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $ret = "SELECT * FROM  iL_Librarians";
                                    $stmt = $mysqli->prepare($ret);
                                    $stmt->execute(); //ok
                                    $res = $stmt->get_result();
                                    while ($row = $res->fetch_object()) {
                                        //use .danger, .warning, .success according to account status
                                        if ($row->l_acc_status == 'Active') {
                                            $account_status = "<td class='uk-text-success'>$row->l_acc_status</td>";
                                        } elseif ($row->l_acc_status == 'Pending') {
                                            $account_status = "<td class='uk-text-warning'>$row->l_acc_status</td>";
                                        } else {
                                            $account_status = "<td class='uk-text-danger'>$row->l_acc_status</td>";
                                        }
                                    ?>
                                        <tr>
                                            <td><?php echo $row->l_name; ?></td>
                                            <td><?php echo $row->l_number; ?></td>
                                            <td><?php echo $row->l_phone; ?></td>
                                            <td><?php echo $row->l_email; ?></td>
                                            <td><?php echo $row->l_adr; ?></td>
                                            <?php echo $account_status; ?>
                                        </tr>

                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="uk-grid">
                <div class="uk-width-1-1">
                    <h4 class="heading_a uk-margin-bottom">New Uploader</h4>
                    <div class="md-card">
                        <div class="md-card-content uk-overflow-container">
                            <table id="dt_default" class="uk-table" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Staff Number</th>
                                        <th>Phone No.</th>
                                        <th>Email</th>
                                        <th>Address</th>
                                        <th>Gender</th>
                                        <th>Acc Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $ret = "SELECT * FROM  iL_Students";
                                    $stmt = $mysqli->prepare($ret);
                                    $stmt->execute(); //ok
                                    $res = $stmt->get_result();
                                    while ($row = $res->fetch_object()) {
                                        //use .danger, .warning, .success according to account status
                                        if ($row->s_acc_status == 'Active') {
                                            $account_status = "<td class='uk-text-success'>$row->s_acc_status</td>";
                                        } elseif ($row->s_acc_status == 'Pending') {
                                            $account_status = "<td class='uk-text-warning'>$row->s_acc_status</td>";
                                        } else {
                                            $account_status = "<td class='uk-text-danger'>$row->s_acc_status</td>";
                                        }
                                    ?>
                                        <tr>
                                            <td><?php echo $row->s_name; ?></td>
                                            <td><?php echo $row->s_number; ?></td>
                                            <td><?php echo $row->s_phone; ?></td>
                                            <td><?php echo $row->s_email; ?></td>
                                            <td><?php echo $row->s_adr; ?></td>
                                            <td><?php echo $row->s_sex; ?></td>
                                            <?php echo $account_status; ?>

                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="uk-grid">
                <div class="uk-width-1-1">
                    <h4 class="heading_a uk-margin-bottom">Pending Uploads Submitted</h4>
                    <div class="md-card">
                        <div class="md-card-content uk-overflow-container">
                            <table id="dt_default" class="uk-table" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Staff&nbsp;No</th>
                                        <th>Phone No.</th>
                                        <th>Email</th>
                                        <th>Address</th>
                                        <th>Gender</th>
                                        <th>Acc Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $ret = "SELECT * FROM  iL_Students";
                                    $stmt = $mysqli->prepare($ret);
                                    $stmt->execute(); //ok
                                    $res = $stmt->get_result();
                                    while ($row = $res->fetch_object()) {
                                        //use .danger, .warning, .success according to account status
                                        if ($row->s_acc_status == 'Active') {
                                            $account_status = "<td class='uk-text-success'>$row->s_acc_status</td>";
                                        } elseif ($row->s_acc_status == 'Pending') {
                                            $account_status = "<td class='uk-text-warning'>$row->s_acc_status</td>";
                                        } else {
                                            $account_status = "<td class='uk-text-danger'>$row->s_acc_status</td>";
                                        }
                                    ?>
                                        <tr>
                                            <td><?php echo $row->s_name; ?></td>
                                            <td><?php echo $row->s_number; ?></td>
                                            <td><?php echo $row->s_phone; ?></td>
                                            <td><?php echo $row->s_email; ?></td>
                                            <td><?php echo $row->s_adr; ?></td>
                                            <td><?php echo $row->s_sex; ?></td>
                                            <?php echo $account_status; ?>

                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
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

    <!-- page specific plugins -->
    <!-- d3 -->
    <script src="bower_components/d3/d3.min.js"></script>
    <!-- metrics graphics (charts) -->
    <script src="bower_components/metrics-graphics/dist/metricsgraphics.min.js"></script>
    <!-- countUp -->
    <script src="bower_components/countUp.js/dist/countUp.min.js"></script>
    <!-- handlebars.js -->
    <script src="bower_components/handlebars/handlebars.min.js"></script>
    <script src="assets/js/custom/handlebars_helpers.min.js"></script>
    <!-- CLNDR -->
    <script src="bower_components/clndr/clndr.min.js"></script>

    <!--  dashbord functions -->
    <script src="assets/js/pages/dashboard.min.js"></script>

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
    <!-- common functions -->
    <script src="assets/js/common.min.js"></script>
    <!-- uikit functions -->
    <script src="assets/js/uikit_custom.min.js"></script>
    <!-- page specific plugins -->
    <!-- datatables -->
    <script src="bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
    <!-- datatables buttons-->
    <script src="bower_components/datatables-buttons/js/dataTables.buttons.js"></script>
    <script src="assets/js/custom/datatables/buttons.uikit.js"></script>
    <script src="bower_components/jszip/dist/jszip.min.js"></script>
    <script src="bower_components/pdfmake/build/pdfmake.min.js"></script>
    <script src="bower_components/pdfmake/build/vfs_fonts.js"></script>
    <script src="bower_components/datatables-buttons/js/buttons.colVis.js"></script>
    <script src="bower_components/datatables-buttons/js/buttons.html5.js"></script>
    <script src="bower_components/datatables-buttons/js/buttons.print.js"></script>

    <!-- datatables custom integration -->
    <script src="assets/js/custom/datatables/datatables.uikit.min.js"></script>

    <!--  datatables functions -->
    <script src="assets/js/pages/plugins_datatables.min.js"></script>

</body>

</html>