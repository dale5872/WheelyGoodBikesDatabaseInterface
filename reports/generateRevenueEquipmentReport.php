<?php
/**
 * Created by PhpStorm.
 * User: dalebaker-allan
 * Date: 2019-03-17
 * Time: 19:33
 */

include('../databaseConnector.php');

//get connection object
$conn = connect();

$location = mysqli_real_escape_string($conn, $_POST['location_id']);
$fromDate = mysqli_real_escape_string($conn, $_POST['fromDate']);
$toDate = mysqli_real_escape_string($conn, $_POST['toDate']);

$filepath = realpath("../../Reports/Revenue/");
$fileLocation = $filepath . "/location" . $location;
$dir = $fileLocation . "/" . $fromDate . " - " . $toDate . ".wgb";

/**
if(file_exists($dir)) {
$file = fopen($dir, "r") or die(json_encode(array('status' => 'error', 'message' => '1Cannot store report, contact an administrator and check the log files', 'stackTrace' => print_r(error_get_last(), true))));
$output = fread($file, filesize($dir));
fclose($file);
$conn->close();
echo $output;
return;
}
echo $filename;
 * **/

$sql_query = "SELECT
       CAST(startTime AS DATE) AS \"Date\", SUM(cost) AS \"Revenue\"
FROM equipment_rentals
WHERE startTime BETWEEN '$fromDate' AND '$toDate'
AND location = '$location'
GROUP BY CAST(startTime AS DATE);";
$result = $conn->query($sql_query);

if($result->num_rows > 0) {
    //we have a match, create an array to store all the rows
    $rows = array();

    //loop through all the rows in the result set
    while($row = $result->fetch_assoc()) {
        //add current row into array
        $rows[] = $row;
    }

    if(!file_exists($fileLocation)) {
        $res = mkdir($fileLocation, 0777, true);
        if($res !== true) {
            $arr = array('status' => 'error', 'message' => 'Cannot store report, contact an administrator and check the log files', 'stackTrace' => 'Folder does not exist');
            die(json_encode($arr));
        }
    }

    //output as json encoded text
    $arr = array('status' => 'success', 'data' => $rows);

    $file = fopen($dir, "w") or die(json_encode(array('status' => 'error', 'message' => 'Cannot store report, contact an administrator and check the log files', 'stackTrace' => print_r(error_get_last(), true))));
    fwrite($file, json_encode($arr));
    fclose($file);

    echo json_encode($arr);
} else if($result->num_rows == 0) {
    //no match
    //create an array with 'error' tag that maps to the error,
    //this is so the json can encode as [{"error" : "..."}]
    $arr = array('status' => 'error', 'message' => 'empty', 'stackTrace' => $conn->error);
    echo json_encode($arr);
}

$conn->close();