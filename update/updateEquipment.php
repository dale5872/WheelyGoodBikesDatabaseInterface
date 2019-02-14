<?php
/**
 * Created by PhpStorm.
 * User: dalebaker-allan
 * Date: 2019-02-13
 * Time: 20:44
 */

include("../databaseConnector.php");

//connection object
$conn = connect();

//data
$equipment_type = mysqli_real_escape_string($conn, $_POST['location_name']);
$location_id = mysqli_real_escape_string($conn, $_POST['location_id']);
$status = mysqli_real_escape_string($conn, $_POST['status']);

$sql_query = "UPDATE equipment_stock SET equipment_stock.equipmentType = '$equipment_type', "
. "equipment_stock.location='$location_id', " .
    " equipment_stock.equipmentStatus = '$staus' " .
    "WHERE equipment_stock.equipmentID = \" + e.getID() + \";";

if($conn->query($sql_query) !== TRUE) {
    //error, terminate
    $arr = array('error' => 'Could not update equipment', 'stackTrace' => $conn->error);
    echo json_encode($arr);
    die();
}

$arr = array('success' => 'Equipment updated');
echo json_encode($arr);

$conn->close();