<?php
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
$employee_id = mysqli_real_escape_string($conn, $_POST['employee_id']);

//sql queries
$sql_query = "DELETE FROM employee_info WHERE employeeID = '$employee_id'";
if($conn->query($sql_query) !== TRUE) {
    //error, terminate
    $arr = array('error' => 'Could not delete Employee information.', 'stackTrace' => $conn->error);
    echo json_encode($arr);
    die();
}

$sql_query = "DELETE FROM employees WHERE employeeID = '$employee_id' AND userID = '$user_id'"; // .= operator concatenates to the string
if($conn->query($sql_query) !== TRUE) {
    //error, terminate
    $arr = array('error' => 'Could not delete Employee.', 'stackTrace' => $conn->error);
    echo json_encode($arr);
    die();
}

$sql_query = "DELETE FROM user WHERE userID = '$user_id'";
if($conn->query($sql_query) !== TRUE) {
    //error, terminate
    $arr = array('error' => 'Could not delete user account.', 'stackTrace' => $conn->error);
    echo json_encode($arr);
    die();
}

$arr = array('success' => 'User deleted');
echo json_encode($arr);

$conn->close();

