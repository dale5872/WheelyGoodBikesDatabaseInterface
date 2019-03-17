<?php
/**
 * Created by PhpStorm.
 * User: dale
 * Date: 16/03/19
 * Time: 11:12
 */

include('../databaseConnector.php');

//get connection object
$conn = connect();

$equipment_id = mysqli_real_escape_string($conn, $_POST['equipment_id']);
$location = mysqli_real_escape_string($conn, $_POST['location']);
$user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
$price = mysqli_real_escape_string($conn, $_POST['price']);
$status = mysqli_real_escape_string($conn, $_POST['status']);
$start_time = mysqli_real_escape_string($conn, $_POST['start_time']);
$return_time = mysqli_real_escape_string($conn, $_POST['return_time']);

$sql_query = "INSERT INTO equipment_rentals VALUES (null, '$user_id', '$equipment_id', '$location', '$price', '$start_time', '$return_time', '$status');";

if($conn->query($sql_query) !== TRUE) {
    //error, terminate
    $arr = array('status' => 'error', 'message' => 'Could not create new equipment type', 'stackTrace' => $conn->error);
    echo json_encode($arr);
    die();
}

$arr = array('status' => 'success');
echo json_encode($arr);

$conn->close();