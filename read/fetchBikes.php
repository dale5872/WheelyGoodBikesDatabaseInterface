<?php
/**
 * Created by PhpStorm.
 * User: dale
 * Date: 01/03/19
 * Time: 12:23
 */

include('../databaseConnector.php');

//get connection object
$conn = connect();

$location_id = mysqli_real_escape_string($conn, $_POST['location_id']);
$search = mysqli_real_escape_string($conn, $_POST['search']);

//create the query to execute

if($location_id === "" && $search === "") {
    $sql_query = "SELECT bike_stock.bikeID, bike_stock.bikeType, bike_type.bikeType AS 'bikeName',
       bike_stock.location, location.name,
       bike_stock.bikeStatus, bike_type.pricePerHour
FROM bike_stock
INNER JOIN location ON bike_stock.location = location.locationID
INNER JOIN bike_type ON bike_stock.bikeType = bike_type.bikeTypeID;";
} else if($location_id !== "" && $search === "") {
    $sql_query = "SELECT bike_stock.bikeID, bike_stock.bikeType, bike_type.bikeType AS 'bikeName',
       bike_stock.location, location.name,
       bike_stock.bikeStatus, bike_type.pricePerHour
FROM bike_stock
INNER JOIN location ON bike_stock.location = location.locationID
INNER JOIN bike_type ON bike_stock.bikeType = bike_type.bikeTypeID
 WHERE location.locationID = '$location_id';";
} else if($location_id === "" && $search !=="") {
    $sql_query = "SELECT bike_stock.bikeID, bike_stock.bikeType, bike_type.bikeType AS 'bikeName',
       bike_stock.location, location.name,
       bike_stock.bikeStatus, bike_type.pricePerHour
FROM bike_stock
INNER JOIN location ON bike_stock.location = location.locationID
INNER JOIN bike_type ON bike_stock.bikeType = bike_type.bikeTypeID
 WHERE bike_stock.bikeID LIKE '%$search%'
 OR bike_stock.bikeType LIKE '%$search%'
 OR bike_type.bikeType LIKE '%$search%'
 OR location.name LIKE '%$search%'
 OR bike_stock.bikeStatus LIKE '$search'
 OR bike_type.pricePerHour LIKE '$search';";
} else {
    $sql_query = "SELECT bike_stock.bikeID, bike_stock.bikeType, bike_type.bikeType AS 'bikeName',
       bike_stock.location, location.name,
       bike_stock.bikeStatus, bike_type.pricePerHour
FROM bike_stock
INNER JOIN location ON bike_stock.location = location.locationID
INNER JOIN bike_type ON bike_stock.bikeType = bike_type.bikeTypeID
 WHERE bike_stock.bikeID LIKE '%$search%'
 OR bike_stock.bikeType LIKE '%$search%'
 OR bike_type.bikeType LIKE '%$search%'
 OR location.name LIKE '%$search%'
 OR bike_stock.bikeStatus LIKE '$search'
 OR bike_type.pricePerHour LIKE '$search'
HAVING bike_stock.location = '$location_id';";
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
