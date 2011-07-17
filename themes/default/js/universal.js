//////////////////////////////////////////////////////////////
// universal.js - Simple JS functions that make JS easy
// Inspired by Ronak and Pulkit
// ----------------------------------------------------------
// Please Read the Terms of use at http://www.anelectron.com
// ----------------------------------------------------------
// (c)Electron Inc.
//////////////////////////////////////////////////////////////

ua = navigator.userAgent.toLowerCase();
isIE = ((ua.indexOf("msie") != -1) && (ua.indexOf("opera") == -1) && (ua.indexOf("webtv") == -1));
isFF = (ua.indexOf("firefox") != -1);
isGecko = (ua.indexOf("gecko") != -1);
isSafari = (ua.indexOf("safari") != -1);
isKonqueror = (ua.indexOf("konqueror") != -1);

aefonload = '';

//Element referencer - We use $ because we love PHP
function $(id){
	//DOM
	if(document.getElementById){
		return document.getElementById(id);
	//IE
	}else if(document.all){
		return document.all[id];
	//NS4
	}else if(document.layers){
		return document.layers[id];
	}
};

//Trims a string
function trim(str){
	return str.replace(/^[\s]+|[\s]+$/, "");
};

//Give a random integer
function AEFrand(min, max){
	return Math.floor(Math.random() * (max - min + 1) + min);
};

//To clear a time out
function AEFclear(timer){
	clearTimeout(timer);
	clearInterval(timer);
	return null;
};

//Changes the opacity
function setopacity(el, opacity){
	el.style.opacity = (opacity/100);
	el.style.filter = 'alpha(opacity=' + opacity + ')';
};

//Hides an element
function hideel(elid){
	$(elid).style.visibility="hidden";
};

//Shows an element
function showel(elid){
	$(elid).style.visibility="visible";
};

function isvisible(elid){
	if($(elid).style.visibility == "visible"){
		return true;
	}else{
		return false;
	}
}

//Checkes the entire range of checkboxes
function check(field, checker){
	if(checker.checked == true){
		for(i = 0; i < field.length; i++){
			field[i].checked = true;
		}
	}else{
		for(i = 0; i < field.length; i++){  
			field[i].checked = false;
		}
	}
};
//The page width
function getwidth(){
	return document.body.clientWidth;
};
//The page height
function getheight(){
	return document.body.clientHeight;
};

//Get the scrolled height
function scrolledy(){
	//Netscape compliant
	if(typeof(window.pageYOffset) == 'number'){
		return window.pageYOffset;
	//DOM compliant
	}else if(document.body && document.body.scrollTop){
		return document.body.scrollTop;
	//IE6 standards compliant mode
	}else if(document.documentElement && typeof(document.documentElement.scrollTop)!='undefined'){
		return document.documentElement.scrollTop;
	}else{
		return 0;	
	}
};

//Gradually increases the opacity
function smoothopaque(elid, startop, endop, inc){
	if(typeof(elid) == 'object'){
		var el = elid;
	}else{
		var el = $(elid);
	}
	op = startop;
	//Initial opacity
	setopacity(el, op);
	//Start the opacity timeout that makes it more visible
	setTimeout(slowopacity, 1);
	function slowopacity(){
		if(startop < endop){
			op = op + inc;
			if(op < endop){
				setTimeout(slowopacity, 1);
			}
		}else{
			op = op - inc;
			if(op > endop){
				setTimeout(slowopacity, 1);
			}
		}
		setopacity(el, op);		
	};
};

//Cookie setter
function setcookie(name, value, duration){
	value = escape(value);
	if(duration){
		var date = new Date();
		date.setTime(date.getTime() + (duration * 86400000));
		value += "; expires=" + date.toGMTString();
	}
	document.cookie = name + "=" + value;
};

//Gets the cookie value
function getcookie(name){
	value = document.cookie.match('(?:^|;)\\s*'+name+'=([^;]*)');
	return value ? unescape(value[1]) : false;
};

//Removes the cookies
function removecookie(name){
	setcookie(name, '', -1);
};

function AJAX(url, evalthis){
	req = false;
	toeval = evalthis;
    // branch for native XMLHttpRequest object
    if(window.XMLHttpRequest){
    	try{
			req = new XMLHttpRequest();
        }catch(e){
			req = false;
        }
    // branch for IE/Windows ActiveX version
    }else if(window.ActiveXObject){
       	try{
	        req = new ActiveXObject("Msxml2.XMLHTTP");
      	}catch(e){
        	try{
          		req = new ActiveXObject("Microsoft.XMLHTTP");
        	}catch(e){
          		req = false;
        	}
		}
    }
	
	if(req){
		try{
			req.onreadystatechange = function(){				
    			// only if req shows "loaded"
				if (req.readyState==4) {
					//only if OK
					if (req.status == 200) {
						// only if "OK"...processing statements go here..
						var re = req.responseText // result of the req object
						if(re.length > 0){
							return eval(toeval);
						}else{
							return false;
						}
					}
				}
			};
			req.open("GET", url, true);
			req.send(null);
		}catch(e){
			return false;
		}
	}else{
		return false;
	}
	return true;
};

//Finds the position of the element
function findelpos(ele){
	var curleft = 0;
	var curtop = 0;
	if(ele.offsetParent){
		while(1){
			curleft += ele.offsetLeft;
			curtop += ele.offsetTop;
			if(!ele.offsetParent){
				break;
			}
			ele = ele.offsetParent;
		}
	}else if(ele.x){
		curleft += ele.x;
		curtop += ele.y;
	}
	return [curleft,curtop];
};

function getAttributeByName(node, attribute){
	if(typeof NamedNodeMap != "undefined"){
		if(node.attributes.getNamedItem(attribute)){
			return node.attributes.getNamedItem(attribute).value;
		}
	}else{
		return node.getAttribute(attribute);
	}
};

//With ';'
function addonload(js){
	aefonload += js;
};

function createdw(id, content, classname, dwtitle){
	//Is this ID already created
	try{ $(id).innerHTML; return false;}catch(e){ };
	var dw = document.createElement("div");
	dw.id = id;
	dw.className = classname ? classname : "pqr";
	dw.innerHTML = '<table width="100%" cellspacing="0" cellpadding="0" id="'+id+'handle"><tr><td class="dwhl"></td><td align="left" class="dwhc"><b>'+dwtitle+'</b></td><td align="right" class="dwhc"><a href="javascript:hideel(\''+id+'\')"><img src="'+imgurl+'close.gif" alt="" /></a></td><td class="dwhr"></td></tr></table><table width="100%" cellspacing="0" cellpadding="0" class="dwbody"><tr><td>'+content+'</td></tr><tr><td align="left" class="dwb" colspan="2"></td></tr></table>';
	document.body.appendChild(dw);
	Drag.init($(id+'handle'), $(id));
};

function showdw(id){
	$(id).style.left=((getwidth()/2)-($(id).offsetWidth/2))+"px";
	$(id).style.top=(scrolledy()+110)+"px";
	showel(id);
	smoothopaque(id, 0, 100, 10);
};

function domwindow(id, content, classname, dwtitle){
	createdw(id, content, classname, dwtitle);
	showdw(id);
};