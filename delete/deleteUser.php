<?php

include("databaseConnector.php");
//connection object
$conn = connect();
//data
$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = mysqli_real_escape_string($conn, $_POST['password']);




$sql_query = "SELECT userID FROM user WHERE username='$username' AND password='$password';";

$results = $conn->query($sql_query);
if($results->num_rows > 1 || $results->num_rows == 0) {
    //failed
    $arr = array('status' => 'error', 'message' => 'Could not get new userID!', 'stackTrace' => $conn->error);
    echo json_encode($arr);
    die();
}
//get the first row
$row = $results->fetch_assoc();
//row['<name>'] are the same as the database columns
$user_id = $row['userID'];
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
