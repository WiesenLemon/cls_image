<?php
 //.php?picturePath=./gfx/item_1_slap_.png&basepath=./&heightSlice=2&addAligned=YES
echo "mom";
	$picpath=$_GET["picturePath"];
	$nrSlices=$_GET["numberSlices"];
	$heightSl=$_GET["heightSlice"];
	$addAlignedLo=($_GET["addAligned"]=="YES")?true:false;
	echo $addAlignedLo?"mokka":$_GET["addAligned"] . "lokkq";
	$getAt=$_GET["sliceNr"];
	$getAlign=$_GET["align"];
	$homedir=urldecode($_GET["basepath"]);
	$step=0;
	chdir($homedir);


	$src=imagecreatefrompng($picpath);
	$width=imagesx($src);
	$height=imagesy($src);
echo "__" . $height;
	$name=$_GET["filename"];
	echo $heightSl . "############";	
	
	$stepSl=0;
	if($addAlignedLo){
		echo "mnil2";
		$nrSlices=$height/$heightSl;
		echo "!_$heightSl_" . $nrSlices . "_$height!";
		$stepSl=$heightSl;
		echo "lol555";
	}
	
echo "lol2";
	echo $nrSlices;
	for($a=0; $a < $nrSlices; $a++){		
		$burst=false;
		echo "lollli";
		if($getAt==$a||$addAlignedLo){
			$imageSrcPath=$picpath;
			$src=imagecreatefrompng($imageSrcPath);
			$width=imagesx($src);
			$height=imagesy($src);
			$dstTop=imagecreatetruecolor($width, $heightSl);
			$dstBottom=imagecreatetruecolor($width, $heightSl);
			imagepalettecopy($dstBottom, $src);
			imagepalettecopy($dstTop, $src);
			$burst=true;
		}
		if($burst){
			if($getAlign=="top") $errorlevel1=imagecopy($dstTop, $src, 0, 0, 0, 0, $width, $heightSl);
			$step+=$addAlignedLo?$stepSl:$heightSl;
			$heightSl+=$addAlignedLo?$stepSl:0;
			if($getAlign=="bottom") $errorlevel2=imagecopy($dstBottom, $src, 0, 0, 0, $height-$step, $width, $heightSl);
			echo "lop<br>";
			
if($getAlign=="top") imagepng($dstTop, $name . $a . ".png");
			if($getAlign=="bottom") imagepng($dstBottom, $name . $a . ".png");
		}
	}
?>
