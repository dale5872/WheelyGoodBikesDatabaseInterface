<?php
/**
 * Created by PhpStorm.
 * User: dalebaker-allan
 * Date: 2019-02-23
 * Time: 20:04
 */

/**
 * Gets all of the employee accounts
 * @param account_type empty for all accounts, 'Manager' or 'Operator'
 * STRINGS MATCH EXACTLY
 */

include('../databaseConnector.php');

//get connection object
$conn = connect();

$search = mysqli_real_escape_string($conn, $_POST['search']);

//create the query to execute
if(search === "") {
    $sql_query = "SELECT user.userID, user.username,  user_info.firstName, user_info.lastName,
       user_info.email, user_info.telNumber
FROM user
INNER JOIN user_info ON user.userID = user_info.userID
INNER JOIN account_types ON user.accountTypeID = 1;";
} else {
    //we have a search term
    $sql_query = "SELECT DISTINCT user.userID, user.username,  user_info.firstName, user_info.lastName,
       user_info.email, user_info.telNumber
FROM user
INNER JOIN user_info ON user.userID = user_info.userID
INNER JOIN account_types ON user.accountTypeID = 1
WHERE username LIKE '%$search%' 
    OR firstName LIKE '%$search%'
    OR lastName LIKE '%$search%'
    OR email LIKE '$search'
    OR telNumber LIKE '$search';";
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
