//////////////////////////////////////////////////////////////
// Suggest.js
// By Electron, Ronak Gupta, Pulkit Gupta
// Please Read the Terms of use at http://www.anelectron.com
// (C)AEF Group All Rights Reserved.
// You cannot remove the copyrights.
//////////////////////////////////////////////////////////////

document.write('<div id="suggestbox" class="suggestbox"></div>');

sugdivid = 'suggestbox';

//Dont touch below
saindex = 0;
returned = new Array();

//Handles the key input
function handlesuggest(e, elid){
    pkey = ((window.event) ? window.event.keyCode : e.which);//alert(pkey);

    //The onkeydown event will handle certain things
    if(pkey == 9 || pkey == 13 || pkey == 27 || pkey == 38 || pkey == 40){
        return;
    }
    var qtxt;
    var tmp = $(elid).value;
    var tmp_r = tmp.split(';');
    //alert(tmp_r.length);
    //Is there even ';'
    if(tmp_r.length > 1){
        qtxt = trim(tmp_r[(tmp_r.length - 1)]);
    }else{
        qtxt = trim(tmp_r[0]);
    }
    if(!(qtxt.length > 0)){
        //No text
        hidesuggest();
        return;
    }
    //alert(qtxt);
    if(getAttributeByName($(elid), "suggesturl")){
        AJAX(getAttributeByName($(elid), "suggesturl")+'&q='+qtxt, 'handlesuggestresponse(\''+elid+'\',re)');
    }
};

function handlekeys(e){
    var hkey = ((window.event) ? window.event.keyCode : e.which);

    switch(hkey){
        //keydown
        case 40://alert('down');
            suggestmovedown();
            return;
        //keyup
        case 38://alert('up');
            suggestmoveup();
            return;
        //enter
        case 13:
            if(isvisible(sugdivid)){
                $('sa'+saindex).focus();
            }
            return;
        //tab
        case 9://alert('tab');
            hidesuggest();
            return;
        //escape
        case 27:
            hidesuggest();
            return;
        //Return because the onkeyupwill take care
        default:
            return;
    }
};


//This mill make the suggest table
function handlesuggestresponse(elid, r_txt){
    //alert(elid);
    //alert(r_txt);
    returned = eval(r_txt);
    if(returned == false){
        //alert('Nothing found');
        hidesuggest();//Nothing found
    }else{
        makesuggesttable(elid, sugdivid, returned);
    }
};

function makesuggesttable(elid, divid, r_returned){

    //On what are you
    saindex = 0;
    var pos = findelpos($(elid));
    $(divid).style.left = pos[0] + "px";
    $(divid).style.top =  (pos[1] + $(elid).offsetHeight) + "px";
    astr = '';
    //Insert the a tags
    for(x in r_returned){
        astr = astr + '<a href="javascript:insertsuggested(\''+r_returned[x]+'\', \''+elid+'\')" tabindex="10000" id="sa'+x+'" class="suga">'+r_returned[x]+'</a>';
    }
    //alert(astr);
    $(divid).innerHTML = astr;
    for(x in r_returned){
        $('sa'+x).className = 'suga';
        $('sa'+x).onmouseover = new Function("eval('saindex = "+x+";sugaon();')");
    }
    showel(divid);
    sugaon();//Well just to hightlight the first row
};

function insertsuggested(val, elid){
    //alert(value);
    var tmp = $(elid).value;
    var tmp_r = tmp.split(';');
    //Set the last value to ''
    tmp_r[(tmp_r.length - 1)] = '';
    //Just trim
    for(x in tmp_r){
        tmp_r[x] = trim(tmp_r[x]);
    }
    $(elid).value = tmp_r.join('; ')+val+'; ';
    $(elid).focus();
    hidesuggest();
};

function suggestmovedown(){
    if(returned.length > 0 && isvisible(sugdivid)){
        saindex++;
        if(typeof(returned[saindex]) == 'undefined'){
            saindex = 0;
        }
        sugaon();
    }
};

function suggestmoveup(){
    if(returned.length > 0 && isvisible(sugdivid)){
        saindex--;
        if(typeof(returned[saindex]) == 'undefined'){
            saindex = returned.length - 1;
        }
        sugaon();
    }
};

//Hides the suggest box
function hidesuggest(){
    hideel(sugdivid);
};

//Hightlight
function sugaon(){
    if(returned.length > 0 && isvisible(sugdivid)){
        for(x in returned){
            if(x != saindex){
                $('sa'+x).className = 'suga';
            }
        }

        $('sa'+saindex).className = 'sugaon';
    }
};