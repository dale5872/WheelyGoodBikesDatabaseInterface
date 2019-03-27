<?php
include('../databaseConnector.php');

//get connection object
$conn = connect();

$return_time = mysqli_real_escape_string($conn, $_POST['return_time']);
$start_time = mysqli_real_escape_string($conn, $_POST['start_time']);
$location = mysqli_real_escape_string($conn, $_POST['location']);
$user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
$bike_id = mysqli_real_escape_string($conn, $_POST['bike_id']);
$status = mysqli_real_escape_string($conn, $_POST['status']);
$price = mysqli_real_escape_string($conn, $_POST['price']);

$sql_query = "INSERT INTO bike_rentals VALUES (null, '$user_id', '$bike_id', '$location', '$price', '$start_time', '$return_time', '$status');";

if($conn->query($sql_query) !== TRUE) {
	//error, terminate
	$arr = array('status' => 'error',
	'message' => 'Could not create new bike type',
	'stackTrace' => $conn->error);
	echo json_encode($arr);
	die();
}

$arr = array('status' => 'success');
echo json_encode($arr);

$conn->close();