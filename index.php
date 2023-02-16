<?php
require_once('sudo/assets/config/config.php');
?>
<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Home - National Depository Of Treaties</title>
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
        <div class="header-bg relative home-slide">
            <div class="item">
                <img src="images/slide/01.png" alt="Treaty_DataBase">
            </div>
            <div class="item">
                <img src="images/slide/02.png" alt="Treaty_DataBase">
            </div>
            <div class="item">
                <img src="images/slide/03.png" alt="Treaty_DataBase">
            </div>
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
                        <a href="#sc1" class="navbar-left show"><img src="images/logo-2.png" alt="Treaty_DataBase" width="70%" class="img-responsive"></a>
                        <div class="space-10"></div>
                    </div>
                    <!--Toggle-button-->

                    <!--Mainmenu list-->
                    <!-- navbar-right in fade -->
                    <div class="collapse navbar-collapse navbar-right" id="mainmenu">
                        <ul class="nav navbar-nav nav-white text-uppercase">
                            <li class="active">
                                <a href="#sc1">Home</a>
                            </li>
                            <li>
                                <a href="books.php">CATALOGUES</a>
                            </li>
                            <li>
                                <a href="">UPLOAD TREATY</a>
                            </li>
                            <!-- <li>
                                <a href="lib_user/pages_std_index.php">LOGIN</a>
                            </li>
                                    <li>
                                <a href="lib_user/pages_std_index.php">Library User Login</a>
                            </li>
                            <li>
                                <a href="staff/pages_staff_index.php">Staff Login</a>
                            </li> -->
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
                            <h1 class="text-white">National Depository Of Treaties</h1>
                            <p class="text-white">Lörem ipsum vulkanresa vät unyna dint. Sonde säpojogg antisk ektiga, som vårdvisare
                                . Kropp antipatologi än astrortad diligen ifall sonilingar. </p>
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
                <div class="row wow fadeInUp" data-wow-delay="0.5s">
                    <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 ">
                        <div class="panel">
                            <div class="panel-heading">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a data-toggle="tab" href="#treaty">Treaty Database</a></li>
                                </ul>
                            </div>
                            <div class="panel-body">
                                <div class="tab-content">
                                    <div class="tab-pane fade in active" id="treaty">
<<<<<<< Updated upstream
                                        <form action="books.php">
=======
                                        <form action="treaties.php" method="POST">
>>>>>>> Stashed changes
                                            <div class="input-group">
                                                <input type="text" name="treaty_search" 
                                                class="form-control" placeholder="Enter document title">
                                                <div class="input-group-btn">
                                                    <button type="submit" class="btn btn-primary px-3">Search <i class="icofont icofont-search-alt-2"></i></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade" id="author">
                                        <form action="#">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Enter author name">
                                                <div class="input-group-btn">
                                                    <button type="submit" class="btn btn-primary"><i class="icofont icofont-search-alt-2"></i></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade" id="publisher">
                                        <form action="#">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Enter publisher name">
                                                <div class="input-group-btn">
                                                    <button type="submit" class="btn btn-primary"><i class="icofont icofont-search-alt-2"></i></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="space-100"></div>
        <!-- Header-jumbotron-end -->
    </header>

    <section>
        <div class="space-80"></div>
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h2>About the <span class="text-primary">Treaty Database</span> </h2>
                    <div class="space-20"></div>
                    <div class="title-bar blue">
                        <ul class="list-inline list-unstyled">
                            <li><i class="icofont icofont-square"></i></li>
                            <li><i class="icofont icofont-square"></i></li>
                        </ul>
                    </div>
                    <div class="space-30"></div>
                    <p class="text-left text_lg">Lörem ipsum digital valuta tösaktigt jong. Semilogi makrotrejigt. Homolig sere föt det blinga. Ometese astrobel: kror. Telebilig. Hexalig blogga, i vosöheten fonde. Fatode sanäval. Rejerade kron sun pren ongar. Dertad odängen. Tetrang megadäling prefost labelt nirektig. Dejibelt diar om san inte as. Denar menscertifiera nerar och ter. Anare krodat, vårade lologi. Dogmafilm. Beveligt helikoptermamma nelig lol lögt.
                        Homonylingar gås utan paning. Sere nere i dir. Vitiv astros inte sal svischa. Ode hexassade. Geofaren jyling. Dira föheten. Makrokrogisk lidade utom nese. Fasam spetör tetratt tivis: rent. Vojilig heterogt de losk dede. Stenore didev fast koska terajongen.
                    </p>
                </div>
            </div>
            <div class="space-60"></div>
            <h3>Treaties <span class="text-primary">Catalogues</span> </h3>
            <div class="space-20"></div>
            <div class="row">
                <!--Show Book Categories-->
                <?php
                //Fetch all book categories
                $ret = "SELECT * FROM  iL_BookCategories";
                $stmt = $mysqli->prepare($ret);
                $stmt->execute(); //ok
                $res = $stmt->get_result();
                while ($row = $res->fetch_object()) {

                ?>
                    <div class="justify col-xs-12 col-sm-6 col-md-4 wow fadeInLeft" data-wow-delay="0.1s">
                        <div class="category-item well blue">
                            <div>
                                <p>Newly added treaties</p>
                                <h3><?php echo $row->bc_name; ?></h3>
                                <div class="text-center">

                                    <div class="space-10"></div>
                                    <div class="title-bar blue">
                                        <ul class="list-inline list-unstyled">
                                            <li><i class="icofont icofont-square"></i></li>
                                        </ul>
                                    </div>
                                    <div class="space-10"></div>
                                </div>
                            </div>
                            <a href="books.php">View files <img src="images/arrow_icon.png" alt="arrow icon" width="35px" /></a>
                        </div>
                    </div>
                <?php } ?>
                <!--End book categories -->
            </div>
            <div class="space-60"></div>
            <div class="row">
                <div class="col-xs-12 text-center">
                    <a href="books.php" class="btn btn-primary">See More</a>
                </div>
            </div>
            <div class="space-80"></div>
        </div>
    </section>
    <!--Footer-->
    <?php require_once('partials/footer.php'); ?>

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

</body>

</html>