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
    $result = "SELECT * FROM fmoj_staff WHERE id = ?";
    $stmt = $mysqli->prepare($result);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_object();
    $stmt->close();
}

//1.Books

//1.0 : Number of all book categories in the library
$result = "SELECT count(*) FROM tbl_treatiescategory";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($book_categories);
$stmt->fetch();
$stmt->close();

//1.1 : Number of all books no matter what category
$result = "SELECT COUNT(*) FROM tbl_treaties WHERE b_publisher = '$user->name' ";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($books);
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

//1.0.3 : Number Of Books under References Category
$result = "SELECT COUNT(*) FROM tbl_treaties WHERE tc_name = 'Memorandum of Understanding' AND b_publisher = '$user->name' ";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($mou);
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
            <div class="uk-grid uk-grid-width-large-1-5 uk-grid-width-medium-1-3 uk-grid-medium uk-sortable sortable-handler hierarchical_show text-center" data-uk-sortable data-uk-grid-margin>
                <div>
                    <div class="md-card">
                        <div class="md-card-content">
                            <div class="uk-float-right uk-margin-top uk-margin-small-right"></div>
                            <span class="uk-text-muted uk-text-small">Treaty Categories</span>
                            <h2 class="uk-margin-remove"><span class="countUpMe">0<noscript><?php echo $book_categories; ?></noscript></span></h2>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="md-card">
                        <div class="md-card-content">
                            <div class="uk-float-right uk-margin-top uk-margin-small-right"></div>
                            <span class="uk-text-muted uk-text-small">Treaty</span>
                            <h2 class="uk-margin-remove"><span class="countUpMe">0<noscript><?php echo $books; ?></noscript></span></h2>
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
                            <span class="uk-text-muted uk-text-small">Mou's</span>
                            <h2 class="uk-margin-remove"><span class="countUpMe">0<noscript><?php echo $mou; ?></noscript></span></h2>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pie Charts-->
            <div class="uk-grid">
                <div class="uk-width-1-1">
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
                        </div>
                    </div>
                </div>
            </div>

            <div class="uk-grid">
                <div class="uk-width-1-1">
                    <h4 class="heading_a uk-margin-bottom">Treaty</h4>
                    <div class="md-card">
                        <div class="md-card-content">
                            <table id="dt_tableExport" class="uk-table" cellspacing="0" width="100%">
                                <thead>
                                    <th>Title</th>
                                    <th>Publisher</th>
                                    <th>Category</th>
                                </thead>
                                <tbody>
                                    <?php
                                    $ret = "SELECT * FROM tbl_treaties WHERE b_publisher= '$user->name'";
                                    $stmt = $mysqli->prepare($ret);
                                    $stmt->execute(); //ok
                                    $res = $stmt->get_result();
                                    while ($row = $res->fetch_object()) {
                                    ?>
                                        <tr>
                                            <td class="uk-text-truncate"><?php echo $row->title; ?></td>
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
            var Piechart = new CanvasJS.Chart("PieChart", {
                exportEnabled: false,
                animationEnabled: true,
                title: {
                    text: "Percentage Of Treaties Per Category"
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
                            y: <?php echo $instruments; ?>,
                            name: "Instruments",
                            exploded: true
                        },

                        {
                            y: <?php echo $agreements; ?>,
                            name: " Agreements",
                            exploded: true
                        },

                        {
                            y: <?php echo $mou; ?>,
                            name: "Mou's",
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