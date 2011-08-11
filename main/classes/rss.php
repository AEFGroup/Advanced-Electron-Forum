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
    function start($xmlVersion = '1.0', $encoding = 'UTF-8', $rssVersion = '2.0', $title = '', $link = '', $desc = '') {

        $str = '<?xml version="' . $xmlVersion . '" encoding="' . $encoding . '"?>
<rss version="' . $rssVersion . '" xml:lang="en-US">
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
            <title>' . $title . '</title>
            <link>' . $link . '</link>
            <description><![CDATA[' . $desc . ']]></description>
            <category><![CDATA[' . $category . ']]></category>
            <pubDate>' . $pubDate . '</pubDate>
            <guid>' . $link . '</guid>
        </item>';
    }

}

?>
