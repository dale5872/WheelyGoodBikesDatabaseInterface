<?php
/**
 * Created by PhpStorm.
 * User: dalebaker-allan
 * Date: 2019-03-16
 * Time: 15:36
 */

include("../databaseConnector.php");

//connection object
$conn = connect();

//data
$equipment_type = mysqli_real_escape_string($conn, $_POST['equipment_type']);
$image = mysqli_real_escape_string($conn, $_POST['image']);
$pricePerHour = mysqli_real_escape_string($conn, $_POST['pricePerHour']);
$equipment_type_id = mysqli_real_escape_string($conn, $_POST['equipment_type_id']);

$sql_query = "UPDATE equipment_type SET equipmentType = '$equipment_type', pricePerHour = '$pricePerHour', image = '$image'
WHERE equipmentTypeID = '$equipment_type_id';";

if($conn->query($sql_query) !== TRUE) {
    //error, terminate
    $arr = array('status' => 'error', 'message' => 'Could not update equipment type', 'stackTrace' => $conn->error);
    echo json_encode($arr);
    die();
}

$arr = array('status' => 'success');
echo json_encode($arr);

$conn->close();