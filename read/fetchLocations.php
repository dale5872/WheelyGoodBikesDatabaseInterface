<?php
/**
 * Created by PhpStorm.
 * User: dalebaker-allan
 * Date: 2019-02-12
 * Time: 23:51
 */

include("../databaseConnector.php");
//NO DATA

$conn = connect();

//create the query to execute
$sql_query = "SELECT location.locationID, location.name FROM location;";

//execute query and get results
$result = $conn->query($sql_query);

if($result->num_rows > 0) {
    //we have a match, create an array to store all the rows
    echo "Match";
    $rows = array();

    //loop through all the rows in the result set
    while($row = $result->fetch_assoc()) {
        //add current row into array
        $rows[] = $row;
    }

    //output as json encoded text
    echo json_encode($rows);
} else if($result->num_rows == 0) {
    //no match
    //create an array with 'error' tag that maps to the error,
    //this is so the json can encode as [{"error" : "..."}]
    $arr = array('error' => 'empty');
    echo json_encode($arr);
}

//ALWAYS CLOSE CONNECTION
$conn->close();
