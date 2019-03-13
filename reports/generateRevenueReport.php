<?php
/**
 * Created by PhpStorm.
 * User: dalebaker-allan
 * Date: 2019-03-12
 * Time: 18:57
 */


include('../databaseConnector.php');

//get connection object
$conn = connect();

$location = mysqli_real_escape_string($conn, $_POST['location']);
$fromDate = mysqli_real_escape_string($conn, $_POST['fromDate']);
$toDate = mysqli_real_escape_string($conn, $_POST['toDate']);

$sql_query = "SELECT bike_rentals.startTime, SUM(cost) FROM bike_rentals 
GROUP BY returnTime BETWEEN '$fromDate' AND '$toDate'";
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
$filename = realpath("../../Reports") . "/l" . $location_id ."_revenueReport_" . $date . ".wgb";
$file = fopen($filename, "w") or die(print_r(error_get_last(), true));
fwrite($file, json_encode($arr));
fclose($file);

$conn->close();