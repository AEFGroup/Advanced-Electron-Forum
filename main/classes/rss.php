<?php

//////////////////////////////////////////////////////////////
//===========================================================
// rss.php(classes)
//===========================================================
// AEF : Advanced Electron Forum
// Version : 1.0.10
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

/**
 * A basic class that provides various RSS features and helpers
 * @author Various previous
 * @author Cruz Bishop - Refactoring and upgrade to RSS 2.0
 */
class rss {

    /**
     * Inserts the RSS header
     * @param string $xmlVersion The XML version to use
     * @param string $encoding The character encoding to use
     * @param string $rssVersion The RSS version to use
     * @param string $title The title to use
     * @param string $link The link to use
     * @param string $desc The description (AKA content) to use
     * @return string A string containing the RSS header
     */
    function start($xmlVersion = '1.0', $encoding = 'UTF-8', $rssVersion = '2.0', $title = '', $link = '', $desc = '') {
        global $globals;
        header('Content-Type: application/rss+xml; charset=' . $encoding);
        return '<?xml version="' . $xmlVersion . '" encoding="' . $encoding . '"?>
<rss version="' . $rssVersion . '" xml:lang="en-US">
    <channel>
        <title>' . $title . '</title>
        <link>' . $link . '</link>
        <description>' . $desc . '</description>
        <generator>Advanced Electron Forums ' . $globals['version'] . '</generator';
    }

    /**
     * Closes the RSS feed
     * @return string The footer
     */
    function close() {

        return '
    </channel>
</rss>';
    }

    /**
     * Creates an item part of a RSS feed
     * @param string $title The title to use
     * @param string $link The link to use
     * @param string $desc The description (AKA content) to use
     * @param string $category The category to use
     * @param string $pubDate The published date to use
     * @return string The item part of the feed as a string
     */
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
