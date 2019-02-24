<?php
/**
 * Created by PhpStorm.
 * User: dalebaker-allan
 * Date: 2019-02-13
 * Time: 20:41
 */

include("../databaseConnector.php");

//connection object
$conn = connect();

//data
$equipment_type = mysqli_real_escape_string($conn, $_POST['equipment_type']);
$location_id = mysqli_real_escape_string($conn, $_POST['location_id']);
$status = mysqli_real_escape_string($conn, $_POST['status']);

$sql_query = "INSERT INTO equipment_stock VALUES (null, '$equipment_type', '$location_id', '$status');";

if($conn->query($sql_query) !== TRUE) {
    //error, terminate
    $arr = array('status' => 'error', 'message' => 'Could not create new equipment', 'stackTrace' => $conn->error);
    echo json_encode($arr);
    die();
}

$arr = array('status' => 'success');
echo json_encode($arr);

$conn->close();