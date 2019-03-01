<?php
/**
 * Created by PhpStorm.
 * User: dale
 * Date: 01/03/19
 * Time: 12:29
 */

include("../databaseConnector.php");

//connection object
$conn = connect();

//data
$bike_type = mysqli_real_escape_string($conn, $_POST['bike_type']);
$location_id = mysqli_real_escape_string($conn, $_POST['location_id']);
$status = mysqli_real_escape_string($conn, $_POST['status']);
$bike_id = mysqli_real_escape_string($conn, $_POST['bike_id']);

$sql_query = "UPDATE bike_stock SET bike_stock.bikeType = '$bike_type', 
    bike_stock.location='$location_id', 
     bike_stock.bikeStatus = '$status' 
    WHERE bike_stock.bikeID = '$bike_id';";


if($conn->query($sql_query) !== TRUE) {
    //error, terminate
    $arr = array('status' => 'error', 'message' => 'Could not update bike', 'stackTrace' => $conn->error);
    echo json_encode($arr);
    die();
}

$arr = array('status' => 'success');
echo json_encode($arr);

$conn->close();