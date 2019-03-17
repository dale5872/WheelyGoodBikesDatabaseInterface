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

$search = mysqli_real_escape_string($conn, $_POST['search']);

//create the query to execute
if($search === "") {
    $sql_query = "SELECT location.locationID, location.name FROM location;";
} else {
    //we have a search query
    $sql_query = "SELECT location.locationID, location.name FROM location
WHERE location.name LIKE '%$search%';";

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
