<?php

//////////////////////////////////////////////////////////////
//===========================================================
// categories.php
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

function categories() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;

    if (!load_lang('admin/categories')) {

        return false;
    }

    //The name of the file
    $theme['init_theme'] = 'admin/categories';

    //The name of the Page
    $theme['init_theme_name'] = 'Admin Center - Manage Categories';

    //Array of functions to initialize
    $theme['init_theme_func'] = array('cat_global',
        'editcat_theme',
        'catmanage_theme',
        'createcat_theme',
        'catreorder_theme');

    //My activity
    $globals['last_activity'] = 'ac';


    //If a second Admin act is set then go by that
    if (isset($_GET['seadact']) && trim($_GET['seadact']) !== "") {

        $seadact = inputsec(htmlizer(trim($_GET['seadact'])));
    } else {

        $seadact = "";
    }

    //The switch handler
    switch ($seadact) {

        //The form for editing a Category
        case 'editcat':
            editcat();
            break;

        //The form for creating a new Category
        case 'createcat':
            createcat();
            break;

        default :
            if (!default_of_nor(false, false)) {

                return false;
            }
            $theme['call_theme_func'] = 'catmanage_theme';
            break;


        //The form for reordering categories
        case 'catreorder':
            catreorder();
            break;

        //Delete categories
        case 'delcat':
            delcat();
            break;
    }
}

