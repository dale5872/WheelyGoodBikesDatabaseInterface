<?php
/**
 * Created by PhpStorm.
 * User: dalebaker-allan
 * Date: 2019-02-13
 * Time: 20:38
 */

include("../databaseConnector.php");

//connection object
$conn = connect();

//data
$location_name = mysqli_real_escape_string($conn, $_POST['location_name']);
$location_id = mysqli_real_escape_string($conn, $_POST['location_id']);

$sql_query = "UPDATE location SET location.name = '$location_name' WHERE location.locationID = '$location_id';";

if($conn->query($sql_query) !== TRUE) {
    //error, terminate
    $arr = array('status' => 'error', 'message' => 'Could not update location', 'stackTrace' => $conn->error);
    echo json_encode($arr);
    die();
}

$arr = array('status' => 'success');
echo json_encode($arr);

$conn->close();