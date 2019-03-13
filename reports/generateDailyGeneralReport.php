<?php
/**
 * Created by PhpStorm.
 * User: dalebaker-allan
 * Date: 2019-03-11
 * Time: 18:07
 *
 * This report covers the number of users, number of rentals, unique users, late rentals that have used the system in the given location
 * for the previous day (or date specified)
 */

include('../databaseConnector.php');

//define fields
$numUsers = 0;
$numRentals = 0;
$numUniqueUsers = 0;
$numLateRentals = 0;

//get connection object
$conn = connect();

$location_id = mysqli_real_escape_string($conn, $_POST['location_id']);
$date = mysqli_real_escape_string($conn, $_POST['date']);

/** NUMBER OF USERS */
$sql_query = "SELECT
       SUM(IF(startTime BETWEEN '$date 00:00:00' AND '$date 23:59:59', 1, 0)) AS Rentals,
       SUM(DISTINCT userID AND startTime BETWEEN '$date 00:00:00' AND '$date 23:59:59') AS Users,
       SUM(IF(returnTime BETWEEN returnTime AND '$date 23:59:59' AND status = 'Ongoing', 1, 0)) AS Late
FROM bike_rentals;";

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

//echo realpath("../../Reports");
$filename = realpath("../../Reports") . "/l" . $location_id ."_dailyGeneralReport_" . $date . ".wgb";
$file = fopen($filename, "w") or die(print_r(error_get_last(), true));
fwrite($file, json_encode($arr));
fclose($file);
/**
 * TODO: Save reports to server in JSON form so the exact data can be retrieved again
 */

$conn->close();