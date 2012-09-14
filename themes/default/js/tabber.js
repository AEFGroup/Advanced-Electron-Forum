//////////////////////////////////////////////////////////////
// Tabber.js
// By Electron, Ronak Gupta, Pulkit Gupta
// Please Read the Terms of use at http://www.anelectron.com
// (C)AEF Group All Rights Reserved.
// You cannot remove the copyrights.
//////////////////////////////////////////////////////////////

function tabber(){

    this.tabs = new Array();//The tabs

    this.tabwindows = new Array();//The tab windows

    this.tabclass = 'tab';//A tab button which is not yet tabbed

    this.tabbedclass = 'tabbed';//The tabbed button class

    this.tab = function(id){
        for(x in this.tabs){
            if(this.tabs[x] == id){
                $(this.tabs[x]).className = this.tabbedclass;
                $(this.tabwindows[x]).style.display = 'block';
            }else{
                $(this.tabs[x]).className = this.tabclass;
                $(this.tabwindows[x]).style.display = 'none';
            }
        }
    };

    //Will set the first tab to Tabbed
    this.init = function(){
        this.tab(this.tabs[0]);
    }

}