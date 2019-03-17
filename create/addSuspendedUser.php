<?php
header("Access-Control-Allow-Origin: *");
/**
 * Created by PhpStorm.
 * User: dale
 * Date: 17/03/19
 * Time: 13:44
 */

include("../databaseConnector.php");

//connection object
$conn = connect();

$user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
$reason = mysqli_real_escape_string($conn, $_POST['reason']);

$sql_query = "INSERT INTO suspended VALUES ('$user_id', '$reason');";

if($conn->query($sql_query) !== TRUE) {
    //error, terminate
    $arr = array('status' => 'error', 'message' => 'Could not create new bike type', 'stackTrace' => $conn->error);
    echo json_encode($arr);
    die();
}

$arr = array('status' => 'success');
echo json_encode($arr);

$conn->close();
