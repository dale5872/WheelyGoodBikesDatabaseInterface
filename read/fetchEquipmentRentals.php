<?php
/**
 * Created by PhpStorm.
 * User: dale
 * Date: 15/03/19
 * Time: 14:45
 */

include('../databaseConnector.php');

//get connection object
$conn = connect();

$location_id = mysqli_real_escape_string($conn, $_POST['location_id']);
$search = mysqli_real_escape_string($conn, $_POST['search']);

//create the query to execute
if($search !== "") {
    $sql_query = "SELECT equipment_rentals.equipmentRentalID, equipment_rentals.userID, equipment_rentals.equipmentID, equipment_rentals.location,
       equipment_rentals.cost, equipment_rentals.startTime, equipment_rentals.returnTime, equipment_rentals.status
FROM equipment_rentals
WHERE equipment_rentals.location = '$location_id';";
} else {
    $sql_query = "SELECT equipment_rentals.equipmentRentalID, equipment_rentals.userID, equipment_rentals.equipmentID, equipment_rentals.location,
       equipment_rentals.cost, equipment_rentals.startTime, equipment_rentals.returnTime, equipment_rentals.status
FROM equipment_rentals
WHERE equipment_rentals.equipmentRentalID LIKE '%" . $search . "%'
OR equipment_rentals.userID LIKE '" . $search . "'
OR equipment_rentals.equipmentID LIKE '" . $search . "'
OR equipment_rentals.location LIKE '%" . $search . "%'
OR equipment_rentals.cost LIKE '" . $search . "'
OR equipment_rentals.startTime LIKE '%" . $search . "%'
OR equipment_rentals.returnTime LIKE '%" . $search . "%'
OR equipment_rentals.status LIKE '%" . $search . "%'
HAVING equipment_rentals.location = '$location_id';";
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
