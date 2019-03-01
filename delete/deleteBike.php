<?php
/**
 * Created by PhpStorm.
 * User: dale
 * Date: 01/03/19
 * Time: 12:32
 */

include("../databaseConnector.php");

//connector object
$conn = connect();

//data
$bike_id = mysqli_real_escape_string($conn, $_POST['bike_id']);

$sql_query = "DELETE FROM bike_stock WHERE bikeID = '$bike_id';";

if($conn->query($sql_query) !== TRUE) {
    //error, terminate
    $arr = array('status' => 'error', 'message' => 'Could not create new location', 'stackTrace' => $conn->error);
    echo json_encode($arr);
    die();
}

$arr = array('status' => 'success');
echo json_encode($arr);

$conn->close();