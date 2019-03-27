<?php
/**
 * Created by PhpStorm.
 * User: dale
 * Date: 16/03/19
 * Time: 11:12
 */
include('databaseConnector.php');
//get connection object
$conn = connect();
$bike_id = mysqli_real_escape_string($conn, $_POST['bike_id']);
$location = mysqli_real_escape_string($conn, $_POST['location']);
$user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
$price = mysqli_real_escape_string($conn, $_POST['price']);
$status = mysqli_real_escape_string($conn, $_POST['status']);
$start_time = mysqli_real_escape_string($conn, $_POST['start_time']);
$return_time = mysqli_real_escape_string($conn, $_POST['return_time']);
$sql_query = "INSERT INTO bike_rentals VALUES (null, '$user_id', '$bike_id', '$location', '$price', '$start_time', '$return_time', '$status');";
if($conn->query($sql_query) !== TRUE) {
    //error, terminate
    $arr = array('status' => 'error', 'message' => 'Could not create new bike type', 'stackTrace' => $conn->error);
    echo json_encode($arr);
    die();
}
$arr = array('status' => 'success');
echo json_encode($arr);

$sql_query = "SELECT bikeID FROM bike_rentals WHERE userID = '$user_id' AND startTime = '$start_time';";

//------
$result = $conn->query($sql_query);
if($result->num_rows > 0) {
    //we have a match, create an array to store all the rows
    $rows = array();
    //loop through all the rows in the result set
    while($row = $result->fetch_assoc()) {
        //add current row into array
        $rows[] = $row;
    }
    //output as json encoded text
    $arr = array('status' => 'success', 'data' => $rows);
    echo json_encode($arr);
} else if($result->num_rows == 0) {
    //no match
    //create an array with 'error' tag that maps to the error,
    //this is so the json can encode as [{"error" : "..."}]
    $arr = array('status' => 'error', 'message' => 'empty', 'stackTrace' => $conn->error);
    echo json_encode($arr);
}
//------

$conn->close();
