<?php
$stdpath="";
if(isSet($_GET["outPath"])) $stdpath=urldecode($_GET["outPath"]); else $stdpath="./produce/";

$thatFile=$stdpath . "fxd_" . urldecode($_GET["isChar"]) . ".gif";
$box=imagettfbbox(urldecode($_GET["fontSize"]) ,0 , urldecode($_GET["fontPath"]) , urldecode($_GET["isChar"]));
$width=$box[2];
$hcenter=false;
$vcenter=false;	
if(isSet($_GET["width"])){
	$width=urldecode($_GET["width"]);
	$hcenter=(isSet($_GET["hcenter"])?(urldecode($_GET["hcenter"])=="true"?true:false):false);
}
$height=$box[4]*2;
if(isSet($_GET["height"])){
	$height=urldecode($_GET["height"]);
	$vcenter=(isSet($_GET["vcenter"])?(urldecode($_GET["vcenter"])=="true"?true:false):false);
}
$charImg =imagecreatetruecolor($width, $height);
$fontColor=imagecolorallocate($charImg, urldecode($_GET["fontColorRed"]), urldecode($_GET["fontColorGreen"]), urldecode($_GET["fontColorBlue"]));
$backgroundColor=imagecolorallocate($charImg, urldecode($_GET["backColorRed"]), urldecode($_GET["backColorGreen"]), urldecode($_GET["backColorBlue"]));
imagefill ($charImg, 0 , 0 , $backgroundColor);
imagettftext ($charImg, urldecode($_GET["fontSize"]), 0, ($hcenter?($width-$box[2])/4+(isSet($_GET["spacer"])?urldecode($_GET["spacer"])/2:0):0), $height/($vcenter?1:2)-($vcenter?($height-$box[4])/2-(isSet($_GET["spacer"])?urldecode($_GET["spacer"])/2:$height/-4):$height/-4), $fontColor, urldecode($_GET["fontPath"]), urldecode($_GET["isChar"]));
if(isSet($_GET["transparent"])) if($_GET["transparent"]=="true") imagecolortransparent($charImg, $backgroundColor);
imagegif($charImg);

if(!file_exists($thatFile)){
	imagegif($charImg, $thatFile);
}

Header ("Content-type: image/gif");
echo file_get_contents($thatFile);
?>
