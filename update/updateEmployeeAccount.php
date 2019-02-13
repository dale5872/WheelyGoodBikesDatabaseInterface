<?php
/**
 * Created by PhpStorm.
 * User: dalebaker-allan
 * Date: 2019-02-13
 * Time: 20:06
 */

include("../databaseConnector.php");

//connection object
$conn = connect();

//Get the data
$username = mysqli_real_escape_string($conn, $_POST['username']);
/**
 * TODO create a script that randomly changes a user's password
 * BODY When script runs, all user data EXCEPT password is updated, new feature needed for resetting a password
 */
$password = mysqli_real_escape_string($conn, $_POST['password']);
$account_type = mysqli_real_escape_string($conn, $_POST['account_type']);
$location_id = mysqli_real_escape_string($conn, $_POST['location_id']);
$first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
$last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$phone = mysqli_real_escape_string($conn, $_POST['phone']);
$employee_id = mysqli_real_escape_string($conn, $_POST['employee_id']);
$user_id = mysqli_real_escape_string($conn, $_POST['user_id']);

$sql_query = "UPDATE user SET accountTypeID='$account_type', username='$username' WHERE user.userID='$user_id';";
if($conn->query($sql_query) !== TRUE) {
    //create an array with 'error' tag that maps to the error,
    //this is so the json can encode as [{"error" : "..."}]
    $arr = array('error' => 'Could not update user!', 'stackTrace' => $conn->error);
    echo json_encode($arr);
    die();
}

//continue
$sql_query = "UPDATE employees SET location='$location_id' WHERE userID='$user_id';";
if($conn->query($sql_query) !== TRUE) {
    //create an array with 'error' tag that maps to the error,
    //this is so the json can encode as [{"error" : "..."}]
    $arr = array('error' => 'Could not update user!', 'stackTrace' => $conn->error);
    echo json_encode($arr);
    die();
}

//continue
$sql_query = "UPDATE employee_info SET firstName='$first_name', lastName='$last_name', workEmail='$email', workTel='$phone' WHERE employeeID='$employee_id';";
if($conn->query($sql_query) !== TRUE) {
    //create an array with 'error' tag that maps to the error,
    //this is so the json can encode as [{"error" : "..."}]
    $arr = array('error' => 'Could not update user!', 'stackTrace' => $conn->error);
    echo json_encode($arr);
    die();
}

$arr = array('success' => 'User updated');
echo json_encode($arr);

$conn->close();