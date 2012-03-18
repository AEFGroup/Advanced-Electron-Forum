<?php
//disallow direct access to the file
if (!defined('AEF')) {
    die('Hacking Attempt');
}

//plugin info
$plugin_info = array(
'Name' => 'Advanced Electron Video/Audio Embed',
'Version' => '1.0',
'Description' => 'Advanced Electron Video/Audio Embed ',
'Author' => 'Cris (and some help from SAFAD =P)',
'Website' => 'http://www.anelectron.com');

//main plugin function
function testplugin_ob_handler($buffer, $flags) {
    // Even though the user told us to rewrite, we should do a quick heuristic
    // to check if the page is *actually* HTML. We don't begin rewriting until
    // we hit the first <html tag.
    static $is_html = false;
    
    if (!$is_html) {
        // not HTML until proven otherwise
        if (stripos($buffer, '<html') !== false) {
            $is_html = true;
        } else {
            return $buffer;
        }
    }
    
	$video = array(
 		"/\[youtube\](.*)youtube.com\/watch\?v=(.*)\[\/youtube\]/i" => "<object width=\"425\" height=\"344\"><param name=\"movie\" value=\"http://www.youtube.com/v/\\2&hl=de&fs=1\"></param><param name=\"allowFullScreen\" value=\"true\"></param><embed src=\"http://www.youtube.com/v/\\2&hl=de&fs=1\" type=\"application/x-shockwave-flash\" allowfullscreen=\"true\" width=\"425\" height=\"344\"></embed></object>",
      
		'/\[dailymotion]([a-zA-Z0-9_-]+)\[\/dailymotion\]/Usi' => '<object height="344" width="425"><param name="movie" value="http://www.dailymotion.com/swf/\1"></param><param name="allowFullScreen" value="true"></param><param name="allowScriptAccess" value="always"</param><embed src="http://www.dailymotion.com/swf/\1" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" height="344" width="425"></embed></object>',
 
        '/\[myspace]([A-Za-z0-9_]+)\[\/myspace\]/i' => '<object width="425" height="360" ><param name="allowFullScreen" value="true"/><param name="wmode" value="transparent"/><param name="movie" value="http://mediaservices.myspace.com/services/media/embed.aspx/m=$1,t=1,mt=video"/><embed src="http://mediaservices.myspace.com/services/media/embed.aspx/m=$1,t=1,mt=video" width="425" height="360" allowFullScreen="true" type="application/x-shockwave-flash" wmode="transparent"></embed></object>',
       
        '/\[vimeo]([A-Za-z0-9_]+)\[\/vimeo\]/i' => '<object width="425" height="360" ><param name="allowFullScreen" value="true"/><param name="wmode" value="transparent"/><param name="movie" value="http://vimeo.com/moogaloop.swf?clip_id=$1&amp;server=vimeo.com&amp;show_title=0&amp;show_byline=0&amp;show_portrait=0&amp;color=00ADEF&amp;fullscreen=1&amp;autoplay=0&amp;loop=0"/><embed src="http://vimeo.com/moogaloop.swf?clip_id=$1&amp;server=vimeo.com&amp;show_title=0&amp;show_byline=0&amp;show_portrait=0&amp;color=00ADEF&amp;fullscreen=1&amp;autoplay=0&amp;loop=0" width="425" height="360" allowFullScreen="true"  type="application/x-shockwave-flash"  wmode="transparent"></embed></object>',
       
        '/\[facebook]([A-Za-z0-9_]+)\[\/facebook\]/i' => '<object width="400" height="224" > <param name="allowfullscreen" value="true" /> <param name="allowscriptaccess" value="always" /> <param name="movie" value="http://www.facebook.com/v/$1" /> <embed src="http://www.facebook.com/v/$1" type="application/x-shockwave-flash"   allowscriptaccess="always" allowfullscreen="true" width="400" height="224"> </embed></object>',
	);
	foreach($video as $bbcode => $html_tag){
		$buffer = preg_replace($bbcode, $html_tag, $buffer);
	}
    return $buffer;
}

