<?php

header("Access-Control-Allow-Origin: *");

/**
 * Created by PhpStorm.
 * User: dalebaker-allan
 * Date: 2019-02-13
 * Time: 11:07
 */

include("../databaseConnector.php");

//get connection object
$conn = connect();

//data fields
$user_id = mysqli_real_escape_string($conn, $_POST['user_id']);

//sql queries
$sql_query = "DELETE FROM user_info WHERE userID = '$user_id'";
if($conn->query($sql_query) !== TRUE) {
    //error, terminate
    $arr = array('status' => 'error', 'message' => 'Could not delete User information.', 'stackTrace' => $conn->error);
    echo json_encode($arr);
    die();
}

$sql_query = "DELETE FROM user WHERE userID = '$user_id'";
if($conn->query($sql_query) !== TRUE) {
    //error, terminate
    $arr = array('status' => 'error', 'message' => 'Could not delete user account.', 'stackTrace' => $conn->error);
    echo json_encode($arr);
    die();
}

$arr = array('status' => 'success');
echo json_encode($arr);

$conn->close();
