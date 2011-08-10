//////////////////////////////////////////////////////////////
// js_shoutbox
// By Electron, Ronak Gupta, Pulkit Gupta
// Please Read the Terms of use at http://www.anelectron.com
// (C)AEF Group All Rights Reserved.
//////////////////////////////////////////////////////////////

last_shoutid = -1;

shbid = 'shoutbox';//Shout Box id

shbcontainer = 'shbcontainer';//The container of shouts only

shbimgcollapser = 'shbimgcollapser';//The image that collapses or opens the shoutbox

shout_totimeout = 20000;//the time it should take to timeout

can_del_shout = false;//By default false

function show_shoutbox(){
    if(!isvisible(shbid)){
        shout_totimeout = 20000;
        load_shouts();//Load the shout box
        $(shbid).style.left=((getwidth()/2)-($(shbid).offsetWidth/2))+"px";
        $(shbid).style.top=(scrolledy()+110)+"px";
        showel(shbid);
        smoothopaque(shbid, 0, 100, 10);
    }
}

//Hides the floating shoutbox
function hide_shoutbox(){
    hideel(shbid);
    clearTimeout(shouttimeout);
}

//When the shout box is fixed call this instead of show_shoutbox()
function init_fixedshoutbox(){
    //Its hidden so lets hide on initializing
    if(getcookie(shbcontainer) == 1){
        hide_fixedshoutbox();//Hide the SHB
    //Start the AJAXification
    }else{
        shout_totimeout = 20000;
        load_shouts();//Load the shout box
    }
}

//Hides or shows the fixed shoutbox
function hideshow_fixedshoutbox(){
    //Its hidden so show
    if(getcookie(shbcontainer) == 1){
        show_fixedshoutbox();//Show the SHB
        removecookie(shbcontainer);//Remove the cookie
        init_fixedshoutbox();//Initiaize the box
    //Its open so close
    }else{
        hide_fixedshoutbox();//Hide the SHB
        setcookie(shbcontainer, '1', 365);//Set a cookie
        clearTimeout(shouttimeout);//Clear the timeout
    }
}

//Just hides the fixed shoutbox
function hide_fixedshoutbox(){
    $(shbcontainer).style.display = "none";//Hide the box
    $(shbimgcollapser).src = imgurl+'collapsed.gif';
}

//Just shows the fixed shoutbox
function show_fixedshoutbox(){
    $(shbcontainer).style.display = "block";//Show the box
    $(shbimgcollapser).src = imgurl+'expanded.gif';
}

function load_shouts(){
    AJAX(indexurl+'act=shoutbox&last='+last_shoutid, 'handleshoutresponse(re)');
}

function handleshoutresponse(resp_txt){
    var shouts = eval(resp_txt);
    if(shouts == false){
        shouttimeout = setTimeout('load_shouts()', shout_totimeout);
        return false;
    }
    //Ok add the new shouts
    var shout = '';
    for(x in shouts){
        last_shoutid = shouts[x][0];
        shout = '<div class="shout" id="aefshid'+shouts[x][0]+'">'+((can_del_shout) ? '<a href="javascript:deleteshout('+shouts[x][0]+');"><img src="'+imgurl+'deleteshout.png" alt="Delete Shout" /></a>&nbsp;' : '')+'('+shouts[x][1]+')&nbsp;&nbsp;<a href="'+indexurl+'mid='+shouts[x][2]+'">'+shouts[x][3]+'</a>&nbsp;&nbsp;:&nbsp;'+shouts[x][4]+'</div>' + shout;
    }
    $('shouts').innerHTML = shout + $('shouts').innerHTML;
    shouttimeout = setTimeout('load_shouts()', shout_totimeout);
    return true;
}

function shout(){
    var theshout = $('addshout').value;
    theshout = theshout.replace(/&/gi, '%26');//& - Causes problems
    $('addshout').value = '';
    if(theshout == ''){
        return false;
    }
    clearTimeout(shouttimeout);
    shout_totimeout = 5000;
    $('addshoutbut').disabled = true;
    AJAX(indexurl+'&act=shoutbox&shoutact=addshout&shout='+theshout, 'addshoutresponse(re)');
    return true;
}

function addshoutresponse(addedshout){
    var response = eval(addedshout);
    $('addshoutbut').disabled = false;
    load_shouts();
}


function deleteshout(num_id){
    AJAX(indexurl+'act=shoutbox&shoutact=deleteshout&shoutid='+num_id, 'delshoutresponse('+num_id+', re)');
}

function delshoutresponse(id, delresp){
    var response = eval(delresp);
    if(response){
        $('aefshid'+id).style.display = "none";
    }
}

function handleshoutkeys(e){
    var hkey = ((window.event) ? window.event.keyCode : e.which);
    //Handle the Enter key
    if(hkey == 13){
        shout();
    }
}

function reloadshoutbox(){
    clearTimeout(shouttimeout);//Very important
    last_shoutid = -1;
    $('shouts').innerHTML = '';
    load_shouts();//Load the shouts
}