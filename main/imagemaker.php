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
    
    header ("Content-type: image/png");
    
    $string = preg_replace( "/(\w)/", "\\1 ", $string);
    
    $string = trim($string);
    
    // Create the Temp Image
    $im = imagecreate(80, 20) or die("Cannot Initialize new GD image stream");
    
    //Fill it with White Background Colour
    $bg_col = imagecolorallocate($im, 155, 164, 155);
    
    //The Colours
    $black = imagecolorallocate($im, 255, 255, 255);
    $white = imagecolorallocate($im, 80, 100, 50);
    
    imagestring($im, rand(1,5), 0, 2,  $string, $black);
    
    // Create the Image
    $img = imagecreate(200, 50) or die("Cannot Initialize new GD image stream");
    
    //Fill it with White Background Colour
    $bg_color = imagecolorallocate($im, 155, 164, 155);
    
    //The Colours
    $black = imagecolorallocate($img, 255, 255, 255);
    $white = imagecolorallocate($img, 80, 100, 50);
    $random_color = imagecolorallocate($img, rand(1,255), rand(1,255), rand(1,255));    
    
    imagecopyresized($img, $im, 25, 0, 0, 0, 150, 50, 80, 20);
    
    //Destroy temp Image
    imagedestroy($im);
    
    //random lines
    for($i=1; $i<=60; $i++){
        imageline($img, rand(1,255), rand(1,255), rand(1,255), rand(1,255), $random_color);
    }
    //random dots, notice that the dots and the lines has the same color
    for ($i = 0; $i < 500; $i++){
        imagesetpixel($img, rand(1, 199), rand(1, 49), $random_color);
    }
    
    //Output in PNG
    imagepng($img);
    
    //Destroy it
    imagedestroy($img); 
        
    //We must die to avoid Echoing of not used text
    die();
}
