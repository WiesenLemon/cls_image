<?php
$box=imageftbbox(urldecode($_GET["fontSize"]) ,0 , urldecode($_GET["fontPath"]) , urldecode($_GET["isString"]));
$width=$box[2];
$stdpath="";
$spacer=0;
if(isSet($_GET["spacer"])){
$spacer=urldecode($_GET["spacer"]);
}
if(isSet($_GET["outPath"])) $stdpath=urldecode($_GET["outPath"]); else $stdpath="./produce/";

$thatFile=$stdpath . "fxd_" . urldecode($_GET["isString"]) . ".gif";

if(isSet($_GET["width"])){
	$width=urldecode($_GET["width"]);
}
$height=0;
if(isSet($_GET["height"])){
	$height=urldecode($_GET["height"]);
}


$stringImg=null;
$stringImg2=null;
if(isSet($_GET["backImage"])){
	$stringImg = @ImageCreateFromGIF($_GET["backImage"]);

}
$leftImg2Fit=null;
if(isSet($_GET["backImageLeftKick"])){
	$leftImg2Fit = @imageCreateFromGIF($_GET["backImageLeftKick"]);
}
$rightImg2Fit=null;
if(isSet($_GET["backImageRightKick"])){
	$rightImg2Fit = @imageCreateFromGIF($_GET["backImageRightKick"]);
}
if (!$stringImg) {
	$stringImg =imagecreatetruecolor($width, $height);
	$backgroundColor=imagecolorallocate($stringImg, urldecode($_GET["backColorRed"]), urldecode($_GET["backColorGreen"]), urldecode($_GET["backColorBlue"]));
	imagefill ($stringImg, 0 , 0 , $backgroundColor);
}
$width+=imagesx($leftImg2Fit)+imagesx($rightImg2Fit);
$stringImg2 =imagecreatetruecolor($width, $height);
imagecopyresampled($stringImg2 , $stringImg , 0 , 0 , 0 , 0, $width , $height, imagesx($stringImg) , imagesy($stringImg));
if($leftImg2Fit&&$rightImg2Fit){
	imagecopyresampled($stringImg2, $leftImg2Fit, 0, 0, 0, 0, imagesx($leftImg2Fit), $height, imagesx($leftImg2Fit), imagesy($leftImg2Fit));
	imagecopyresampled($stringImg2, $rightImg2Fit, imagesx($stringImg2)-imagesx($rightImg2Fit), 0, 0, 0, imagesx($rightImg2Fit), $height, imagesx($rightImg2Fit), imagesy($rightImg2Fit));
}
$fontColor=imagecolorallocate($stringImg2, urldecode($_GET["fontColorRed"]), urldecode($_GET["fontColorGreen"]), urldecode($_GET["fontColorBlue"]));
ImageTTFText ($stringImg2, urldecode($_GET["fontSize"]), 0, imagesx($leftImg2Fit), $height/2+$spacer/2, $fontColor, urldecode($_GET["fontPath"]), urldecode($_GET["isString"]));
if(!file_exists($thatFile)){
	imagegif($stringImg2, $thatFile);
}
Header ("Content-type: image/gif");
echo file_get_contents($thatFile);

?>