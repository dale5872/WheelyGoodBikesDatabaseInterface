<?php
/**
 * Created by PhpStorm.
 * User: dale
 * Date: 01/03/19
 * Time: 12:28
 */

include("../databaseConnector.php");

//connection object
$conn = connect();

//data
$bike_type = mysqli_real_escape_string($conn, $_POST['bike_type']);
$location_id = mysqli_real_escape_string($conn, $_POST['location_id']);
$status = mysqli_real_escape_string($conn, $_POST['status']);

$sql_query = "INSERT INTO bike_stock VALUES (null, '$bike_type', '$location_id', '$status');";

if($conn->query($sql_query) !== TRUE) {
    //error, terminate
    $arr = array('status' => 'error', 'message' => 'Could not create new bike', 'stackTrace' => $conn->error);
    echo json_encode($arr);
    die();
}

$arr = array('status' => 'success');
echo json_encode($arr);

$conn->close();