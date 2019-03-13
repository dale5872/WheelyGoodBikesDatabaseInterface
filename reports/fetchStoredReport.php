<?php
/**
 * Created by PhpStorm.
 * User: dalebaker-allan
 * Date: 2019-03-12
 * Time: 13:46
 */

$filename = $_POST['filename'];

$dir = realpath("../../Reports") . "/" . $filename;

$file = fopen($dir, "r") or die("Could not open file " . $dir . "!");
$output = fread($file, filesize($dir));
fclose($file);

echo $output;