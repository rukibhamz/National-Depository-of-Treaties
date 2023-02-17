<?php
include('assets/config/pdoconfig.php');
// -----------
if (!empty($_POST["sudoTreatyCategoryName"])) {
    //get category id
    $id = $_POST['sudoTreatyCategoryName'];
    $stmt = $DB_con->prepare("SELECT * FROM tbl_treatiescategory WHERE name = :id");
    $stmt->execute(array(':id' => $id));
?>
<?php
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
?>
<?php echo htmlentities($row['id']); ?>
<?php
    }
}

// -----------
if (!empty($_POST["sudoTreatyStatusName"])) {
    //get status id
    $id = $_POST['sudoTreatyStatusName'];
    $stmt = $DB_con->prepare("SELECT * FROM tbl_status WHERE name = :id");
    $stmt->execute(array(':id' => $id));
?>
<?php
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
?>
<?php echo htmlentities($row['id']); ?>
<?php
    }
}

