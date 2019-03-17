<?php

header("Access-Control-Allow-Origin: *");
/**
 * Created by PhpStorm.
 * User: dalebaker-allan
 * Date: 2019-02-12
 * Time: 21:44
 */


include('../databaseConnector.php');

$conn = connect();

// Get data from the HTTP POST request
// $_POST['...'], ... is defined in the sending of the post request
//we need to sanitize the input to prevent SQL injection
//mysqli_real_escape_string escapes special characters to prevent SQL injection
//$conn refers to the connection object from databaseConnector.php

$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

//create the query to execute
$sql_query = "SELECT user.userID FROM user WHERE username = '$username' AND password = '$password' AND user.accountTypeID = 1";

//execute query and get results
$result = $conn->query($sql_query);

if($result->num_rows == 1) {
    //we have a match, create an array to store all the rows
    $rows = array();

    //loop through all the rows in the result set
    while($row = $result->fetch_assoc()) {
        //add current row into array
        $rows[] = $row;
    }

    //output as json encoded text
    echo json_encode($rows);
} else if($result->num_rows > 1) {
    //we have duplicate values
    //create an array with 'error' tag that maps to the error,
    //this is so the json can encode as [{"error" : "..."}]
    $arr = array('status' => 'error', 'message' => 'There is more than one account! Contact the database administrator', 'stackTrace' => $conn->error);
    echo json_encode($arr);
    $login_failed = true;
} else if($result->num_rows == 0) {
    //no match
    //create an array with 'error' tag that maps to the error,
    //this is so the json can encode as [{"error" : "..."}]
    $arr = array('status' => 'error', 'message' => 'Login Details are incorrect', 'stackTrace' => $conn->error);
    echo json_encode($arr);
    $login_failed = true;
}

//ALWAYS CLOSE CONNECTION
$conn->close();

/**
 * Example command to test post request from Linux/Mac terminal
 * curl -v -H "Accept:application/json" -X POST -F "username=admin" -F "password=admin" http://www2.macs.hw.ac.uk/~db47/WheelyGoodBikes/DatabaseLayer/read/login.php
 */
