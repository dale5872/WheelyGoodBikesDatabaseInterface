<?php
/**
 * Created by PhpStorm.
 * User: dalebaker-allan
 * Date: 2019-02-12
 * Time: 21:45
 */
function connect()
{
// Database information
    $host = "REDACTED";
    $user = "REDACTED";
    $pass = "REDACTED";
    $database = "REDACTED";

//create connection object
    $conn = new mysqli($host, $user, $pass, $database);

//check for error
    if ($conn->connect_error) {
        die("Connection to the database failed." . $conn->connect_error);
    }

    return $conn;
}
/**
 * As this is just the connector file for the database
 * at the end of each query file, the connection to the database must be closed
 *
 * Usage: $conn->close()
 * Where: $conn is the connection object
 *
 * If used at the end of this file, the connection will be closed
 * before any query has been executed
 */
