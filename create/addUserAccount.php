<?php
header("Access-Control-Allow-Origin: *");
/**
 * Created by PhpStorm.
 * User: dalebaker-allan
 * Date: 2019-02-23
 * Time: 22:20
 */

include("../databaseConnector.php");

$conn = connect();

//Get the data
$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = mysqli_real_escape_string($conn, $_POST['password']);
$first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
$last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$phone = mysqli_real_escape_string($conn, $_POST['phone']);


//first we create a query to add the user account and retrieve the user id
//create the query to execute
//execute query and get results
$sql_query = "INSERT INTO user VALUES (null, 1, '$username', '$password');";

if($conn->query($sql_query) !== TRUE) {
    //error, terminate
    //create an array with 'error' tag that maps to the error,
    //this is so the json can encode as [{"error" : "..."}]
    $arr = array('status' => 'error', 'message' => 'Could not insert user into the database!', 'stackTrace' => $conn->error);
    echo json_encode($arr);
    die();
}

//inserted, continue
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

$sql_query = "INSERT INTO user_info VALUES ('$user_id', '$first_name', '$last_name', '$email', '$phone');";

if($conn->query($sql_query) !== TRUE) {
    //error, terminate
    $arr = array('status' => 'error', 'message' => 'Could not insert employee info into the database!', 'stackTrace' => $conn->error);
    echo json_encode($arr);
    die();
}

//we have succeeded
$arr = array('status' => 'success');
echo json_encode($arr);

//ALWAYS CLOSE CONNECTION
$conn->close();
