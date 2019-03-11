<?php
/**
 * Created by PhpStorm.
 * User: dalebaker-allan
 * Date: 2019-03-11
 * Time: 18:07
 */

include('../databaseConnector.php');

//get connection object
$conn = connect();

$bike_id = mysqli_real_escape_string($conn, $_POST['bike_id']);
