<?php
/**
 * Created by PhpStorm.
 * User: dalebaker-allan
 * Date: 2019-03-10
 * Time: 17:07
 */

include("../databaseConnector.php");

//connection object
$conn = connect();

//Get the data
$user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

$sql_query = "UPDATE user SET password='$password' WHERE user.userID='$user_id';";
if($conn->query($sql_query) !== TRUE) {
    //create an array with 'error' tag that maps to the error,
    //this is so the json can encode as [{"error" : "..."}]
    $arr = array('status' => 'error', 'message' => 'Could not update user!', 'stackTrace' => $conn->error);
    echo json_encode($arr);
    die();
}

$arr = array('status' => 'success');
echo json_encode($arr);

$conn->close();