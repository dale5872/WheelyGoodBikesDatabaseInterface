<?php
/**
 * Created by PhpStorm.
 * User: dalebaker-allan
 * Date: 2019-03-11
 * Time: 18:47
 */


include("../databaseConnector.php");

//connection object
$conn = connect();

//data
$bike_type = mysqli_real_escape_string($conn, $_POST['bike_type']);

$sql_query = "DELETE FROM bike_type WHERE bikeTypeID = '$bike_type'";

if($conn->query($sql_query) !== TRUE) {
    //error, terminate
    $arr = array('status' => 'error', 'message' => 'Could not delete this bike type', 'stackTrace' => $conn->error);
    echo json_encode($arr);
    die();
}

$arr = array('status' => 'success');
echo json_encode($arr);

$conn->close();