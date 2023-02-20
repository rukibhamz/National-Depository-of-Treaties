<?php
require_once('sudo/assets/config/config.php');
?>
<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Treaties - National Depository Of Treaties</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Place favicon.ico in the root directory -->
    <link rel="apple-touch-icon" href="images/apple-touch-icon.png">
    <link rel="shortcut icon" type="image/ico" href="images/ico.png" />

    <!-- Plugin-CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/icofont.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/cardslider.css">
    <link rel="stylesheet" href="css/responsiveslides.css">

    <!-- Main-Stylesheets -->
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/overright.css">
    <link rel="stylesheet" href="css/theme.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <script src="js/vendor/modernizr-2.8.3.min.js"></script>
</head>

<body data-spy="scroll" data-target="#mainmenu" data-offset="50">

    <header class="relative" id="sc1">
        <!-- Header-background-markup -->
        <div class="overlay-bg relative">
            <img src="images/slide/02.png" alt="">
        </div>
        <!-- Mainmenu-markup-start -->
        <div class="mainmenu-area navbar-fixed-top" data-spy="affix" data-offset-top="10">
            <nav class="navbar">
                <div class="container">
                    <div class="navbar-header">
                        <div class="space-10"></div>
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#mainmenu" aria-expanded="false">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <!--Logo-->
                        <a href="index.php" class="navbar-left show"><img src="images/logo-2.png" alt="library" width="70%" class="img-responsive"></a>
                        <div class="space-10"></div>
                    </div>
                    <!--Toggle-button-->

                    <!--Mainmenu list-->
                    <div class="collapse navbar-collapse navbar-right" id="mainmenu">
                        <ul class="nav navbar-nav nav-white text-uppercase">
                            <li>
                                <a href="index.php">Home</a>
                            </li>
                            <li class="active">
                                <a href="treaties.php">CATALOGUES</a>
                            </li>
                            <li>
                                <a href="staff/pages_staff_index.php" title="Staff Login">UPLOAD TREATY</a>
                            </li>
                            <li>
                                <a href="sudo/pages_sudo_index.php" title="Admin Login">LOGIN</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
        <div class="space-100"></div>
        <!-- Mainmenu-markup-end -->
        <!-- Header-jumbotron -->
        <div class="space-100"></div>
        <div class="header-text">
            <div class="container">
                <div class="row wow fadeInUp">
                    <div class="col-xs-12 col-sm-10 col-sm-offset-1 text-center">
                        <div class="jumbotron">
                            <h1 class="text-white">Choose your treaty document and proceed to view/preview it</h1>
                        </div>
                        <div class="title-bar white">
                            <ul class="list-inline list-unstyled">
                                <li><i class="icofont icofont-square"></i></li>
                                <li><i class="icofont icofont-square"></i></li>
                            </ul>
                        </div>
                        <div class="space-40"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="space-100"></div>
        <!-- Header-jumbotron-end -->
    </header>
    <section id="screen_view">
        <div class="space-80"></div>
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-md-9 pull-right">
                    <h4>Search Box</h4>
                    <div class="space-5"></div>
                    <form action="treaties.php">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Enter document name" name="treaty">
                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-primary"><i class="icofont icofont-search-alt-2"></i></button>
                            </div>
                        </div>

                        <div>
                            <?php
                              $selected_year = isset($_GET['treaty']) ? $_GET['treaty'] : '';
                              $query_string = $_SERVER['QUERY_STRING'];
                              $query_string = preg_replace('/\?treaty=[^&]+&?/', '', $query_string);
                              if (!empty($query_string)) {
                                  $query_string = '?' . $query_string;
                              }
                            ?>

                            <?php if ($selected_year) : ?>
                                <a href="<?= $_SERVER['PHP_SELF'] . $query_string ?>" class="btn btn-primary">Clear Filter</a>
                            <?php endif; ?>
                        </div>
                    </form>
                    <div class="space-10"></div>
                    <hr>
                    <div class="space-10"></div>
                    <div class="row">
                        <!--Treaty-->
                        <?php
                        if (isset($_GET['treaty'])) {
                            $treaty = $_GET['treaty'];
                            $ret = "SELECT * FROM tbl_treaties WHERE CONCAT(title, tc_name, s_status) LIKE ? ORDER BY id DESC";
                            $stmt = $mysqli->prepare($ret);
                            $treaty_query = "%$treaty%";
                            $stmt->bind_param('s', $treaty_query);
                            $stmt->execute();
                            $res = $stmt->get_result();
                        } else {
                            $ret = "SELECT * FROM tbl_treaties ORDER BY id DESC";
                            $res = $mysqli->query($ret);
                        }

                        if ($res->num_rows > 0) {
                            while ($row = $res->fetch_object()) {

                        ?>
                                <!-- PDF, DOCX -->
                                <!-- Add a description field -->
                                <div class="col-xs-12 col-md-6">
                                    <div class="category-item well green">
                                        <div class="media">
                                            <div class="media-body">
                                                <h5><img src="images/file_icon.png" alt='<?= $row->title; ?>' />&ensp;<span class="trim"><?= $row->title; ?></span></h5>
                                                <h6>Category: <?= $row->tc_name; ?></h6>
                                                <h6>Status: <i><?= $row->s_status; ?></i></h6>
                                                <div class="space-10"></div>
                                                <div class="title-bar blue text-center">
                                                    <ul class="list-inline list-unstyled">
                                                        <li><i class="icofont icofont-square"></i></li>
                                                    </ul>
                                                </div>
                                                <div class="space-10"></div>
                                                <div class="row">
                                                    <div class="col-md-4"> <a href="treaty.php?doc_id=<?= $row->id; ?>" class="text-primary">View</a></div>

                                                    <div class="col-md-8">
                                                        <img src="images/card-logo.png" alt='<?= $row->title; ?>' class="img-responsive" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        <?php }
                        } else {
                            echo "<h3 class='text-center'>No Treaty Found!</h3>";
                        } ?>
                        <!--Treaty-->

                    </div>
                    <div class="space-60"></div>
                </div>
                <!-- Sidebar-Start -->
                <div class="col-xs-12 col-md-3">
                    <aside class="side_query">
                        <h3><i class="icofont icofont-filter"></i> Filter By</h3>
                        <div class="space-30"></div>
                        <div class="sigle-sidebar">
                            <h4>Treaties Categories</h4>
                            <hr>
                            <ul id="category_list" class="list-unstyled menu-tip">
                                <?php
                                $ret = "SELECT * FROM  tbl_treatiescategory";
                                $stmt = $mysqli->prepare($ret);
                                $stmt->execute(); //ok
                                $res = $stmt->get_result();
                                while ($row = $res->fetch_object()) {
                                ?>
                                    <li><a href="" onclick="updateTreaty('<?= $row->name; ?>')" class="text-success"><?= $row->name; ?></a></li>
                                <?php } ?>
                            </ul>
                        </div>
                        <div class="space-20"></div>
                        <div class="single-sidebar">
                            <h4>Treaties Status</h4>
                            <hr>
                            <form action="treaties.php">
                                <ul id="status-list" class="list-unstyled menu-tip">
                                    <?php
                                    $ret = "SELECT * FROM  tbl_status";
                                    $stmt = $mysqli->prepare($ret);
                                    $stmt->execute(); //ok
                                    $res = $stmt->get_result();
                                    while ($row = $res->fetch_object()) {
                                    ?>
                                        <li><a href="" onclick="updateTreaty('<?= $row->name; ?>')" class="text-success"><?= $row->name; ?></a></li>
                                    <?php } ?>
                                </ul>
                            </form>
                        </div>
                        <div class="space-20"></div>
                    </aside>
                </div>
                <!-- Sidebar-End -->
            </div>
        </div>
        <div class="space-80"></div>
    </section>

    <!--Footer-->
    <?php require_once('partials/footer.php'); ?>
    <!-- Footer-Area-End -->

    <!-- Vandor-JS -->
    <script src="js/vendor/jquery-1.12.4.min.js"></script>
    <script src="js/vendor/bootstrap.min.js"></script>
    <!-- Plugin-JS -->
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/responsiveslides.min.js"></script>
    <script src="js/jquery.cardslider.min.js"></script>
    <script src="js/pagination.js"></script>
    <script src="js/scrollUp.min.js"></script>
    <script src="js/wow.min.js"></script>
    <script src="js/plugins.js"></script>
    <!-- Active-JS -->
    <script src="js/main.js"></script>
    <script>
        const updateTreaty = (val) => {
            const url = new URL(window.location.href);
            url.searchParams.set('treaty', val);
            window.history.replaceState({}, '', url);
        }
    </script>
    <script>
        // Check if treaty parameter exists in URL
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('treaty')) {
            // Scroll smoothly to screen_view element
            const element = document.getElementById('screen_view');
            element.scrollIntoView({
                behavior: 'smooth'
            });
        }
    </script>


</body>


</html>