<?php
/* Deseneaza un wallpaper personalizat, primind parametru un MAC
 * si pornind de la uso.jpg
 */
require ('../conf.php');

$param1 = $_GET['param1'];
$base_jpg = $conf['base_jpg'];
$text = "@".$param1;

$image = imagecreatefromjpeg($base_jpg);

$bgColor = imagecolorallocate($image, 255, 255, 255);

$textColor = imagecolorallocate($image, 0, 0, 0);

// Edited by Calin Iorgulescu 01.11.2009, move text to a different position
// imagestring($image, 5, 100, 80, $text, $textColor);
imagestring($image, 5, 900, 600, $text, $textColor);

// Headers
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header('Content-type: image/jpeg');
imagejpeg($image);
imagedestroy($image);
die;
