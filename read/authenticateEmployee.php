<?php
/**
 * Created by PhpStorm.
 * User: dalebaker-allan
 * Date: 2019-02-12
 * Time: 23:18
 */

/**
 * We want to use the ID generated from @script login.php
 * to authenticate the user and fetch their data
 */

include('../databaseConnector.php');

// Get data from the HTTP POST request
// $_POST['...'], ... is defined in the sending of the post request
//we need to sanitize the input to prevent SQL injection
//mysqli_real_escape_string escapes special characters to prevent SQL injection
//$conn refers to the connection object from databaseConnector.php

$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = mysqli_real_escape_string($conn, $_POST['password']);
$login_failed = false;
/**
$username = $_POST['username'];
$password = $_POST['password'];
 **/
//create the query to execute
$sql_query = "SELECT user.userID FROM user WHERE username = '$username' AND password = '$password'";

//execute query and get results
$result = $conn->query($sql_query);

if($result->num_rows == 1) {
    //as we have (and expect) one result, get the userID of the account

    //get the first row
    $row = $result->fetch_assoc();

    //row['<name>'] are the same as the database columns
    $user_id = $row['userID'];

    //create a new query, returning all the employee info
    $sql_query = "SELECT user.userID, user.username, employees.employeeID, location.locationID, location.name AS 'location', employee_info.firstName,
       employee_info.lastName, employee_info.workEmail, employee_info.workTel, account_types.type
FROM user
INNER JOIN employees ON user.userID = employees.userID
INNER JOIN employee_info ON employees.employeeID = employee_info.employeeID
INNER JOIN account_types ON user.accountTypeID = account_types.accountTypeID
INNER JOIN location ON employees.location = location.locationID
WHERE user.userID = '$user_id';";

    //get result
    $result = $conn->query($sql_query);

    //create an array of rows, this is for the JSON encoder
    $json_array = array();
    while($row = $result->fetch_assoc()) {
        $json_array[] = $row;
    }

    //output as json encoded text
    echo json_encode($json_array);
} else if($result->num_rows > 1) {
    //we have duplicate values
    //create an array with 'error' tag that maps to the error,
    //this is so the json can encode as [{"error" : "..."}]
    $arr = array('error' => 'There is more than one account! Contact the database administrator');
    echo json_encode($arr);
    $login_failed = true;
} else if($result->num_rows == 0) {
    //no match
    //create an array with 'error' tag that maps to the error,
    //this is so the json can encode as [{"error" : "..."}]
    $arr = array('error' => 'Login details are incorrect!');
    echo json_encode($arr);
    $login_failed = true;
}

//ALWAYS CLOSE CONNECTION
$conn->close();

/**
 * Example command to test post request from Linux/Mac terminal
 * curl -v -H "Accept:application/json" -X POST -F "username=admin" -F "password=admin" http://www2.macs.hw.ac.uk/~db47/WheelyGoodBikes/DatabaseLayer/read/login.php
 */