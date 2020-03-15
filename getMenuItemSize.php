<?php
$stdpath="";
$thatFile=$stdpath . "fxd_" . urldecode($_GET["isString"]) . ".gif";
$ButtonImg = @ImageCreateFromGIF($thatFile);
echo "var width=" . imagesx($ButtonImg) . ";";
echo "var height=" . imagesy($ButtonImg) . ";";
?>