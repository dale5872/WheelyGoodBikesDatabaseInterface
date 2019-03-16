<?php
/**
 * Created by PhpStorm.
 * User: dale
 * Date: 15/03/19
 * Time: 14:36
 */

include("../databaseConnector.php");

//connection object
$conn = connect();

//data
$bike_type = mysqli_real_escape_string($conn, $_POST['bike_type']);
$image = mysqli_real_escape_string($conn, $_POST['image']);
$pricePerHour = mysqli_real_escape_string($conn, $_POST['pricePerHour']);
$bike_type_id = mysqli_real_escape_string($conn, $_POST['bike_type_id']);

$sql_query = "UPDATE bike_type SET bikeType = '$bike_type', pricePerHour = '$pricePerHour', image = '$image'
WHERE bikeTypeID = '$bike_type_id';";

if($conn->query($sql_query) !== TRUE) {
    //error, terminate
    $arr = array('status' => 'error', 'message' => 'Could not update bike type', 'stackTrace' => $conn->error);
    echo json_encode($arr);
    die();
}

$arr = array('status' => 'success');
echo json_encode($arr);

$conn->close();