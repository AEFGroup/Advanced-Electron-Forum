<?php

if (!defined('AEF')) {
    die('Hacking Attempt');
}


//If a second Admin act is set then go by that
if (isset($_GET['seadact']) && trim($_GET['seadact']) !== "") {
    $seadact = trim($_GET['seadact']);
} else {
    $seadact = "";
}

//The switch handler
switch ($seadact) {

    //The form for editing a Category
    case 'editmod':
        editmod();
        break;

    //The form for creating a new Category
    case 'addmod':
        addmod();
        break;

    //The form for creating a new Category
    case 'delmod':
        delmod();
        break;

    default :
        manage_mod();
        modmanage_theme(); //from categories_theme.php

        break;
}//End of switch
?>