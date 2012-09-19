
function insertbbc(field, starttag, endtag){
    //IE support
    if (document.selection){
        field.focus();
        sel = document.selection.createRange();
        sel.text = starttag+sel.text+endtag;
    }
    //MOZILLA/NETSCAPE support
    else if (field.selectionStart || field.selectionStart == '0') {
        var startPos = field.selectionStart;
        var endPos = field.selectionEnd;
        field.value = field.value.substring(0, startPos)+starttag+field.value.substring(startPos, endPos)+endtag+field.value.substring(endPos, field.value.length);
    } else {
        field.value += starttag+endtag;
    }
}
//A function to insert Smileys in the form
function insertemot(myField, myValue) {
    //IE support
    if (myField.caretPos && myField.createTextRange) {
        var caretPos = myField.caretPos;
        caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? myValue + ' ' : myValue;
        caretPos.select();
    }
    //MOZILLA/NETSCAPE support
    else if (myField.selectionStart || myField.selectionStart == '0') {
        var startPos = myField.selectionStart;
        var endPos = myField.selectionEnd;
        myField.value = myField.value.substring(0, startPos)+ myValue + myField.value.substring(endPos, myField.value.length);
    } else {
        myField.value += myValue;
    }
}


function storeCaret (myField){
    if (myField.createTextRange)
        myField.caretPos = document.selection.createRange().duplicate();
//alert(myField.caretPos);
}