function editcat() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
    global $categories, $editcat, $orderoptions, $error, $editcategory;


    /////////////////////////////
    // Define the necessary VARS
    /////////////////////////////

    $editcat = 0;

    $orderoptions = array();

    $error = array();

    $catorder = 0;

    $catname = '';

    $catcollapse = 0;

    $order = array();


    if (isset($_GET['editcat']) && trim($_GET['editcat']) !== "" && is_numeric(trim($_GET['editcat']))) {

        $editcat = (int) inputsec(htmlizer(trim($_GET['editcat'])));
    } else {

        //Show a major error and return
        reporterror($l['no_cat_specified'], $l['no_cat_specified_exp']);

        return false;
    }

    if (!default_of_nor(false, false)) {

        return false;
    }

    //This is to find which category is to be edited
    foreach ($categories as $c => $v) {

        if ($categories[$c]['cid'] == $editcat) {

            $editcategory = $categories[$c];
        }

        //Also build the order array
        $order[$c] = $categories[$c]['order'];
    }


    //Did we find any category
    if (empty($editcategory)) {

        //Show a major error and return
        reporterror($l['no_cat_found'], $l['no_cat_found_exp']);

        return false;
    }


    //Find the order and make the array
    for ($o = 1; $o <= count($categories); $o++) {

        if ($editcategory['order'] == $o) {

            $is_default = 'selected';
        } else {

            $is_default = '';
        }

        //The option adder
        $orderoptions[] = '<option value="' . $o . '" ' . $is_default . '>' . $o . '</option>';
    }


    //Someone has posted it
    if (isset($_POST['edit_cat'])) {

        //Check the catorder
        if (!isset($_POST['catorder']) || trim($_POST['catorder']) == "" ||
                !is_numeric(trim($_POST['catorder']))) {

            $error[] = $l['cat_order_missing'];
        } else {

            $catorder = (int) inputsec(htmlizer(trim($_POST['catorder'])));

            if ($catorder > count($categories)) {

                $error[] = $l['cat_order_invalid'];
            }
        }

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'editcat_theme';
            return false;
        }


        //Check the catname
        if (!isset($_POST['catname']) || trim($_POST['catname']) == "") {

            $error[] = $l['no_name_specified'];
        } else {

            $catname = inputsec(htmlizer(trim($_POST['catname'])));
        }

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'editcat_theme';
            return false;
        }

        //Checking the catcollapse
        if (isset($_POST['catcollapse'])) {

            $catcollapse = 1;
        }

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'editcat_theme';
            return false;
        }


        ////////////////////////////////////
        // Finally lets UPDATE the Category
        ////////////////////////////////////

        $qresult = makequery("UPDATE " . $dbtables['categories'] . "
                    SET name = '$catname',
                    `order` = '$catorder',
                    collapsable = '$catcollapse'
                    WHERE cid = '$editcat'", false);

        if (mysql_affected_rows($conn) < 1) {

            reporterror($l['edit_cat_error'], $l['errors_updating'] . ' <b>' . $editcategory['name'] . '</b>.');

            return false;
        }


        /////////////////////////////////////
        // Lets Calculate the orders that are
        // to be changed of other categories
        // if this order is changed.
        /////////////////////////////////////
        //If ORDER of Category to be edited is not same as POSTED Order
        if ($editcategory['order'] != $catorder) {

            //If POSTED Catorder is GREATER than the actual original
            if ($catorder > $editcategory['order']) {

                $looper = $catorder;

                //A for loop to reorder the rest
                for ($o = ($editcategory['order'] + 1); $o <= $looper; $o++) {

                    $ordercid = array_search($o, $order);

                    $qresult = makequery("UPDATE " . $dbtables['categories'] . "
                            SET `order` = `order` - 1
                            WHERE cid = '$ordercid'", false);

                    if (mysql_affected_rows($conn) < 1) {

                        reporterror($l['edit_cat_error'], $l['errors_updating_orders']);

                        return false;
                    }
                }

                //If POSTED Catorder is LESS than the actual original
            } elseif ($catorder < $editcategory['order']) {

                $looper = $editcategory['order'];

                //A for loop to reorder the rest
                for ($o = $catorder; $o < $looper; $o++) {

                    $ordercid = array_search($o, $order);

                    $qresult = makequery("UPDATE " . $dbtables['categories'] . "
                            SET `order` = `order` + 1
                            WHERE cid = '$ordercid'", false);

                    if (mysql_affected_rows($conn) < 1) {

                        reporterror($l['edit_cat_error'], $l['errors_updating_orders']);

                        return false;
                    }
                }
            }
        }

        //Redirect
        redirect('act=admin&adact=categories');

        return true;
    } else {

        //Calling the theme file
        $theme['call_theme_func'] = 'editcat_theme';
    }
}

//End of function

function createcat() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
    global $categories, $orderoptions, $error;


    /////////////////////////////
    // Define the necessary VARS
    /////////////////////////////

    $orderoptions = array();

    $error = array();

    $catorder = 0;

    $catname = '';

    $catcollapse = 0;

    $order = array();

    $newcatid = 0;

    if (!default_of_nor(false, false)) {

        return false;
    }


    $default = (count($categories) + 1);


    //This is to build the order array
    foreach ($categories as $c => $v) {

        $order[$c] = $categories[$c]['order'];
    }


    //Find the order and make the array
    for ($o = 1; $o <= (count($categories) + 1); $o++) {

        if ((count($categories) + 1) == $o) {

            $is_default = 'selected';
        } else {

            $is_default = '';
        }

        //The option adder
        $orderoptions[] = '<option value="' . $o . '" ' . $is_default . '>' . $o . '</option>';
    }


    if (isset($_POST['createcat'])) {

        //Check the catorder
        if (!isset($_POST['catorder']) || trim($_POST['catorder']) == "" ||
                !is_numeric(trim($_POST['catorder']))) {

            $error[] = $l['cat_order_missing'];
        } else {

            $catorder = (int) inputsec(htmlizer(trim($_POST['catorder'])));

            if ($catorder > $default) {

                $error[] = $l['cat_order_invalid'];
            }
        }

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'createcat_theme';
            return false;
        }


        //Check the catname
        if (!isset($_POST['catname']) || trim($_POST['catname']) == "") {

            $error[] = $l['no_name_specified'];
        } else {

            $catname = inputsec(htmlizer(trim($_POST['catname'])));
        }

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'createcat_theme';
            return false;
        }

        //Checking the catcollapse
        if (isset($_POST['catcollapse'])) {

            $catcollapse = 1;
        }

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'createcat_theme';
            return false;
        }



        ////////////////////////////////////
        // Finally lets INSERT the Category
        ////////////////////////////////////

        $qresult = makequery("INSERT INTO " . $dbtables['categories'] . "
                    SET name = '$catname',
                    `order` = '$catorder',
                    collapsable = '$catcollapse'");

        $newcatid = mysql_insert_id($conn);

        if (empty($newcatid)) {

            reporterror($l['new_cat_error'], $l['no_insert_new']);

            return false;
        }


        $categories[$newcatid] = array('cid' => $newcatid,
            'name' => $catname,
            'order' => $default,
            'collapsable' => $catcollapse);



        /////////////////////////////////////
        // Lets Calculate the orders that are
        // to be changed of other categories
        // if this order is changed.
        /////////////////////////////////////
        //If ORDER of Category to be edited is not same as POSTED Order
        if ($catorder != $default) {

            //If POSTED Catorder is GREATER than the actual original
            if ($catorder < $default) {

                $looper = $default;

                //A for loop to reorder the rest
                for ($o = $catorder; $o < $looper; $o++) {

                    $ordercid = array_search($o, $order);

                    $qresult = makequery("UPDATE " . $dbtables['categories'] . "
                            SET `order` = `order` + 1
                            WHERE cid = '$ordercid'", false);

                    if (mysql_affected_rows($conn) < 1) {

                        reporterror($l['new_cat_error'], $l['errors_updating_orders']);

                        return false;
                    }
                }
            }
        }


        //Redirect
        redirect('act=admin&adact=categories');

        return true;
    } else {

        //Calling the theme file
        $theme['call_theme_func'] = 'createcat_theme';
    }
}

