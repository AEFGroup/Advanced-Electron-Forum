<?php

//////////////////////////////////////////////////////////////
//===========================================================
// rss.php(classes)
//===========================================================
// AEF : Advanced Electron Forum
// Version : 1.0.9
// Inspired by Pulkit and taken over by Electron
// ----------------------------------------------------------
// Started by: Electron, Ronak Gupta, Pulkit Gupta
// Date:       23rd Jan 2006
// Time:       15:00 hrs
// Site:       http://www.anelectron.com/ (Anelectron)
// ----------------------------------------------------------
// Please Read the Terms of use at http://www.anelectron.com
// ----------------------------------------------------------
//===========================================================
// (C)AEF Group All Rights Reserved.
//===========================================================
//////////////////////////////////////////////////////////////

if (!defined('AEF')) {

    die('Hacking Attempt');
}

class rss {

    //The Heading of the RSS
    function start($ver = '1.0', $enc = 'UTF-8', $rss_ver = '0.92', $title = '', $link = '', $desc = '') {

        $str = '<?xml version="' . $ver . '" encoding="' . $enc . '"?>
<rss version="' . $rss_ver . '" xml:lang="en-US">
    <channel>
        <title>' . $title . '</title>
        <link>' . $link . '</link>
        <description><![CDATA[' . $desc . ']]></description>';

        return $str;
    }

    //The end
    function close() {

        $str = '
    </channel>
</rss>';

        return $str;
    }

    //Add an ITEM
    function item($title, $link, $desc, $category, $pubDate) {

        return '
        <item>
            <title><![CDATA[' . $title . ']]></title>
            <link>' . $link . '</link>
            <description><![CDATA[' . $desc . ']]></description>
            <category><![CDATA[' . $category . ']]></category>
            <pubDate>' . $pubDate . '</pubDate>
            <guid>' . $link . '</guid>
        </item>';
    }

}

?>
