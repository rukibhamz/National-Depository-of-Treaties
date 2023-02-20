<?php
require_once('sudo/assets/config/config.php');
$docs_id = $_GET['doc_id'];
$ret = "SELECT * FROM  tbl_treaties WHERE id = ?";
$stmt = $mysqli->prepare($ret);
$stmt->bind_param('s', $docs_id);
$stmt->execute(); //ok
$res = $stmt->get_result();
while ($row = $res->fetch_object()) {
    //load default book cover page if book is missing a cover image
    if ($row->b_file == '') {
        $cover_image = "<img src='sudo/assets/magazines/default.png' class='img-responsive img-thumbnail' alt='Book Image'>";
    } else {
        $cover_image = "<img src='sudo/assets/img/books/$row->b_file' class='img-responsive img-thumbnail' alt='Book Image'>";
    }
?>
    <!doctype html>
    <html class="no-js" lang="zxx">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Treaty - National Depository Of Treaties</title>
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

    <style>
        div.pdfobject-container {
            height: 50rem;
            border: 1rem solid rgba(0, 0, 0, .1);
        }
    </style>

    <body data-spy="scroll" data-target="#mainmenu" data-offset="50">

        <header class="relative" id="sc1">
            <!-- Header-background-markup -->
            <div class="overlay-bg relative">
                <img src="images/slide/02.png" alt="Treaty_DataBase">
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
                            <a href="index.php" class="navbar-left show"><img src="images/logo-2.png" alt="Treaty_DataBase" width="70%" class="img-responsive"></a>
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
                                <h1 class="text-white">View Treaty</h1>
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
        <section>
            <div class="space-30"></div>
            <div class="container">
                <div class="row">
                    <div class="col-6 pull-right">
                        <a href="treaties.php" class="btn btn-primary" style="padding: 0.8rem"><i class="icofont icofont-arrow-left"></i>Back</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-md-12">
                        <div class="space-30"></div>
                        <div class="row">
                            <div class="col-xs-12 col-md-12">
                                <div class="category-item well green">
                                    <div class="media">
                                        <div class="md-card">
                                            <?php
                                            $file_ext = pathinfo($row->b_file, PATHINFO_EXTENSION);
                                            $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif');

                                            if (in_array($file_ext, $allowed_extensions)) {
                                                echo "<div style='margin-bottom: 2rem; max-height: 25%; max-width: 25%; padding-bottom: 1rem;'>
                                            <img src='sudo/assets/magazines/{$row->b_file}' alt='{$row->b_file}' width='img-responsive' />
                                            <a download class='btn btn-primary' href='sudo/assets/magazines/{$row->b_file}' class='download-imag'>
                                            <i class='icofont icofont-download-alt'></i>&nbsp;Download</a>
                                        </div>";
                                            }
                                            ?>
                                        </div>
                                        <div class="md-card">
                                            <!-- Preview for desktop view -->
                                            <div data-value="<?= $row->b_file ?>" id="<?= 'preview-', $_GET['doc_id'] ?>">
                                            </div>
                                            <!-- Mobile View -->
                                            <div id="pdf-container"></div>
                                        </div>
                                        <div class="media-body">
                                            <h5><?= $row->title; ?></h5>
                                            <div class="space-10"></div>
                                            <p><?= $row->b_summary; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Book-->
                        </div>
                        <div class="space-60"></div>
                    </div>
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.2.8/pdfobject.min.js" integrity="sha512-MoP2OErV7Mtk4VL893VYBFq8yJHWQtqJxTyIAsCVKzILrvHyKQpAwJf9noILczN6psvXUxTr19T5h+ndywCoVw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script>
            const docsContainer = document.getElementById('<?= 'preview-', $_GET['doc_id'] ?>')
            const fileName = docsContainer.getAttribute('data-value');
            const fileExt = fileName.split(".").pop();
            if (screen.width < 768 && fileExt === 'pdf') {
                var pdfUrl = `sudo/assets/magazines/${fileName}`;
                // var pdfHtml = '<object data="' + pdfUrl + '" type="application/pdf" width="100%" height="100%"></object>';
                let pdfHtml = `<a href="${pdfUrl}" download="${fileName}" class="btn btn-primary"><i class="icofont icofont-download-alt"></i>&ensp;Download PDF</a>`;
                document.getElementById("pdf-container").innerHTML = pdfHtml;
            } else if (fileExt === 'pdf' && screen.width >= 768) {
                PDFObject.embed(`sudo/assets/magazines/${fileName}`, "#<?= 'preview-', $_GET['doc_id'] ?>");
            }
        </script>

    </body>

    </html>
<?php } ?>