<?php

/**
 * Created by PhpStorm.
 * User: dale
 * Date: 17/03/19
 * Time: 13:48
 */

include("../databaseConnector.php");

//connection object
$conn = connect();

$user_id = mysqli_real_escape_string($conn, $_POST['user_id']);

$sql_query = "DELETE FROM suspended WHERE userID = '$user_id';";

if($conn->query($sql_query) !== TRUE) {
    //error, terminate
    $arr = array('status' => 'error', 'message' => 'Could not create new bike type', 'stackTrace' => $conn->error);
    echo json_encode($arr);
    die();
}

$arr = array('status' => 'success');
echo json_encode($arr);

$conn->close();
