<?php
/*
    *Handle Staff DASHBOARD page logic
    */
session_start();
include('assets/config/config.php');
include('assets/config/checklogin.php');
check_login();

if (isset($_SESSION['id'])) {
    // Get the user's ID and other details from the session
    $user_id = $_SESSION['id'];
    $result = "SELECT * FROM tbl_staff WHERE id = ?";
    $stmt = $mysqli->prepare($result);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_object();
    $stmt->close();
}

//1.Treaty

//1.0 : Number of all book categories in the library
$result = "SELECT count(*) FROM tbl_treatiescategory";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($treaty_categories);
$stmt->fetch();
$stmt->close();

//1.1 : Number of all treaty no matter what category
$result = "SELECT COUNT(*) FROM tbl_treaties WHERE b_publisher = '$user->name' ";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($user_treaty);
$stmt->fetch();
$stmt->close();

$result = "SELECT COUNT(*) FROM tbl_treaties WHERE approved = 0 ";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($pending);
$stmt->fetch();
$stmt->close();

$result = "SELECT COUNT(*) FROM tbl_treaties";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($total);
$stmt->fetch();
$stmt->close();

$result = "SELECT COUNT(*) FROM tbl_status";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($total_status);
$stmt->fetch();
$stmt->close();

$result = "SELECT COUNT(*) FROM tbl_treaties WHERE approved = 1 ";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($approved);
$stmt->fetch();
$stmt->close();

//1.0.1 : Number Of Books under Non-fiction Category
$result = "SELECT COUNT(*) FROM tbl_treaties WHERE tc_name = 'Instruments' AND b_publisher = '$user->name' ";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($instruments);
$stmt->fetch();
$stmt->close();

//1.0.2 : Number Of Books under Fiction Category
$result = "SELECT COUNT(*) FROM tbl_treaties WHERE tc_name = 'Agreements' AND b_publisher = '$user->name' ";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($agreements);
$stmt->fetch();
$stmt->close();

$result = "SELECT COUNT(*) FROM tbl_treaties WHERE tc_name = 'Conventions' AND b_publisher = '$user->name' ";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($conventions);
$stmt->fetch();
$stmt->close();

$result = "SELECT COUNT(*) FROM tbl_treaties WHERE tc_name = 'Protocols' AND b_publisher = '$user->name' ";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($protocols);
$stmt->fetch();
$stmt->close();

$result = "SELECT COUNT(*) FROM tbl_treaties WHERE tc_name = 'Treaty' AND b_publisher = '$user->name' ";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($treaty);
$stmt->fetch();
$stmt->close();

//1.0.3 : Number Of Books under References Category
$result = "SELECT COUNT(*) FROM tbl_treaties WHERE tc_name = 'Memorandum of Understanding' AND b_publisher = '$user->name' ";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($mou);
$stmt->fetch();
$stmt->close();

// check if $total is 0, if so, set it to 1 to avoid division by zero
$total = $total ?: 1;

$userTreatyPercentage = round(($user_treaty / $total) * 100, 2);
$diff = $total - $user_treaty;
$otherTreatyPercentage = round(($diff / $total) * 100, 2);

