<?php
/**
 * Created by PhpStorm.
 * User: dalebaker-allan
 * Date: 2019-02-13
 * Time: 10:34
 */

include("../databaseConnector.php");

//Get the data
$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = mysqli_real_escape_string($conn, $_POST['password']);
$account_type = mysqli_real_escape_string($conn, $_POST['account_type']);
$location_id = mysqli_real_escape_string($conn, $_POST['location_id']);
$first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
$last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$phone = mysqli_real_escape_string($conn, $_POST['phone']);

//first we create a query to add the user account and retrieve the user id
//create the query to execute
$sql_query = "INSERT INTO user VALUES (null, '$account_type', '$username', '$password');";
//execute query and get results

/**
 * @TODO Fix an unknown error in inserting Employee Account
 * @BODY An unknown error is occuring (i.e. no error output using curl) when
 * attempting to insert into database. Data is inserted into user account but then fails.
 */
if($conn->query($sql_query) === TRUE) {
    //stored successfully, we can continue
    //we need to get the user id of the inserted user
    $sql_query = "SELECT user.userID FROM user WHERE username = '$username' AND password = '$password';";
    $results = $conn->query($sql_query);
    if($results->num_rows == 1) {
        $user_id = $results['userID'];
        echo $user_id . "\n";
        //continue
    } else {
        echo "failed";
        //failed, return error
        $arr = array('error' => 'Could not get userID of new user!');
        echo json_encode($arr);
        die();
    }

    //insert into employee table
    $sql_query = "INSERT INTO employees VALUES (null '$user_id', '$location_id');";
    if($conn->query($sql_query) === TRUE) {
        //success, continue

        //we now need the employee ID
        $sql_query = "SELECT employees.employeeID FROM employees WHERE employees.userID = '$user_id';";
        $results = $conn->query($sql_query);
        if($results->num_rows == 1) {
            $employee_id = $results['employeeID'];
            echo $employee_id . "\n";
            //continue
        } else {
            //failed, return error
            $arr = array('error' => 'Could not get employeeID of new user!');
            echo json_encode($arr);
            die();
        }

        //insert employee info
        $sql_query = "INSERT INTO employee_info VALUES ('$employee_id', '$first_name', '$last_name', '$email', '$phone');";
        if($conn->query($sql_query) === TRUE) {
            echo "SUCCESS";
            //then the user has been successfully added, finish up and return to user
            $arr = array('success' => 'The user has been successfully added');
            echo json_encode($arr);}
    } else {
        //error, terminate
        $arr = array('error' => 'Could not insert employee into the database!');
        echo json_encode($arr);
        die();
    }
} else {
    //error, terminate
    //create an array with 'error' tag that maps to the error,
    //this is so the json can encode as [{"error" : "..."}]
    $arr = array('error' => 'Could not insert user into the database!', 'stackTrace' => $conn->error);
    echo json_encode($arr);
    die();
}

//ALWAYS CLOSE CONNECTION
$conn->close();