//End of function createcat

function delcat() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;

    if (isset($_GET['cid']) && trim($_GET['cid']) !== "" && is_numeric(trim($_GET['cid']))) {

        $cid = (int) inputsec(htmlizer(trim($_GET['cid'])));
    } else {

        //Show a major error and return
        reporterror($l['no_cat_specified'], $l['no_del_cat_specified']);

        return false;
    }

    if (!delete_categories(array($cid))) {

        //Show a major error and return
        reporterror($l['delete_cat_error'], $l['errors_deleting']);

        return false;
    }

    //Redirect
    redirect('act=admin&adact=categories');

    return true;
}

//Function to reorder the smileys
function catreorder() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
    global $categories, $error;

    /////////////////////////////
    // Define the necessary VARS
    /////////////////////////////

    $error = array();

    $catreordered = array();


    if (!default_of_nor(false, false)) {

        return false;
    }


    if (isset($_POST['catreorder'])) {

        //Check the code
        if (empty($_POST['cat']) || !is_array($_POST['cat'])) {

            $error[] = $l['no_category_order'];
        } else {

            $catreordered = $_POST['cat'];

            if (count($catreordered) != count($categories)) {

                $error[] = $l['number_cat_order_incorrect'];
            }
        }

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'catreorder_theme';
            return false;
        }

        foreach ($catreordered as $k => $v) {

            //Was every key correct
            if (!in_array($k, array_keys($categories))) {

                $error[] = $l['some_invalid'];

                break;
            }

            $catreordered[$k] = (int) $v;
        }

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'catreorder_theme';
            return false;
        }


        if (count(array_unique($catreordered)) != count($categories)) {

            $error[] = $l['cat_order_incorrect'];
        }


        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'catreorder_theme';
            return false;
        }

        //r_print($catreordered);

        foreach ($catreordered as $k => $v) {

            $qresult = makequery("UPDATE " . $dbtables['categories'] . "
                        SET `order` = '$v'
                        WHERE cid = '$k'", false);
        }

        //Redirect
        redirect('act=admin&adact=categories');

        return true;
    } else {

        $theme['call_theme_func'] = 'catreorder_theme';
    }
}
