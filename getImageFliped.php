<?php
	$image=new Imagick($_GET["srcpath"]);
	$image->flipImage();
	imagejpeg($image);
?>