<?php

/**
 * Created by PhpStorm.
 * User: dalebaker-allan
 * Date: 2019-03-11
 * Time: 11:18
 */

include('../databaseConnector.php');

//get connection object
$conn = connect();

$location_id = mysqli_real_escape_string($conn, $_POST['location_id']);
$search = mysqli_real_escape_string($conn, $_POST['search']);

//create the query to execute
if($search !== "") {
    $sql_query = "SELECT bike_rentals.bikeRentalID, bike_rentals.userID, bike_rentals.bikeID, bike_rentals.location,
       bike_rentals.cost, bike_rentals.startTime, bike_rentals.returnTime, bike_rentals.status
FROM bike_rentals
WHERE bike_rentals.location = '$location_id';";
} else {
    $sql_query = "SELECT bike_rentals.bikeRentalID, bike_rentals.userID, bike_rentals.bikeID, bike_rentals.location,
       bike_rentals.cost, bike_rentals.startTime, bike_rentals.returnTime, bike_rentals.status
FROM bike_rentals
WHERE bike_rentals.bikeRentalID LIKE '%" . $search . "%'
OR bike_rentals.userID LIKE '" . $search . "'
OR bike_rentals.bikeID LIKE '" . $search . "'
OR bike_rentals.location LIKE '%" . $search . "%'
OR bike_rentals.cost LIKE '" . $search . "'
OR bike_rentals.startTime LIKE '%" . $search . "%'
OR bike_rentals.returnTime LIKE '%" . $search . "%'
OR bike_rentals.status LIKE '%" . $search . "%'
HAVING bike_rentals.location = '$location_id';";
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
