<?php
	$picpath=$_GET["picturePath"];
	$nrSlices=$_GET["numberSlices"];
	$heightSl=$_GET["heightSlice"];
	$getAt=$_GET["sliceNr"];
	$getAlign=$_GET["align"];
	$homedir=urldecode($_GET["basepath"]);
	chdir($homedir);
	$step=0;
	for($a=0; $a < $nrSlices; $a++){		
		$burst=false;
		if($getAt==$a){
			$imageSrcPath=$picpath;
			$src=imagecreatefromjpeg($imageSrcPath);
			$width=imagesx($src);
			$height=imagesy($src);
			$dstTop=imagecreatetruecolor($width, $heightSl);
			$dstBottom=imagecreatetruecolor($width, $heightSl);
			imagepalettecopy($dstBottom, $src);
			imagepalettecopy($dstTop, $src);
			$burst=true;
		}
		if($burst){
			if($getAlign=="top") $errorlevel1=imagecopy($dstTop, $src, 0, 0, 0, 0+$step, $width, $heightSl);
			$step+=$heightSl;
			if($getAlign=="bottom")$errorlevel2=imagecopy($dstBottom, $src, 0, 0, 0, $height-$step, $width, $heightSl);
			if($getAlign=="top") imagejpeg($dstTop, "", 100);
			if($getAlign=="bottom") imagejpeg($dstBottom, "", 100);
		}
	}
?>