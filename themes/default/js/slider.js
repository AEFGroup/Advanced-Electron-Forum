//////////////////////////////////////////////////////////////
// js_slider
// By Electron, Ronak Gupta, Pulkit Gupta
// Please Read the Terms of use at http://www.anelectron.com
// (C)AEF Group All Rights Reserved.
//////////////////////////////////////////////////////////////

function slideitout(elid, endheight, inc, time){
    startheight = $(elid).offsetHeight;
    setTimeout(startsliding, time);
    function startsliding(){
        startheight = startheight + inc;
        if(startheight < endheight){
            diff = endheight - startheight;
            if(diff > inc){
                $(elid).style.height = startheight+"px";
                setTimeout(startsliding, time);
            }else{
                $(elid).style.height = endheight+"px"
            }
        }
    };
};

function pullitin(elid, dec, time){
    height = $(elid).offsetHeight;
    setTimeout(startsliding, time);
    function startsliding(){
        height = height - dec;
        if(height > 1){
            if(height > dec){
                $(elid).style.height = height+"px";
                setTimeout(startsliding, time);
            }else{
                $(elid).style.height = "1px";//A bug in IE 5.5
            }
        }
    };
};

function slider(){
    this.speed = 20;
    this.img_collapsed = imgurl+'collapsed.gif';
    this.img_expanded = imgurl+'expanded.gif';
    this.elements = new Array();

    this.slide = function(id){
        var height = $(id).offsetHeight;
        if(height > 1){
            pullitin(id, this.speed, 1);
            $('i'+id).src = this.img_collapsed;
            setcookie(id, '1', 365);
        }else{
            slideitout(id, $('t'+id).offsetHeight, this.speed, 1);
            $('i'+id).src = this.img_expanded;
            removecookie(id);
        }
    };

    //Init it
    this.init = function(){
        var elements = this.elements;
        for(id in elements){
            if(getcookie(elements[id]) == 1){
                $(elements[id]).style.height = "1px";
                $('i'+elements[id]).src = this.img_collapsed;
            }
        }
    };
};