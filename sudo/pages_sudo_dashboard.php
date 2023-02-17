<?php
/*
    *Handle SUDO DASHBOARD page logic
    */
session_start();
include('assets/config/config.php');
include('assets/config/checklogin.php');
check_login();

//1.Treaty

//1.0 : Number of all treaty categories in the library
$result = "SELECT count(*) FROM tbl_treatiescategory";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($treaty_categories);
$stmt->fetch();
$stmt->close();

//1.1 : Number of all treaty by category
$result = "SELECT COUNT(*) FROM tbl_treaties WHERE s_status='Published'";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($treaty_published);
$stmt->fetch();
$stmt->close();

$result = "SELECT COUNT(*) FROM tbl_treaties";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($treaty_total);
$stmt->fetch();
$stmt->close();

$result = "SELECT COUNT(*) FROM tbl_treaties WHERE s_status='Revised'";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($treaty_revised);
$stmt->fetch();
$stmt->close();

$result = "SELECT COUNT(*) FROM tbl_treaties WHERE s_status='Running'";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($treaty_running);
$stmt->fetch();
$stmt->close();

//2.0 : Number of Staff
$result = "SELECT count(*) FROM fmoj_staff WHERE acc_status='Active'";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($active_staff);
$stmt->fetch();
$stmt->close();

$result = "SELECT count(*) FROM fmoj_staff WHERE acc_status='Suspended'";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($suspended_staff);
$stmt->fetch();
$stmt->close();

//1.0.1 : Number Of Treaty under a Category
$result = "SELECT COUNT(*) FROM tbl_treaties WHERE tc_name = 'Instruments' ";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($Instruments);
$stmt->fetch();
$stmt->close();

$result = "SELECT COUNT(*) FROM tbl_treaties WHERE tc_name = 'Agreements' ";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($Agreements);
$stmt->fetch();
$stmt->close();

$result = "SELECT COUNT(*) FROM tbl_treaties WHERE tc_name = 'Memorandum of Understanding' ";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($Memorandum_of_Understanding);
$stmt->fetch();
$stmt->close();
$ret = "SELECT * FROM  tbl_status";

