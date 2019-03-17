<?php

header("Access-Control-Allow-Origin: *");
include("databaseConnector.php");
//connection object
$conn = connect();


$bike_rental_id = mysqli_real_escape_string($conn, $_POST['bike_rental_id']);
$update_col = mysqli_real_escape_string($conn, $_POST['update_col']);
$update_info = mysqli_real_escape_string($conn, $_POST['update_info']);




$sql_query = "UPDATE bike_rentals SET $update_col = '$update_info' WHERE bikeRentalId = '$bike_rental_id'";


if($conn->query($sql_query) !== TRUE) {
    //error, terminate
    $arr = array('status' => 'error', 'message' => 'Could not update info in the database!', 'stackTrace' => $conn->error);
    echo json_encode($arr);
    die();
}



//we have succeeded
$arr = array('status' => 'success');
echo json_encode($arr);
//ALWAYS CLOSE CONNECTION
$conn->close();
