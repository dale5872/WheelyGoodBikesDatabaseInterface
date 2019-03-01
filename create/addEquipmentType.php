<?php
/**
 * Created by PhpStorm.
 * User: dale
 * Date: 01/03/19
 * Time: 12:08
 */

include("../databaseConnector.php");

//connection object
$conn = connect();

//data
$equipment_type = mysqli_real_escape_string($conn, $_POST['equipment_type']);
$image = mysqli_real_escape_string($conn, $_POST['image']);
$pricePerHour = mysqli_real_escape_string($conn, $_POST['pricePerHour']);

$sql_query = "INSERT INTO equipment_type VALUES (null, '$equipment_type', '$image', '$pricePerHour');";

if($conn->query($sql_query) !== TRUE) {
    //error, terminate
    $arr = array('status' => 'error', 'message' => 'Could not create new equipment type', 'stackTrace' => $conn->error);
    echo json_encode($arr);
    die();
}

$arr = array('status' => 'success');
echo json_encode($arr);

$conn->close();