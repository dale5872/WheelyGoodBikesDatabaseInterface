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
$equipment_type = mysqli_real_escape_string($conn, $_POST['equipment_type']);
$location_id = mysqli_real_escape_string($conn, $_POST['location_id']);
$status = mysqli_real_escape_string($conn, $_POST['status']);
$equipment_id = mysqli_real_escape_string($conn, $_POST['equipment_id']);

$sql_query = "UPDATE equipment_stock SET equipment_stock.equipmentType = '$equipment_type', 
    equipment_stock.location='$location_id', 
     equipment_stock.equipmentStatus = '$status' 
    WHERE equipment_stock.equipmentID = '$equipment_id';";


if($conn->query($sql_query) !== TRUE) {
    //error, terminate
    $arr = array('status' => 'error', 'message' => 'Could not update equipment', 'stackTrace' => $conn->error);
    echo json_encode($arr);
    die();
}

$arr = array('status' => 'success');
echo json_encode($arr);

$conn->close();