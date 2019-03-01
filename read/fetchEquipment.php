<?php
/**
 * Created by PhpStorm.
 * User: dalebaker-allan
 * Date: 2019-02-12
 * Time: 23:48
 */

include('../databaseConnector.php');

//get connection object
$conn = connect();

$location_id = mysqli_real_escape_string($conn, $_POST['location_id']);
$search = mysqli_real_escape_string($conn, $_POST['search']);

//create the query to execute

if($location_id === "" && $search === "") {
    $sql_query = "SELECT equipment_stock.equipmentID, equipment_stock.equipmentType, equipment_type.equipmentType AS 'equipmentName',
       equipment_stock.location, location.name,
       equipment_stock.equipmentStatus, equipment_type.pricePerHour
FROM equipment_stock
INNER JOIN location ON equipment_stock.location = location.locationID
INNER JOIN equipment_type ON equipment_stock.equipmentType = equipment_type.equipmentTypeID;";
} else if($location_id !== "" && $search === "") {
    $sql_query = "SELECT equipment_stock.equipmentID, equipment_stock.equipmentType, equipment_type.equipmentType AS 'equipmentName',
       equipment_stock.location, location.name,
       equipment_stock.equipmentStatus, equipment_type.pricePerHour
FROM equipment_stock
INNER JOIN location ON equipment_stock.location = location.locationID
INNER JOIN equipment_type ON equipment_stock.equipmentType = equipment_type.equipmentTypeID
 WHERE location.locationID = '$location_id';";
} else if($location_id === "" && $search !=="") {
    $sql_query = "SELECT equipment_stock.equipmentID, equipment_stock.equipmentType, equipment_type.equipmentType AS 'equipmentName',
       equipment_stock.location, location.name,
       equipment_stock.equipmentStatus, equipment_type.pricePerHour
FROM equipment_stock
INNER JOIN location ON equipment_stock.location = location.locationID
INNER JOIN equipment_type ON equipment_stock.equipmentType = equipment_type.equipmentTypeID
 WHERE equipment_stock.equipmentID LIKE '%$search%'
 OR equipment_stock.equipmentType LIKE '%$search%'
 OR equipment_type.equipmentType LIKE '%$search%'
 OR location.name LIKE '%$search%'
 OR equipment_stock.equipmentStatus LIKE '$search'
 OR equipment_type.pricePerHour LIKE '$search';";
} else {
    $sql_query = "SELECT equipment_stock.equipmentID, equipment_stock.equipmentType, equipment_type.equipmentType AS 'equipmentName',
       equipment_stock.location, location.name,
       equipment_stock.equipmentStatus, equipment_type.pricePerHour
FROM equipment_stock
INNER JOIN location ON equipment_stock.location = location.locationID
INNER JOIN equipment_type ON equipment_stock.equipmentType = equipment_type.equipmentTypeID
 WHERE equipment_stock.equipmentID LIKE '%$search%'
 OR equipment_stock.equipmentType LIKE '%$search%'
 OR equipment_type.equipmentType LIKE '%$search%'
 OR location.name LIKE '%$search%'
 OR equipment_stock.equipmentStatus LIKE '$search'
 OR equipment_type.pricePerHour LIKE '$search'
HAVING equipment_stock.location = '$location_id';";
}
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
