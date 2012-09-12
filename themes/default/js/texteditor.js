//////////////////////////////////////////////////////////////
// AEF Texteditor
// By Pulkit Gupta
// Please Read the Terms of use at http://www.anelectron.com
// (C)AEF Group All Rights Reserved.
// You can use this script only if you let this copyright be
// here and link bact to http://www.anelectron.com from the 
// page that uses this.
//////////////////////////////////////////////////////////////

function aef_editor(){
    this.wysiwyg_id='aefwysiwyg';
    this.textarea_id='post';
    this.text='';
    this.on=false;
    this.flashw=200;
    this.flashh=200;
    this.toggle=function(){
        if(this.on){
            this.to_normal()
        }else{
            this.to_wysiwyg()
        }
    };
    
    this.onsubmit=function(){
        if(this.on){
            return this.to_normal(false)
        }
    };

    this.to_wysiwyg=function(dontalert){
        var pos=findelpos($(this.textarea_id));
        if(!document.getElementById||!document.designMode){
            if(dontalert!=true){
                alert('Your Browser does not support WYSIWYG.')
            }
            return false
        }
        $(this.wysiwyg_id).style.left=pos[0]+'px';
        $(this.wysiwyg_id).style.top=pos[1]+'px';
        hideel(this.textarea_id);
        showel(this.wysiwyg_id);
        this.wysiwyg=$(this.wysiwyg_id).contentWindow.document;
        this.wysiwyg.open();
        this.wysiwyg.write('<html><head><style>p{margin: 1px; padding: 0px;} img{border: 0px solid #000000;vertical-align: middle;}</style></head><body style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;"></body></html>');
        this.wysiwyg.close();
        if(this.wysiwyg.body.contentEditable){
            this.wysiwyg.body.contentEditable=true
        }else{
            this.wysiwyg.designMode='On'
        }
        this.wysiwyg.body.innerHTML=bbc_html($(this.textarea_id).value);
        this.on=true;
        return true
    };
    
    this.to_normal=function(tryfocus){
        hideel(this.wysiwyg_id);
        showel(this.textarea_id);
        $(this.textarea_id).value=html_bbc(this.wysiwyg.body.innerHTML);
        this.wysiwyg.body.innerHTML='';
        this.on=false;
        if(tryfocus!=false){
            $(this.textarea_id).focus()
        }
        return true
    };
    
    this.format=function(tag){
        if(tag=='[b]'){
            this.exec('Bold',false,null)
        }else if(tag=='[i]'){
            this.exec('Italic',false,null)
        }else if(tag=='[u]'){
            this.exec('Underline',false,null)
        }else if(tag=='[s]'){
            this.exec('Strikethrough',false,null)
        }else if(tag=='[left]'){
            this.exec('Justifyleft',false,null)
        }else if(tag=='[center]'){
            this.exec('Justifycenter',false,null)
        }else if(tag=='[right]'){
            this.exec('Justifyright',false,null)
        }else if(/\[size=(\d){1}\]/.test(tag)){
            this.exec('FontSize',false,RegExp.$1)
        }else if(/\[font=(.+)\]/.test(tag)){
            this.exec('FontName',false,RegExp.$1)
        }else if(/\[color=(\#.{6})\]/.test(tag)){
            this.exec('ForeColor',false,RegExp.$1)
        }else if(tag=='[img]'){
            var img=prompt("Please enter the URL of the image","http://");
            if(img){
                this.exec('InsertImage',false,img)
            }
        }else if(/\[flash=([0-9]+),([0-9]+)\]/.test(tag)){
            this.wrap(tag,'[/flash]')
        }else if(tag=='[ol]\n[li][/li]\n'){
            this.exec('InsertOrderedList',false,null)
        }else if(tag=='[ul]\n[li][/li]\n'){
            this.exec('InsertUnorderedList',false,null)
        }else if(tag=='[li]'){}else if(tag=='[sup]'){
            this.exec('Superscript',false,null)
        }else if(tag=='[sub]'){
            this.exec('Subscript',false,null)
        }else if(tag=='[hr]'){
            this.exec('InsertHorizontalRule',false,null)
        }else if(tag=='[quote]'){
            this.wrap('[quote]','[/quote]')
        }else if(tag=='[code]'){
            this.wrap('[code]','[/code]')
        }else if(tag=='[php]'){
            this.wrap('[php]','[/php]')
        }
    };

    this.insertemot=function(emotcode,url){
        $(this.wysiwyg_id).contentWindow.focus();
        this.wrap('&nbsp;<img src="'+url+'">&nbsp;','',true)
    };
    
    this.exec=function(command,ui,value){
        $(this.wysiwyg_id).contentWindow.focus();
        this.wysiwyg.execCommand(command,ui,value)
    };
    
    this.wrap=function(starttag,endtag,replace){
        var doc=$(this.wysiwyg_id).contentWindow;
        doc.focus();
        if(window.ActiveXObject){
            var txt=starttag+((replace==true)?'':this.wysiwyg.selection.createRange().text)+endtag;
            this.wysiwyg.selection.createRange().pasteHTML(txt)
        }else{
            var txt=starttag+((replace==true)?'':$(this.wysiwyg_id).contentWindow.getSelection())+endtag;
            this.exec('insertHTML',false,txt)
        }
    };

    this.insertlink=function(url){
        var txt;
        if(!url){
            return
        }
        if(window.ActiveXObject){
            txt=this.wysiwyg.selection.createRange().text
        }else{
            txt=$(this.wysiwyg_id).contentWindow.getSelection()
        }
        if(txt.toString().length!=0){
            try{
                this.exec('Unlink',false,null);
                this.exec('CreateLink',false,url)
            }catch(e){}
        }else{
            this.wrap('<a href="'+url+'">'+url,'</a>')
        }
    };

    this.wrap_bbc=function(starttag,endtag){
        if(this.on){
            this.format(starttag);
            return
        }
        var field=$(this.textarea_id);
        if(typeof(field.caretPos)!="undefined"&&field.createTextRange){
            field.focus();
            var sel=field.caretPos;
            var tmp_len=sel.text.length;
            sel.text=sel.text.charAt(sel.text.length-1)==' '?starttag+sel.text+endtag+' ':starttag+sel.text+endtag;
            if(tmp_len==0){
                sel.moveStart("character",-endtag.length);
                sel.moveEnd("character",-endtag.length);
                sel.select()
            }else{
                field.focus(sel)
            }
        }else if(field.selectionStart||field.selectionStart=='0'){
            var startPos=field.selectionStart;
            var endPos=field.selectionEnd;
            field.value=field.value.substring(0,startPos)+starttag+field.value.substring(startPos,endPos)+endtag+field.value.substring(endPos,field.value.length)
        }else{
            field.value+=starttag+endtag;
            field.focus(field.value.length-1)
        }
    };

    this.insertemot_code=function(emotcode,url){
        if(this.on){
            this.insertemot(emotcode,url);
            return
        }
        emotcode=' '+emotcode+' ';
        var field=$(this.textarea_id);
        if(typeof(field.caretPos)!="undefined"&&field.createTextRange){
            var sel=field.caretPos;
            var tmp_len=sel.text.length;
            sel.text=sel.text.charAt(sel.text.length-1)==' '?emotcode+' ':emotcode;
            field.focus(sel)
        }else if(field.selectionStart||field.selectionStart=='0'){
            var startPos=field.selectionStart;
            var endPos=field.selectionEnd;
            field.value=field.value.substring(0,startPos)+emotcode+field.value.substring(endPos,field.value.length)
        }else{
            field.value+=emotcode
        }
    }
}

function html_bbc(text){
    opened_tags=new Array();
    x=0;
    text=text.replace(/<br(?=[ \/>]).*?>/gi,"\r\n");
    text=text.replace(/<hr(?=[ \/>]).*?>/gi,'[hr]');
    text=text.replace(/<img.*?src=(["'])(.+?)\1.*?>/gi,'[img]$2[/img]');
    text=text.replace(/( |&nbsp;)?\[img\](.*?)\[\/img\]( |&nbsp;)?/gi,img_smcode);
    text=text.replace(/<[^>]+>/gi,check_tag);
    text=text.replace(/&gt;/gi,'>');
    text=text.replace(/&lt;/gi,'<');
    text=text.replace(/&nbsp;/gi,' ');
    text=text.replace(/&amp;/gi,'&');
    return text;
    function img_smcode(text,tp,url){
        if(typeof(aefsmileys)=='undefined'){
            return text
        }
        for(x in aefsmileys){
            if(url==aefsmileys[x][2]){
                return' '+aefsmileys[x][1]+' '
            }
            if(aefsmileys[x][2].indexOf(url)!=-1){
                return' '+aefsmileys[x][1]+' '
            }
        }
        return text
    }
}

function check_tag(tag){
    if(/<\//i.test(tag)){
        return close_tag(tag)
    }else{
        return open_tag(tag)
    }
    function open_tag(tag){
        if(/<!--/i.test(tag)){
            return''
        }
        var thistag;
        var opened=new Array();
        var closed=new Array();
        var i=0;
        if(/<(strong|b)\b/i.test(tag)){
            opened[i]='[b]';
            closed[i]='[/b]';
            i++
        }else if(/<(i|em)\b/i.test(tag)){
            opened[i]='[i]';
            closed[i]='[/i]';
            i++
        }else if(/<(strike|s)\b/i.test(tag)){
            opened[i]='[s]';
            closed[i]='[/s]';
            i++
        }else if(/<(sup|sub|ol|ul|li|u)\b/i.test(tag)){
            opened[i]='['+RegExp.$1+']';
            closed[i]='[/'+RegExp.$1+']';
            i++
        }else if(/<a.*?href=(["'])(.+?)\1.*?>/i.test(tag)){
            opened[i]='[url='+RegExp.$2+']';
            closed[i]='[/url]';
            i++
        }
        if(/<\w* (.*?)>/i.test(tag)){
            var param=handle_param(RegExp.$1);
            opened=opened.concat(param[0]);
            closed=closed.concat(param[1])
        }
        if(/<(\w*) (.*?)>/i.test(tag)){
            thistag=RegExp.$1
        }else if(/<(\w*)>/i.test(tag)){
            thistag=RegExp.$1
        }
        thistag=trim(thistag.toLowerCase());
        opened_tags[x]=new Array(thistag,false,closed.reverse());
        x++;
        return opened.join('')
    }
        
    function close_tag(tag){
        if(/<\/(\w*)>/i.test(tag)){
            var thistag=RegExp.$1
        }
        thistag=trim(thistag.toLowerCase());
        var i=opened_tags.length-1;
        while(i>=0){
            if(opened_tags[i][1]==false&&thistag==opened_tags[i][0]){
                break
            }
            i--
        }
        opened_tags[i][1]=true;
        return opened_tags[i][2].join('')
    }
        
    function handle_param(param){
        var opened=new Array();
        var closed=new Array();
        var i=0;
        if(/bold/i.test(param)){
            opened[i]='[b]';
            closed[i]='[/b]';
            i++
        }
        if(/italic/i.test(param)){
            opened[i]='[i]';
            closed[i]='[/i]';
            i++
        }
        if(/underline/i.test(param)){
            opened[i]='[u]';
            closed[i]='[/u]';
            i++
        }
        if(/line-through/i.test(param)){
            opened[i]='[s]';
            closed[i]='[/s]';
            i++
        }
        if(/(left|center|right)/i.test(param)){
            opened[i]='['+RegExp.$1+']';
            closed[i]='[/'+RegExp.$1+']';
            i++
        }
        if(/(verdana|Arial Black|Arial Narrow|arial|helvetica|sans-serif|Times New Roman|Times|serif|courier new|Courier|monospace|geneva|georgia|Tahoma)/i.test(param)){
            opened[i]='[font='+RegExp.$1+']';
            closed[i]='[/font]';
            i++
        }
        if(/color=(["'])?(\#.{6})\1.*?/i.test(param)){
            opened[i]='[color='+RegExp.$2+']';
            closed[i]='[/color]';
            i++
        }
        if(/color:\s*(\#.{6})/i.test(param)){
            opened[i]='[color='+RegExp.$1+']';
            closed[i]='[/color]';
            i++
        }
        if(/rgb\s*\(([0-9]+),\s*([0-9]+),\s*([0-9]+)\)/i.test(param)){
            opened[i]='[color=#'+toHex(RegExp.$1)+toHex(RegExp.$2)+toHex(RegExp.$3)+']';
            closed[i]='[/color]';
            i++
        }
        if(/size=(["'])?(\d){1}\1/i.test(param)){
            opened[i]='[size='+RegExp.$2+']';
            closed[i]='[/size]';
            i++
        }
        return[opened,closed]
    }
}

function bbc_html(text){
    text=text.replace(/&/gi,'&amp;');
    text=text.replace(/>/gi,'&gt;');
    text=text.replace(/</gi,'&lt;');
    text=text.replace(/(\r\n|\n|\r)/g,'<br />');
    text=text.replace(/\[hr\]/gi,'<hr />');
    text=text.replace(/\[b\](.*?)\[\/b\]/gi,'<b>$1</b>');
    text=text.replace(/\[i\](.*?)\[\/i\]/gi,'<i>$1</i>');
    text=text.replace(/\[u\](.*?)\[\/u\]/gi,'<u>$1</u>');
    text=text.replace(/\[s\](.*?)\[\/s\]/gi,'<s>$1</s>');
    text=text.replace(/\[left\](.*?)\[\/left\]/gi,'<div style="text-align: left;">$1</div>');
    text=text.replace(/\[center\](.*?)\[\/center\]/gi,'<div style="text-align: center;">$1</div>');
    text=text.replace(/\[right\](.*?)\[\/right\]/gi,'<div style="text-align: right;">$1</div>');
    while(/\[size=([1-7])\](.*?)\[\/size\]/gi.test(text)){
        text=text.replace(/\[size=([1-7])\](.*?)\[\/size\]/gi,'<font size="$1" style="line-height:normal">$2</font>')
    }while(/\[font=(.*?)\](.*?)\[\/font\]/gi.test(text)){
        text=text.replace(/\[font=(.*?)\](.*?)\[\/font\]/gi,'<font style="font-family:$1">$2</font>')
    }while(/\[color=(.*?)\](.*?)\[\/color\]/gi.test(text)){
        text=text.replace(/\[color=(.*?)\](.*?)\[\/color\]/gi,'<font style="color: $1">$2</font>')
    }
    text=text.replace(/\[sup\](.*?)\[\/sup\]/gi,'<sup>$1</sup>');
    text=text.replace(/\[sub\](.*?)\[\/sub\]/gi,'<sub>$1</sub>');
    text=text.replace(/\[url=(.*?)\](.*?)\[\/url\]/gi,'<a href="$1" target="_blank">$2</a>');
    text=text.replace(/\[url\](.*?)\[\/url\]/gi,'<a href="$1" target="_blank">$1</a>');
    text=text.replace(/\[ftp=(.*?)\](.*?)\[\/ftp\]/gi,'<a href="$1" target="_blank">$2</a>');
    text=text.replace(/\[ftp\](.*?)\[\/ftp\]/gi,'<a href="$1" target="_blank">$1</a>');
    text=text.replace(/\[email=(.*?)\](.*?)\[\/email\]/gi,'<a href="mailto:$1" target="_blank">$2</a>');
    text=text.replace(/\[email\](.*?)\[\/email\]/gi,'<a href="mailto:$1" target="_blank">$1</a>');
    text=text.replace(/\[img\](.*?)\[\/img\]/gi,'<img src="$1" />');
    text=text.replace(/\[img=([0-9]+),([0-9]+)\](.*?)\[\/img\]/gi,'<img src="$3" width="$1" height="$2" />');
    text=text.replace(/(\[ul(.*?)?\](.*)\[\/ul\])/gi,check_ul);
    text=text.replace(/(\[ol(.*?)?\](.*)\[\/ol\])/gi,check_ol);
    text=smcode_img(text);
    text=text.replace(/ {2}/g,'&nbsp;&nbsp;');
    return text
}
    
function check_ul(ul){
    ul_opened=0;
    ul_closed=0;
    var ultext=ul;
    ultext=ultext.replace(/(<br \/>)*?\[li\]/gi,'<li>');
    ultext=ultext.replace(/\[\/li\](<br \/>)*?/gi,'</li>');
    ultext=ultext.replace(/(<br \/>)*?\[ul(?=[\]]).*?\]/gi,parse_ul);
    ultext=ultext.replace(/(<br \/>)*?\[\/ul\](<br \/>)*?/gi,close_ul);
    if(ul_opened==ul_closed){
        return ultext
    }else{
        return ul
    }
}

function parse_ul(param){
    type='disc';
    var param=trim(param);
    if(param.length>0){
        if(/\=(circle|disc|square)/gi.test(param)){
            type=RegExp.$1
        }
    }
    ul_opened++;
    return'<ul type="'+type+'" >'
}

function close_ul(){
    ul_closed++;
    return'</ul >'
}
    
function check_ol(ol){
    ol_opened=0;
    ol_closed=0;
    var oltext=ol;
    oltext=oltext.replace(/(<br \/>)*?\[li\]/gi,'<li>');
    oltext=oltext.replace(/\[\/li\](<br \/>)*?/gi,'</li>');
    oltext=oltext.replace(/(<br \/>)*?\[ol(?=[\]]).*?\]/gi,parse_ol);
    oltext=oltext.replace(/(<br \/>)*?\[\/ol\](<br \/>)*?/gi,close_ol);
    if(ol_opened==ol_closed){
        return oltext
    }else{
        return ol
    }
}

function parse_ol(param){
    type=1;
    var param=trim(param);
    if(param.length>0){
        if(/\=(\w{1}?)/gi.test(param)){
            type=RegExp.$1
        }
    }
    ol_opened++;
    return'<ol type="'+type+'" >'
}

function close_ol(){
    ol_closed++;
    return'</ol >'
}
    
function smcode_img(text){
    var regexp;
    if(typeof(aefsmileys)=='undefined'){
        return text
    }
    for(x in aefsmileys){
        regexp='/ '+aefsmileys[x][0]+' /gi';
        text=text.replace(eval(regexp),' <img src="'+aefsmileys[x][2]+'"> ')
    }
    return text
}
    
function storeCaret(ele){
    if(ele.createTextRange)ele.caretPos=document.selection.createRange().duplicate()
}
        
function makeurl(){
    var urltext,linkurl;
    urltext=$('urltext').value;
    linkurl=$('linkurl').value;
    if(linkurl!=''&&urltext==''){
        editor.wrap_bbc('[url]'+linkurl,'[/url]')
    }else if(linkurl!=''&&urltext!=''){
        editor.wrap_bbc('[url='+linkurl+']'+urltext,'[/url]')
    }
}

function makeftp(){
    var ftptext,ftplink;
    ftptext=$('ftptext').value;
    ftplink=$('ftplink').value;
    if(ftplink!=''&&ftptext==''){
        editor.wrap_bbc('[ftp]'+ftplink,'[/ftp]')
    }else if(ftplink!=''&&ftptext!=''){
        editor.wrap_bbc('[ftp='+ftplink+']'+ftptext,'[/ftp]')
    }
}

function makeemail(){
    var addressee,emailadd;
    addressee=$('addressee').value;
    emailadd=$('emailadd').value;
    if(emailadd!=''&&addressee==''){
        editor.wrap_bbc('[email]'+emailadd,'[/email]')
    } else if (emailadd!=''&&addressee!=''){
        editor.wrap_bbc('[email='+emailadd+']'+addressee,'[/email]')
    }
}

function toHex(decimal){
    var HexCharacters="0123456789ABCDEF";
    return HexCharacters.charAt((decimal>>4)&0xf)+HexCharacters.charAt(decimal&0xf)
}