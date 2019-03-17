<?php
header("Access-Control-Allow-Origin: *");

include("databaseConnector.php");
//connection object
$conn = connect();
//data
$user_id = mysqli_real_escape_string($conn, $_POST['user_id']);





$sql_query = "DELETE FROM user_info WHERE userID = '$user_id'";

if($conn->query($sql_query) !== TRUE) {
    //error, terminate
    $arr = array('status' => 'error', 'message' => 'Could not delete info from the database!', 'stackTrace' => $conn->error);
    echo json_encode($arr);
    die();
}


$sql_query = "DELETE FROM customer_address WHERE userID = '$user_id'";

if($conn->query($sql_query) !== TRUE) {
    //error, terminate
    $arr = array('status' => 'error', 'message' => 'Could not delete info from the database!', 'stackTrace' => $conn->error);
    echo json_encode($arr);
    die();
}

$sql_query = "DELETE FROM user WHERE userID = '$user_id'";

if($conn->query($sql_query) !== TRUE) {
    //error, terminate
    $arr = array('status' => 'error', 'message' => 'Could not delete info from the database!', 'stackTrace' => $conn->error);
    echo json_encode($arr);
    die();
}

//we have succeeded
$arr = array('status' => 'success');
echo json_encode($arr);
//ALWAYS CLOSE CONNECTION
$conn->close();
