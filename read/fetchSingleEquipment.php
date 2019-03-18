<?php

header("Access-Control-Allow-Origin: *");
/**
 * Created by PhpStorm.
 * User: dalebaker-allan
 * Date: 2019-03-11
 * Time: 10:43
 */

include('../databaseConnector.php');

//get connection object
$conn = connect();

$equipment_id = mysqli_real_escape_string($conn, $_POST['equipment_id']);

//create the query to execute

$sql_query = "SELECT equipment_stock.equipmentID, equipment_stock.equipmentType, equipment_type.equipmentType AS 'equipmentName',
       equipment_stock.location, location.name,
       equipment_stock.equipmentStatus, equipment_type.pricePerHour
FROM equipment_stock
INNER JOIN location ON equipment_stock.location = location.locationID
INNER JOIN equipment_type ON equipment_stock.equipmentType = equipment_type.equipmentTypeID
WHERE equipmentID = '$equipment_id';";

//execute query and get results
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

//ALWAYS CLOSE CONNECTION
$conn->close();
