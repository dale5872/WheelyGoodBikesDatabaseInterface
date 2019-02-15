<?php
/**
 * Created by PhpStorm.
 * User: dalebaker-allan
 * Date: 2019-02-14
 * Time: 17:47
 */

include("../databaseConnector.php");

$conn = connect();

//get data
$location_name = mysqli_real_escape_string($conn, $_POST['location_name']);

//create the query to execute
$sql_query = "SELECT location.locationID FROM location WHERE location.name='$location_name';";
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