$pendingPercentage = round(($pending / $total) * 100, 1);
$approvedPercentage = round(($approved / $total) * 100, 1);

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
            <div class="uk-grid uk-grid-width-large-1-4 uk-grid-width-medium-1-3 uk-grid-medium uk-sortable sortable-handler hierarchical_show text-center" data-uk-sortable data-uk-grid-margin>
                <div>
                    <div class="md-card">
                        <div class="md-card-content">
                            <div class="uk-float-right uk-margin-top uk-margin-small-right"></div>
                            <span class="uk-text-muted uk-text-small">Treaty Categories</span>
                            <h2 class="uk-margin-remove"><span class="countUpMe">0<noscript><?= $treaty_categories; ?></noscript></span></h2>
                        </div>
                    </div>
                </div>
                <?php if ($user->role == 'supervisor') : ?>
                    <div>
                        <div class="md-card">
                            <div class="md-card-content">
                                <div class="uk-float-right uk-margin-top uk-margin-small-right"></div>
                                <span class="uk-text-muted uk-text-small">Number of Status</span>
                                <h2 class="uk-margin-remove"><span class="countUpMe">0<noscript><?= $total_status; ?></noscript></span></h2>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="md-card">
                            <div class="md-card-content">
                                <div class="uk-float-right uk-margin-top uk-margin-small-right"></div>
                                <span class="uk-text-muted uk-text-small">Number of Treaty</span>
                                <h2 class="uk-margin-remove"><span class="countUpMe">0<noscript><?= $total; ?></noscript></span></h2>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="md-card">
                            <div class="md-card-content">
                                <div class="uk-float-right uk-margin-top uk-margin-small-right"></div>
                                <span class="uk-text-muted uk-text-small">Pending Treaty</span>
                                <h2 class="uk-margin-remove"><span class="countUpMe">0<noscript><?= $pending; ?></noscript></span></h2>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="md-card">
                            <div class="md-card-content">
                                <div class="uk-float-right uk-margin-top uk-margin-small-right"></div>
                                <span class="uk-text-muted uk-text-small">Approved Treaty</span>
                                <h2 class="uk-margin-remove"><span class="countUpMe">0<noscript><?= $approved; ?></noscript></span></h2>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if ($user->role == 'staff') : ?>
                    <div>
                        <div class="md-card">
                            <div class="md-card-content">
                                <div class="uk-float-right uk-margin-top uk-margin-small-right"></div>
                                <span class="uk-text-muted uk-text-small">Treaty</span>
                                <h2 class="uk-margin-remove"><span class="countUpMe">0<noscript><?php echo $user_treaty; ?></noscript></span></h2>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="md-card">
                            <div class="md-card-content">
                                <div class="uk-float-right uk-margin-top uk-margin-small-right"></div>
                                <span class="uk-text-muted uk-text-small">Instruments</span>
                                <h2 class="uk-margin-remove"><span class="countUpMe">0<noscript><?php echo $instruments; ?></noscript></span></h2>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="md-card">
                            <div class="md-card-content">
                                <div class="uk-float-right uk-margin-top uk-margin-small-right"></div>
                                <span class="uk-text-muted uk-text-small">Agreements</span>
                                <h2 class="uk-margin-remove"><span class="countUpMe">0<noscript><?php echo $agreements; ?></noscript></span></h2>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="md-card">
                            <div class="md-card-content">
                                <div class="uk-float-right uk-margin-top uk-margin-small-right"></div>
                                <span class="uk-text-muted uk-text-small">Conventions</span>
                                <h2 class="uk-margin-remove"><span class="countUpMe">0<noscript><?php echo $conventions; ?></noscript></span></h2>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="md-card">
                            <div class="md-card-content">
                                <div class="uk-float-right uk-margin-top uk-margin-small-right"></div>
                                <span class="uk-text-muted uk-text-small">Protocols</span>
                                <h2 class="uk-margin-remove"><span class="countUpMe">0<noscript><?php echo $protocols; ?></noscript></span></h2>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="md-card">
                            <div class="md-card-content">
                                <div class="uk-float-right uk-margin-top uk-margin-small-right"></div>
                                <span class="uk-text-muted uk-text-small">Treaty Category</span>
                                <h2 class="uk-margin-remove"><span class="countUpMe">0<noscript><?php echo $treaty; ?></noscript></span></h2>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="md-card">
                            <div class="md-card-content">
                                <div class="uk-float-right uk-margin-top uk-margin-small-right"></div>
                                <span class="uk-text-muted uk-text-small">Mou's</span>
                                <h2 class="uk-margin-remove"><span class="countUpMe">0<noscript><?php echo $mou; ?></noscript></span></h2>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Pie Charts Supervisor-->
            <div class="uk-grid">
                <div class="<?= ($user->role == 'staff') ? 'uk-width-1-2' : 'uk-width-1-1'; ?>">

                    <div class="md-card">
                        <div class="md-card-toolbar">
                            <div class="md-card-toolbar-actions">
                                <i class="md-icon material-icons md-card-fullscreen-activate">&#xE5D0;</i>
                                <i class="md-icon material-icons">&#xE5D5;</i>

                            </div>
                        </div>
                        <div class="md-card-content">
                            <div class="mGraph-wrapper">
                                <div id="PieChart_supervisor" class="mGraph" style="height: 400px; max-width: 900px; margin: 0px auto;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pie Charts Staff-->
                <?php if ($user->role == 'staff') : ?>
                    <div class="uk-width-1-2">
                        <div class="md-card">
                            <div class="md-card-toolbar">
                                <div class="md-card-toolbar-actions">
                                    <i class="md-icon material-icons md-card-fullscreen-activate">&#xE5D0;</i>
                                    <i class="md-icon material-icons">&#xE5D5;</i>
                                </div>
                            </div>
                            <div class="md-card-content">
                                <div class="mGraph-wrapper">
                                    <div id="PieChart_staff" class="mGraph" style="height: 400px; max-width: 900px; margin: 0px auto;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <div class="uk-grid">
                <div class="uk-width-1-1">
                    <h4 class="heading_a uk-margin-bottom">Treaty</h4>
                    <div class="md-card">
                        <div class="md-card-content">
                            <table id="dt_tableExport" class="uk-table" cellspacing="0" width="100%">
                                <thead>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th>Publisher</th>
                                    <th>Category</th>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($user->role == 'supervisor') {
                                        $ret = "SELECT * FROM tbl_treaties";
                                    } else {
                                        $ret = "SELECT * FROM tbl_treaties WHERE b_publisher= '$user->name'";
                                    }
                                    $stmt = $mysqli->prepare($ret);
                                    $stmt->execute(); //ok
                                    $res = $stmt->get_result();
                                    while ($row = $res->fetch_object()) {
                                        if ($row->approved == 1) {
                                            $btn_status = "<td><span class='uk-badge uk-badge-primary'>Approved</span>
                                    </td>";
                                        } else {
                                            $btn_status = "<td><span class='uk-badge uk-badge-default'>Pending</span>
                                    </td>";
                                        }
                                    ?>
                                        <tr>
                                            <td><span class="trim"><?= $row->title; ?></span></td>
                                            <?= $btn_status ?>
                                            <td class="uk-text-primary"><?php echo $row->b_publisher; ?></td>
                                            <td><?php echo $row->tc_name; ?></td>
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

    <!--Load Canvas JS -->
    <script src="assets/js/canvasjs.min.js"></script>
    <!--Load Few Charts-->

    <script>
        window.onload = function() {
            <?php if ($user->role === 'staff') : ?>
                var staff_Piechart = new CanvasJS.Chart("PieChart_staff", {
                    exportEnabled: false,
                    animationEnabled: true,
                    title: {
                        text: "Percentage Of Treaties Uploaded Comparison"
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
                                y: <?= $otherTreatyPercentage; ?>,
                                name: "Treaties uploaded by other staffs",
                                exploded: true
                            },

                            {
                                y: <?= $userTreatyPercentage; ?>,
                                name: "Treaties uploaded by me",
                                exploded: true
                            },
                        ]
                    }]
                });
                staff_Piechart.render();
            <?php endif; ?>

            var Piechart = new CanvasJS.Chart("PieChart_supervisor", {
                exportEnabled: false,
                animationEnabled: true,
                title: {
                    text: "Percentage Of Treaties Approval Status"
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
                            y: <?= $approvedPercentage; ?>,
                            name: "Approved",
                            exploded: true
                        },

                        {
                            y: <?= $pendingPercentage; ?>,
                            name: "Pending",
                            exploded: true
                        }
                    ]
                }]
            });
            

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