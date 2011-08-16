<?php
//disallow direct access to the file
if (!defined('AEF')) {
    die('Hacking Attempt');
}

//plugin info
$plugin_info = array(
'Name' => 'test plugin',
'Version' => '1.0',
'Description' => 'changes version of the forum',
'Author' => 'SAFAD',
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
    $buffer = preg_replace('/Powered By AEF 1.1.0/', 'Powered By AEF 1.1 PLUGINEED', $buffer);
    return $buffer;
}

