<?php
/**
 * Created by PhpStorm.
 * User: dale
 * Date: 01/03/19
 * Time: 12:20
 */

include("../databaseConnector.php");

//connection object
$conn = connect();

//data
$bike_type = mysqli_real_escape_string($conn, $_POST['bike_type']);
$image = mysqli_real_escape_string($conn, $_POST['image']);
$pricePerHour = mysqli_real_escape_string($conn, $_POST['pricePerHour']);

$sql_query = "INSERT INTO bike_type VALUES (null, '$bike_type', '$pricePerHour', '$image');";

if($conn->query($sql_query) !== TRUE) {
    //error, terminate
    $arr = array('status' => 'error', 'message' => 'Could not create new bike type', 'stackTrace' => $conn->error);
    echo json_encode($arr);
    die();
}

$arr = array('status' => 'success');
echo json_encode($arr);

$conn->close();