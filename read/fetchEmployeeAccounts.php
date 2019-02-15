<?php
/**
 * Created by PhpStorm.
 * User: dalebaker-allan
 * Date: 2019-02-12
 * Time: 23:36
 */

/**
 * Gets all of the employee accounts
 * @param account_type empty for all accounts, 'Manager' or 'Operator'
 * STRINGS MATCH EXACTLY
 */

include('../databaseConnector.php');

//get connection object
$conn = connect();
// Get data from the HTTP POST request
$account_type = mysqli_real_escape_string($conn, $_POST['account_type']);

//check if account type is empty
//create the query to execute
if($account_type === "") {
    $sql_query = "SELECT employees.employeeID, user.username,  employee_info.firstName, employee_info.lastName,
       employee_info.workEmail, employee_info.workTel, account_types.type, location.name AS 'location', location.locationID, user.userID
FROM user
INNER JOIN employees ON user.userID = employees.userID
INNER JOIN employee_info ON employees.employeeID = employee_info.employeeID
INNER JOIN account_types ON user.accountTypeID = account_types.accountTypeID
INNER JOIN location ON employees.location = location.locationID;";
} else {
    $sql_query = "SELECT employees.employeeID, user.username,  employee_info.firstName, employee_info.lastName,
       employee_info.workEmail, employee_info.workTel, account_types.type, location.name AS 'location'
FROM user
INNER JOIN employees ON user.userID = employees.userID
INNER JOIN employee_info ON employees.employeeID = employee_info.employeeID
INNER JOIN account_types ON user.accountTypeID = account_types.accountTypeID
INNER JOIN location ON employees.location = location.locationID
WHERE account_types.type = '$account_type';";
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
    $arr = array('error' => 'empty');
    echo json_encode($arr);
}

//ALWAYS CLOSE CONNECTION
$conn->close();
