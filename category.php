<?php
require_once('sudo/assets/config/config.php');
?>
<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Category - National Depository Of Treaties</title>
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
    <?php
    $category_id = $_GET['id'];
    $ret = "SELECT * FROM  tbl_treatiescategory WHERE id = ?";
    $stmt = $mysqli->prepare($ret);
    $stmt->bind_param('s', $category_id);
    $stmt->execute(); //ok
    $res = $stmt->get_result();
    while ($row1 = $res->fetch_object()) {
    ?>
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
                                <li>
                                    <a href="treaties.php">CATALOGUES</a>
                                </li>
                                <li>
                                    <a href="staff/pages_staff_index.php">UPLOAD TREATY</a>
                                </li>
                                <li>
                                    <a href="sudo/pages_sudo_index.php">LOGIN</a>
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
                                <h1 class="text-white">Category: <i><?= $row1->name; ?></i></h1>
                                <h4 class="text-white">Choose your treaty document and proceed to view/preview it</h4>
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
        <section id="scroll_view">
            <div class="container">
                <div class="space-50"></div>
                <div class="">
                    <div class="row">
                        <!-- <div class="col-xs-12 col-md-6">
                                <label class="control-label" for="sort">Search by title : </label>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Document Name ...">
                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-primary"><i class="icofont icofont-search-alt-2"></i></button>
                                    </div>
                                </div>
                            </div> -->

                        <div class="col-xs-12 col-md-6 pull-right">
                            <form class="form-horizontal">
                                <div class="form-group" style="margin-bottom: 0;">
                                    <label class="control-label" for="sort">Filter by year : </label>
                                    <div class="form-group">
                                        <select onchange="filterByYear()" name="treaty_year" id="treaty_year" class="form-control" />
                                        <option value="">--Select Year--</option>
                                        <?php
                                        $ret = "SELECT DISTINCT treaty_year FROM tbl_treaties WHERE tc_id = $row1->id ORDER BY treaty_year ASC";
                                        $stmt = $mysqli->prepare($ret);
                                        $stmt->execute(); //ok
                                        $res = $stmt->get_result();
                                        $selected_year = isset($_GET['year']) ? $_GET['year'] : '';
                                        while ($row = $res->fetch_object()) {
                                            $selected = ($row->treaty_year == $selected_year) ? 'selected' : '';
                                        ?>
                                            <option value="<?= $row->treaty_year ?>" <?= $selected ?>><?= $row->treaty_year ?></option>
                                        <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </form>
                            <!-- ----- -->

                            <div>
                                <?php
                                $selected_year = isset($_GET['year']) ? $_GET['year'] : '';
                                $query_string = $_SERVER['QUERY_STRING'];
                                $query_string = preg_replace('/&year=[^&]+/', '', $query_string);
                                $query_string = preg_replace('/^&/', '', $query_string);

                                if (!empty($query_string)) {
                                    $query_string = '?' . $query_string;
                                }
                                ?>

                                <?php if ($selected_year) : ?>
                                    <a style="margin-left: -28px" href="<?= $_SERVER['PHP_SELF'] . $query_string ?>" class="btn btn-primary">Clear Filter</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <?php
                    if (isset($_GET['year'])) {
                        $selectedYear = $_GET['year'];
                        $ret = "SELECT * FROM tbl_treaties WHERE tc_id = $row1->id AND treaty_year = ? ORDER BY treaty_year DESC";
                        $stmt = $mysqli->prepare($ret);
                        $stmt->bind_param('s', $selectedYear);
                        $stmt->execute();
                        $res = $stmt->get_result();
                    } else {
                        $ret = "SELECT * FROM tbl_treaties WHERE tc_id = $row1->id ORDER BY treaty_year DESC";
                        $stmt = $mysqli->prepare($ret);
                        $stmt->execute();
                        $res = $stmt->get_result();
                    }

                    while ($row = $res->fetch_object()) {
                        // Display the data
                    ?>
                        <!-- PDF, DOCX -->
                        <!-- Add a description field -->
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="category-item well green">
                                <div class="media">
                                    <div class="media-body">
                                        <h5><img src="images/file_icon.png" alt='<?= $row->title; ?>' />&ensp;<span class="trim"><?= $row->title; ?></span></h5>
                                        <h6>Category: <?= $row->tc_name; ?></h6>
                                        <h6>Year: <?= $row->treaty_year; ?></h6>
                                        <h6>Status: <i><?= $row->s_status; ?></i></h6>
                                        <div class="space-5"></div>
                                        <div class="title-bar blue text-center">
                                            <ul class="list-inline list-unstyled">
                                                <li><i class="icofont icofont-square"></i></li>
                                            </ul>
                                        </div>
                                        <div class="space-10"></div>
                                        <div class="row">
                                            <div class="col-md-4"> <a href="treaty.php?doc_id=<?php echo $row->id; ?>" class="text-primary">View</a></div>

                                            <div class="col-md-8">
                                                <img src="images/card-logo.png" alt='<?= $row->title; ?>' class="img-responsive" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="space-80"></div>
        </section>
    <?php } ?>
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
        function filterByYear() {
            var selectedYear = document.getElementById("treaty_year").value;
            window.location.href = "category.php?id=<?= $_GET['id'] ?>&year=" + selectedYear;
        }
    </script>
    <script>
        // Check if treaty parameter exists in URL
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('id')) {
            // Scroll smoothly to screen_view element
            const element = document.getElementById('scroll_view');
            element.scrollIntoView({
                behavior: 'smooth'
            });
        }
    </script>
</body>


</html>