<?php

	function loadRes($pathParts){
		$src=null;
		switch(strtolower($pathParts["extension"])){
			case "png":
				$imageSrcPath=$pathParts["dirname"] . "/" . $pathParts["basename"];
				$src=imagecreatefrompng($imageSrcPath);
			break;
			case "gif":
				$imageSrcPath=$pathParts["dirname"] . "/" . $pathParts["basename"];
				$src=imagecreatefromgif($imageSrcPath);
			break;
			
			case "jpeg":
			case "jpg":
				$imageSrcPath=$pathParts["dirname"] . "/" . $pathParts["basename"];
				$src=imagecreatefromjpeg($imageSrcPath);
				
			break;
			default:
		}
		return $src;
	}
	
	function resizeRes($src, $newHeight, $newWidth){
		if(!$newHeight&&!$newWidth){
			$oldWidth=imagesx($src);
			$oldHeight=imagesy($src);
			$newWidth=$oldWidth;
			$newHeight=$oldHeight;
		}
		if($newHeight){
			$oldWidth=imagesx($src);
			$oldHeight=imagesy($src);
			$newWidth=$newHeight/$oldHeight*$oldWidth;
		}else if($newWidth){
			$oldHeight=imagesy($src);
			$oldWidth=imagesx($src);
			$newHeight=$newWidth/$oldWidth*$oldHeight;
		}
		if($newWidth==$oldWidth&&$newHeight==$oldHeight){
			$dst=$src;
		}else{
			$dst=imagecreatetruecolor($newWidth, $newHeight);
			imagepalettecopy($dst, $src);
			$errorlevel=imagecopyresized($dst, $src, 0, 0, 0, 0, $newWidth, $newHeight, $oldWidth, $oldHeight);
		}
		return $dst;
	}
	
	function saveRes($dst, $pathParts, $extn){
		switch(strtolower($extn)){
			case "png":
				$relayName=($pathParts["extension"]!=$extn?(substr($pathParts["basename"], 0, strpos($pathParts["basename"], $pathParts["extension"])) . $extn):$pathParts["basename"]);
				if(isSet($_GET["prefix"])){
					$relayName=$_GET["prefix"] . $relayName;
				}
				$relayPath=(isSet($_GET["relayPath"])?$_GET["relayPath"]:$pathParts["dirname"]) . "/" . $relayName;
				if(isSet($_GET["clean"])){
					$relayPath=$_GET["clean"]=="YES"?false:$relayPath;
				}
				if($relayPath) imagepng($dst, $relayPath); else{
					Header ("Content-type: image/png");
					imagepng($dst);
				}
			break;
			case "gif":
				$relayName=($pathParts["extension"]!=$extn?(substr($pathParts["basename"], 0, strpos($pathParts["basename"], $pathParts["extension"])) . $extn):$pathParts["basename"]);
				if(isSet($_GET["prefix"])){
					$relayName=$_GET["prefix"] . $relayName;
				}
				$relayPath=(isSet($_GET["relayPath"])?$_GET["relayPath"]:$pathParts["dirname"]) . "/" . $relayName;
				if(isSet($_GET["clean"])){
					$relayPath=$_GET["clean"]=="YES"?false:$relayPath;
				}
				if($relayPath) imagegif($dst, $relayPath); else{
					Header ("Content-type: image/gif");
					imagegif($dst);
				}
			break;
			
			case "jpeg":
			case "jpg":
				$relayName=($pathParts["extension"]!=$extn?(substr($pathParts["basename"], 0, strpos($pathParts["basename"], $pathParts["extension"])) . $extn):$pathParts["basename"]);
				if(isSet($_GET["prefix"])){
					$relayName=$_GET["prefix"] . $relayName;
				}
				$relayPath=(isSet($_GET["relayPath"])?$_GET["relayPath"]:$pathParts["dirname"]) . "/" . $relayName;
				if(isSet($_GET["clean"])){
					$relayPath=$_GET["clean"]=="YES"?false:$relayPath;
				}
				if($relayPath) imagejpeg($dst, $relayPath); else{
					Header ("Content-type: image/jpg");
					imagejpeg($dst);
				}
			break;
			default:
		}
	}

	$filepath=$_GET["picpath"];
	$newHeight=(isSet($_GET["height"]))?$_GET["height"]:false;
	$newWidth=(isSet($_GET["width"]))?$_GET["width"]:false;
	$imagePathInfo=pathinfo($filepath);
	saveRes(resizeRes(loadRes($imagePathInfo), $newHeight, $newWidth), $imagePathInfo, (isSet($_GET["trnext"])?$_GET["trnext"]:$imagePathInfo["extension"]));
?>