<?php

	function imageValid($filename) {
		$type  = exif_imagetype($filename);
		
		switch($type) {
			case 1:
				return @imagecreatefromgif($filename) ? true : false; 
				break;
			case 2:
				return @imagecreatefromjpeg($filename) ? true : false; 
				break;
			case 3:
				return @imagecreatefrompng($filename) ? true : false; 
				break;
			default:
				return false;
		}
	}


?>