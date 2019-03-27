<?php

include('databaseConnector.php');

$conn = connect();
$user_id = mysqli_real_escape_string($conn, $_POST['user_id']);

$sql_query = "SELECT
                bike_rentals.bikeRentalID,
                bike_rentals.userID,
                bike_rentals.bikeID,
                bike_rentals.location,
                bike_rentals.cost,
                bike_rentals.startTime,
                bike_rentals.returnTime,
                bike_rentals.status
                FROM bike_rentals
                WHERE bike_rentals.location = '$user_id';";

$result = $conn->query($sql_query);
if($result->num_rows > 0) {
    $rows = array();
    while($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    $arr = array('status' => 'success', 'data' => $rows);
    echo json_encode($arr);
} else if($result->num_rows == 0) {
    $arr = array('status' => 'error', 'message' => 'empty', 'stackTrace' => $conn->error);
    echo json_encode($arr);
}
$conn->close();
