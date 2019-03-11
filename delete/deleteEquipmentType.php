<?php
/**
 * Created by PhpStorm.
 * User: dalebaker-allan
 * Date: 2019-03-11
 * Time: 18:48
 */

include("../databaseConnector.php");

//connection object
$conn = connect();

//data
$equipment_type = mysqli_real_escape_string($conn, $_POST['bike_type']);

$sql_query = "DELETE FROM equipment_type WHERE equipmentTypeID = '$equipment_type'";

if($conn->query($sql_query) !== TRUE) {
    //error, terminate
    $arr = array('status' => 'error', 'message' => 'Could not delete this equipment type', 'stackTrace' => $conn->error);
    echo json_encode($arr);
    die();
}

$arr = array('status' => 'success');
echo json_encode($arr);

$conn->close();