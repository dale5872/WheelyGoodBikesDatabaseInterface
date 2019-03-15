<?php
/**
 * Created by PhpStorm.
 * User: dalebaker-allan
 * Date: 2019-03-12
 * Time: 13:41
 */

$report = $_POST['folder'];
$location = $_POST['location'];

$dir = realpath("../../Reports/" . $report . "/location" . $location);
$files = scandir($dir);

//remove '.' and '..' entries
unset($files[0]);
unset($files[1]);
$files = array($files);

$arr = array('status' => 'success', 'data' => $files);
echo json_encode($arr);
