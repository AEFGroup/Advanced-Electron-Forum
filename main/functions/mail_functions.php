<?php

//////////////////////////////////////////////////////////////
//===========================================================
// mail_functions.php(functions)
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

function aefmail_fn($array) {

    global $user, $globals, $theme, $conn, $dbtables;

    if ($globals['mail']) {

        //Count and loop
        for ($i = 0; $i < count($array); $i++) {

            if (isset($array[$i]['headers'])) {

                $headers = $array[$i]['headers'];
            } else {

                $headers = 'From: ' . $globals['sn'] . " <" . $globals['board_email'] . ">\r\n" .
                        'Reply-To: ' . $globals['board_email'] . "\r\n" .
                        'X-Mailer: PHP/' . phpversion();
            }

            //If BCC headers are set
            if (!empty($array[$i]['bcc'])) {

                $headers .= "\r\nBcc: " . implode(', ', $array[$i]['bcc']) . "\r\n";
            }

            if (!@mail($array[$i]['to'], $array[$i]['subject'], $array[$i]['message'], $headers)) {

                return false;
            }
        }
    } else {

        return aefsmtp($array);
    }

    return true;
}

// AEF's SMTP Mail Function
function aefsmtp($array) {

    global $user, $globals, $theme, $conn, $dbtables;

    $smtpser = $globals['mail_server'];

    $port = $globals['mail_port'];

    // Open an SMTP connection
    $cp = @fsockopen($smtpser, $port);

    if (!$cp) {

        return "Failed to even make a connection";
    }

    $res = fgets($cp, 256); //echo $res.'<br />';

    if (substr($res, 0, 3) != "220") {

        return "Failed to connect";
    }

    // Say hello...
    fputs($cp, "HELO " . $smtpser . "\r\n");

    $res = fgets($cp, 256); //echo $res.'<br />';

    if (substr($res, 0, 3) != "250") {

        return "Failed to Introduce";
    }

    // perform authentication
    fputs($cp, "auth login\r\n");

    $res = fgets($cp, 256); //echo $res.'<br />';

    if (substr($res, 0, 3) != "334") {

        return "Failed to Initiate Authentication";
    }

    fputs($cp, base64_encode($globals['mail_user']) . "\r\n");

    $res = fgets($cp, 256); //echo $res.'<br />';

    if (substr($res, 0, 3) != "334") {

        return "Failed to Provide Username for Authentication";
    }

    fputs($cp, base64_encode($globals['mail_pass']) . "\r\n");

    $res = fgets($cp, 256); //echo $res.'<br />';

    if (substr($res, 0, 3) != "235") {

        return "Failed to Authenticate";
    }

    ///////////////////////////////////
    // Connection Established lets mail
    ///////////////////////////////////

    foreach ($array as $i => $v) {

        // Mail from...
        fputs($cp, "MAIL FROM: <" . $globals['board_email'] . ">\r\n");

        $res = fgets($cp, 256); //echo $res.'<br />';

        if (substr($res, 0, 3) != "250") {

            return "MAIL FROM failed";
        }

        // Rcpt to...
        fputs($cp, "RCPT TO: <" . $array[$i]['to'] . ">\r\n");

        $res = fgets($cp, 256); //echo $res.'<br />';

        if (substr($res, 0, 3) != "250") {

            return "RCPT TO failed";
        }

        if (!empty($array[$i]['bcc'])) {

            foreach ($array[$i]['bcc'] as $bcc) {

                // Rcpt to...(BCC)
                fputs($cp, "RCPT TO: <" . $bcc . ">\r\n");

                $res = fgets($cp, 256); //echo $res.'<br />';

                if (substr($res, 0, 3) != "250") {

                    return "BCC failed";
                }
            }
        }

        // Data...
        fputs($cp, "DATA\r\n");

        $res = fgets($cp, 256); //echo $res.'<br />';

        if (substr($res, 0, 3) != "354") {

            return "DATA failed";
        }


        if (isset($array[$i]['headers'])) {

            $headers = $array[$i]['headers'];
        } else {

            $headers = 'From: ' . $globals['sn'] . " <" . $globals['board_email'] . ">\r\n" .
                    'Reply-To: ' . $globals['board_email'] . "\r\n" .
                    'X-Mailer: AEF PHP/' . phpversion();
        }

        // Send To:, From:, Subject:, other headers, blank line, message, and finish
        // with a period on its own line (for end of message)

        fputs($cp, "To: " . $array[$i]['to'] . "\r\nSubject: " . $array[$i]['subject'] . "\r\n$headers\r\n\r\n" . $array[$i]['message'] . "\r\n.\r\n");

        $res = fgets($cp, 256); //echo $res.'<br />';

        if (substr($res, 0, 3) != "250") {

            return "Message Body Failed. Error :" . $res;
        }
    }

    // ...And time to quit...
    fputs($cp, "QUIT\r\n");

    $res = fgets($cp, 256); //echo $res.'<br />';

    if (substr($res, 0, 3) != "221") {

        return "QUIT failed";
    }

    return true;
}

?>