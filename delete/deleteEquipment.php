<?php
/**
 * Created by PhpStorm.
 * User: dalebaker-allan
 * Date: 2019-02-13
 * Time: 20:43
 */

include("../databaseConnector.php");

//connector object
$conn = connect();

//data
$equipment_id = mysqli_real_escape_string($conn, $_POST['equipment_id']);

$sql_query = "DELETE FROM equipment_stock WHERE equipmentID = '$equipment_id';";

if($conn->query($sql_query) !== TRUE) {
    //error, terminate
    $arr = array('status' => 'error', 'message' => 'Could not create new location', 'stackTrace' => $conn->error);
    echo json_encode($arr);
    die();
}

$arr = array('status' => 'success');
echo json_encode($arr);

$conn->close();