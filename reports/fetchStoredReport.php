<?php
/**
 * Created by PhpStorm.
 * User: dalebaker-allan
 * Date: 2019-03-12
 * Time: 13:46
 */

$report = $_POST['report'];
$location = $_POST['location_id'];
$filename = $_POST['filename'];

$dir = realpath("../../Reports") . "/" . $report . "/location" . $location . "/" . $filename;

$file = fopen($dir, "r") or die("Could not open file " . $dir . "!");
$output = fread($file, filesize($dir));
fclose($file);

echo $output;