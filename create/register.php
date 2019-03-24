<?php

include("databaseConnector.php");
//connection object
$conn = connect();
//data
$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

$fname = mysqli_real_escape_string($conn, $_POST['fname']);
$lname = mysqli_real_escape_string($conn, $_POST['lname']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$phone = mysqli_real_escape_string($conn, $_POST['phone']);
$line1 = mysqli_real_escape_string($conn, $_POST['line1']);
$line2 = mysqli_real_escape_string($conn, $_POST['line2']);
$postcode = mysqli_real_escape_string($conn, $_POST['postcode']);
$county = mysqli_real_escape_string($conn, $_POST['county']);

$sql_query = "INSERT INTO user VALUES (null, '1', '$username', '$password');";
if($conn->query($sql_query) !== TRUE) {
    //error, terminate
    $arr = array('status' => 'error', 'message' => 'Could not create new user', 'stackTrace' => $conn->error);
    echo json_encode($arr);
    die();
}


$sql_query = "SELECT userID FROM user WHERE username='$username' AND password='$password';";

$results = $conn->query($sql_query);
if($results->num_rows > 1 || $results->num_rows == 0) {
    //failed
    $arr = array('status' => 'error', 'message' => 'Could not get new userID!', 'stackTrace' => $conn->error);
    echo json_encode($arr);
    die();
}
//get the first row
$row = $results->fetch_assoc();
//row['<name>'] are the same as the database columns
$user_id = $row['userID'];
$sql_query = "INSERT INTO user_info VALUES ('$user_id', '$fname', '$lname', '$email', '$phone');";

if($conn->query($sql_query) !== TRUE) {
    //error, terminate
    $arr = array('status' => 'error', 'message' => 'Could not insert info into the database!', 'stackTrace' => $conn->error);
    echo json_encode($arr);
    die();
}


$sql_query = "INSERT INTO customer_address VALUES ('$user_id', '$line1', '$line2', '$postcode', '$county');";

if($conn->query($sql_query) !== TRUE) {
    //error, terminate
    $arr = array('status' => 'error', 'message' => 'Could not insert info into the database!', 'stackTrace' => $conn->error);
    echo json_encode($arr);
    die();
}

//we have succeeded
$arr = array('status' => 'success');
echo json_encode($arr);
//ALWAYS CLOSE CONNECTION
$conn->close();

?>
