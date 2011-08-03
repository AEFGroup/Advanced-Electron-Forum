<?php

function regimagemaker(){

global $globals, $theme, $user, $AEF_SESS;
	
	//Is GD even there
	if(!(extension_loaded('gd') || extension_loaded('GD'))){
	
		return false;
	
	}
	
	//Stop the output buffer
	$globals['stop_buffer_process'] = true;
	
	$string = $AEF_SESS['validation_code'];
	
	@header ("Content-type: image/png");
	
	$string = preg_replace( "/(\w)/", "\\1 ", $string);
	
	$string = trim($string);
	
	// Create the Temp Image
	$im = @imagecreate(80, 20) or die("Cannot Initialize new GD image stream");
	
	//Fill it with White Background Colour
	$bg_col = imagecolorallocate($im, 255, 255, 255);
	
	//The Colours
	$black = imagecolorallocate($im, 0, 0, 0);
	$white = imagecolorallocate($im, 255, 255, 255);
	
	imagestring($im, 5, 0, 2,  $string, $black);
	
	// Create the Image
	$img = @imagecreate(200, 50) or die("Cannot Initialize new GD image stream");
	
	//Fill it with White Background Colour
	$bg_color = imagecolorallocate($img, 255, 255, 255);
	
	//The Colours
	$black = imagecolorallocate($img, 0, 0, 0);
	$white = imagecolorallocate($img, 255, 255, 255);
	$grey = imagecolorallocate($img, 100, 100, 100);	
	
	imagecopyresized($img, $im, 25, 0, 0, 0, 150, 50, 80, 20);
	
	//Destroy temp Image
	imagedestroy($im);
	
	for($i=1; $i<=10; $i++){
	
		imageline($img, ($i*20), 0, ($i*20), 50, $grey);
	
	}
	
	for($i=1; $i<=5; $i++){
	
		imageline($img, 0, ($i*10), 200, ($i*10), $grey);
	
	}

	imageline($img, 1, 1, 199, 1, $grey);
	imageline($img, 1, 49, 199, 49, $grey);
	imageline($img, 1, 1, 1, 49, $grey);
	imageline($img, 199, 1, 199, 49, $grey);
	
	for ($i = 0; $i < 500; $i++){
	
		imagesetpixel($img, rand(1, 199), rand(1, 49), $grey);
		
	}
	
	//Output in PNG
	imagepng($img);
	
	//Destroy it
	imagedestroy($img);	
		
	//We must die to avoid Echoing of not used text
	die();
	
}



?>