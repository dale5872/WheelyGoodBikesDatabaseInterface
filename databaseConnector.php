<?php
/**
 * Created by PhpStorm.
 * User: dalebaker-allan
 * Date: 2019-02-12
 * Time: 21:45
 */

 header("Access-Control-Allow-Origin: *");
function connect()
{
// Database information
    $host = "mysql-server-1.macs.hw.ac.uk";
    $user = "db47";
    $pass = "7WwEnz9n99";
    $database = "db47";

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
