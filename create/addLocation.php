<?php

/**
 * Created by PhpStorm.
 * User: dalebaker-allan
 * Date: 2019-02-13
 * Time: 20:32
 */

include("../databaseConnector.php");

//connection object
$conn = connect();

//data
$location_name = mysqli_real_escape_string($conn, $_POST['location_name']);

$sql_query = "INSERT INTO location VALUES (null, '$location_name');";

if($conn->query($sql_query) !== TRUE) {
    //error, terminate
    $arr = array('status' => 'error', 'message' => 'Could not create new location', 'stackTrace' => $conn->error);
    echo json_encode($arr);
    die();
}

$arr = array('status' => 'success');
echo json_encode($arr);

$conn->close();
