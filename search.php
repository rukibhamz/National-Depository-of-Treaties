<?php
$hostname = "localhost"; // database host name
$username = "root"; // database username
$password = ""; // database password
$database = "treaties_db"; // database name

// Create connection
$mysqli = mysqli_connect($hostname, $username, $password, $database);

// Check connection
if (!$mysqli) {
    die("Connection failed: " . mysqli_connect_error());
}


if (isset($_POST['treaty'])) {
    $treaty = $_POST['treaty'];
    $ret = "SELECT * FROM tbl_treaties WHERE CONCAT(title, tc_name, s_status) LIKE ? ORDER BY treaty_year DESC";
    $stmt = $mysqli->prepare($ret);
    $treaty_query = "%$treaty%";
    $stmt->bind_param('s', $treaty_query);
    $stmt->execute();
    $res = $stmt->get_result();
} else {
    $ret = "SELECT * FROM tbl_treaties ORDER BY treaty_year DESC";
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
                        <h6>Year: <?= $row->treaty_year; ?></h6>
                        <h6>Status: <i><?= $row->s_status; ?></i></h6>
                        <div class="space-10"></div>
                        <div class="title-bar blue text-center">
                            <ul class="list-inline list-unstyled">
                                <li><i class="icofont icofont-square"></i></li>
                            </ul>
                        </div>
                        <div class="space-10"></div>
                        <div class="row">
                            <div class="col-md-4"> <a href="treaty.php?doc_id=<?= $row->id; ?>" class="text-primary">View&nbsp;<i class="icofont icofont-curved-double-right"></i></a></div>

                            <div class="col-md-8">
                                <img src="images/card-logo.png" alt='<?= $row->title; ?>' class="img-responsive" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php
    }
} else {
    echo '<p>No results found.</p>';
}
?>
