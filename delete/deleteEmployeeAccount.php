<?php
/**
 * Created by PhpStorm.
 * User: dalebaker-allan
 * Date: 2019-02-13
 * Time: 11:07
 */

include("../databaseConnector.php");

$user_id = mysqli_real_escape_string($conn, $_POST['user_id']);