$result = "SELECT COUNT(*) FROM tbl_status";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($treaty_status);
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
        <div id="page_content_inner">

            <!--1.Treaty-->
            <h3 class="text">Treaty Database Analytics</h3>
            <div class="uk-grid uk-grid-width-large-1-4 uk-grid-width-medium-1-2 uk-grid-large uk-sortable sortable-handler hierarchical_show" data-uk-sortable data-uk-grid-margin>
                <div>
                    <div class="md-card">
                        <div class="md-card-content">
                            <div class="uk-float-right uk-margin-top uk-margin-small-right"></div>
                            <h2 class="uk-margin-remove"><span class="countUpMe"><?= $treaty_total; ?></span></h2>
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
                            <a href="treaty_sudo_all_treaties.php">
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
                            <h2 class="uk-margin-remove"><span class="countUpMe"><?= $treaty_published; ?></span></h2>
                            <div class="space-10"></div>
                            <p class="text">Total treaties Published</p>

                            <div class="space-10"></div>
                            <div class="title-bar black">
                                <ul class="list-inline list-unstyled">
                                    <li><i class="icofont icofont-square"></i></li>
                                </ul>
                            </div>
                            <div class="space-10"></div>
                            <a href="treaty_sudo_published_treaties.php">
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
                            <h2 class="uk-margin-remove"><span class="countUpMe"><?= $treaty_revised; ?></span></h2>
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
                            <a href="treaty_sudo_revised_treaties.php">
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
                            <h2 class="uk-margin-remove"><span class="countUpMe"><?= $treaty_running; ?></span></h2>
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
                            <a href="treaty_sudo_running_treaties.php">
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
            <h3 class="text">Analytics</h3>
            <div class="uk-grid uk-grid-width-large-1-4 uk-grid-width-medium-1-2 uk-grid-large uk-sortable sortable-handler hierarchical_show" data-uk-sortable data-uk-grid-margin>
                <div>
                    <div class="md-card card-alt">
                        <div class="md-card-content">
                            <div class="uk-float-right uk-margin-top uk-margin-small-right"></div>
                            <h2 class="uk-margin-remove"><span class="countUpMe"><?= $active_staff; ?></span></h2>
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
                            <a href="treaty_sudo_upload_manage_access.php">
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
                            <h2 class="uk-margin-remove"><span class="countUpMe"><?= $suspended_staff; ?></span></h2>
                            <div class="space-10"></div>
                            <p class="text">Suspended
                                User</p>

                            <div class="space-10"></div>
                            <div class="title-bar white">
                                <ul class="list-inline list-unstyled">
                                    <li><i class="icofont icofont-square"></i></li>
                                </ul>
                            </div>
                            <div class="space-10"></div>
                            <a href="treaty_sudo_upload_manage_access.php">
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
                            <h2 class="uk-margin-remove"><span class="countUpMe"><?= $treaty_categories; ?></span></h2>
                            <div class="space-10"></div>
                            <p class="text">Categories</p>

                            <div class="space-10"></div>
                            <div class="title-bar white">
                                <ul class="list-inline list-unstyled">
                                    <li><i class="icofont icofont-square"></i></li>
                                </ul>
                            </div>
                            <div class="space-10"></div>
                            <a href="pages_sudo_manage_categories.php">
                                <p class="text">View Categories <img src="assets/img/arrow_icon_white.png" alt="arrow icon" width="35px" /></p>
                            </a>
                        </div>
                    </div>
                    <div class="space-10"></div>
                </div>

                <div>
                    <div class="md-card card-alt">
                        <div class="md-card-content">
                            <div class="uk-float-right uk-margin-top uk-margin-small-right"></div>
                            <h2 class="uk-margin-remove"><span class="countUpMe"><?= $treaty_status; ?></span></h2>
                            <div class="space-10"></div>
                            <p class="text">Status</p>

                            <div class="space-10"></div>
                            <div class="title-bar white">
                                <ul class="list-inline list-unstyled">
                                    <li><i class="icofont icofont-square"></i></li>
                                </ul>
                            </div>
                            <div class="space-10"></div>
                            <a href="treaty_sudo_manage_status.php">
                                <p class="text">View Status <img src="assets/img/arrow_icon_white.png" alt="arrow icon" width="35px" /></p>
                            </a>
                        </div>
                    </div>
                    <div class="space-10"></div>
                </div>

                <!-- ----- -->

                <div>
                    <div class="md-card card-alt">
                        <div class="md-card-content">
                            <div class="uk-float-right uk-margin-top uk-margin-small-right"></div>
                            <h2 class="uk-margin-remove"><span class="countUpMe"><?= $Instruments; ?></span></h2>
                            <div class="space-10"></div>
                            <p class="text">Instruments</p>

                            <div class="space-10"></div>
                            <div class="title-bar white">
                                <ul class="list-inline list-unstyled">
                                    <li><i class="icofont icofont-square"></i></li>
                                </ul>
                            </div>
                            <div class="space-10"></div>
                        </div>
                    </div>
                    <div class="space-10"></div>
                </div>
                <div>
                    <div class="md-card card-alt">
                        <div class="md-card-content">
                            <div class="uk-float-right uk-margin-top uk-margin-small-right"></div>
                            <h2 class="uk-margin-remove"><span class="countUpMe"><?= $Agreements; ?></span></h2>
                            <div class="space-10"></div>
                            <p class="text">Agreements</p>

                            <div class="space-10"></div>
                            <div class="title-bar white">
                                <ul class="list-inline list-unstyled">
                                    <li><i class="icofont icofont-square"></i></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="space-10"></div>
                </div>
                <div>
                    <div class="md-card card-alt">
                        <div class="md-card-content">
                            <div class="uk-float-right uk-margin-top uk-margin-small-right"></div>
                            <h2 class="uk-margin-remove"><span class="countUpMe"><?= $Memorandum_of_Understanding; ?></span></h2>
                            <div class="space-10"></div>
                            <p class="text">Mou's</p>

                            <div class="space-10"></div>
                            <div class="title-bar white">
                                <ul class="list-inline list-unstyled">
                                    <li><i class="icofont icofont-square"></i></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="space-10"></div>
                </div>
            </div>
            <!-- ----------- -->
            <div class="uk-grid uk-grid-width-large-1-2 uk-grid-width-medium-1-1 uk-grid-large" data-uk-grid-margin>
                <div>
                    <div class="md-card">
                        <div class="md-card-toolbar">
                            <div class="md-card-toolbar-actions">
                                <i class="md-icon material-icons md-card-fullscreen-activate">&#xE5D0;</i>
                                <!-- <i class="md-icon material-icons" id="print" onclick="printContent('Print_Content');">&#xE8ad;</i> -->
                                <i class="md-icon material-icons">&#xE5D5;</i>

                            </div>
                        </div>
                        <div class="md-card-content">

                            <div class="mGraph-wrapper">
                                <div id="PieChart" class="mGraph" style="height: 400px; max-width: 900px; margin: 0px auto;"></div>
                            </div>
                            <!-- -------- -->

                        </div>
                    </div>
                </div>

                <div>
                    <div class="md-card">
                        <div class="md-card-toolbar">
                            <div class="md-card-toolbar-actions">
                                <i class="md-icon material-icons md-card-fullscreen-activate">&#xE5D0;</i>
                                <!-- <i class="md-icon material-icons" id="print" onclick="printContent('Print_Content');">&#xE8ad;</i> -->
                                <i class="md-icon material-icons">&#xE5D5;</i>
                            </div>
                        </div>
                        <div class="md-card-content">
                            <div class="mGraph-wrapper">
                                <div id="Doughnut" class="mGraph" style="height: 400px; max-width: 900px; margin: 0px auto;"></div>
                            </div>
                            <!-- -------- -->
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

    <!--Load Canvas JS -->
    <script src="assets/js/canvasjs.min.js"></script>
    <!--Load Few Charts-->
    <script>
        window.onload = function() {

            var Piechart = new CanvasJS.Chart("PieChart", {
                exportEnabled: false,
                animationEnabled: true,
                title: {
                    text: "Percentage Of Treaty's Per Category"
                },
                legend: {
                    cursor: "pointer",
                    itemclick: explodePie
                },
                data: [{
                    type: "pie",
                    showInLegend: true,
                    toolTipContent: "{name}: <strong>{y}%</strong>",
                    indexLabel: "{name} - {y}%",
                    dataPoints: [{
                            y: <?= $Instruments; ?>,
                            name: "Instruments",
                            exploded: true
                        },

                        {
                            y: <?= $Agreements; ?>,
                            name: " Agreements",
                            exploded: true
                        },

                        {
                            y: <?= $Memorandum_of_Understanding; ?>,
                            name: "Memorandum of Understanding",
                            exploded: true
                        }
                    ]
                }]
            });

            var chart = new CanvasJS.Chart("Doughnut", {
                animationEnabled: true,
                title: {
                    text: "Treaty Status At Glance",
                    //horizontalAlign: "centre"
                },
                data: [{
                    type: "doughnut",
                    startAngle: 60,
                    //innerRadius: 60,
                    indexLabelFontSize: 17,
                    indexLabel: "{label}:{y} (#percent%)",
                    toolTipContent: "{label} - #percent%",
                    dataPoints: [{
                            y: <?= $treaty_published; ?>,
                            label: "Published"
                        },
                        {
                            y: <?= $treaty_revised; ?>,
                            label: "Revised"
                        },
                        {
                            y: <?= $treaty_running; ?>,
                            label: "Running"
                        }

                    ]
                }]
            });


            chart.render();
            Piechart.render();

        }

        function explodePie(e) {
            if (typeof(e.dataSeries.dataPoints[e.dataPointIndex].exploded) === "undefined" || !e.dataSeries.dataPoints[e.dataPointIndex].exploded) {
                e.dataSeries.dataPoints[e.dataPointIndex].exploded = true;
            } else {
                e.dataSeries.dataPoints[e.dataPointIndex].exploded = false;
            }
            e.chart.render();

        }
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
    <!-- chartist (charts) -->
    <script src="bower_components/chartist/dist/chartist.min.js"></script>
    <script src="bower_components/maplace-js/dist/maplace.min.js"></script>
    <!-- peity (small charts) -->
    <script src="bower_components/peity/jquery.peity.min.js"></script>
    <!-- easy-pie-chart (circular statistics) -->
    <script src="bower_components/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js"></script>
    <!-- countUp -->
    <script src="bower_components/countUp.js/dist/countUp.min.js"></script>
    <!-- handlebars.js -->
    <script src="bower_components/handlebars/handlebars.min.js"></script>
    <script src="assets/js/custom/handlebars_helpers.min.js"></script>
    <!-- CLNDR -->
    <script src="bower_components/clndr/clndr.min.js"></script>

    <!--  dashbord functions -->
    <script src="assets/js/pages/dashboard.min.js"></script>
</body>

</html>