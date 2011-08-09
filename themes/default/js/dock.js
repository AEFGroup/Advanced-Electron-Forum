//////////////////////////////////////////////////////////////
// Dock.js
// Please Read the Terms of use at http://www.anelectron.com
//////////////////////////////////////////////////////////////

function dock(id){
    this.speed = 10;
    this.pace = 10;
    this.min = 40;
    this.max = 80;
    var img, sizes = [];
    if(typeof(id) != 'string'){
        id = 'dock';
    }	
    this.init = function(){
        var self = this;
        this.dock = $(id);
        sizes.def = Math.floor((this.max-this.min)/3);
        for(i=0; i<4; i++){
            sizes[i] = 1*this.min + i*sizes.def;
        }
        //Get the images
        img = this.dock.getElementsByTagName('img');
        //Set the width
        this.dock.style.height = sizes[3]+"px";
        //Set the height
        this.dock.style.width = (sizes[0]*(img.length-1))+"px";
	
        for (i=0; i<img.length; i++) {
            img[i].now = {
                left : 0, 
                top : 0, 
                size : sizes[0]
            };
            img[i].target = {
                left : 0, 
                top : 0, 
                size : sizes[0]
            };
			
            //Mouseover Event
            img[i].onmouseover = function(e) {
                e = window.event ? event : e;
                e = e.srcElement ? e.srcElement : e.target;
                for(i=0; i<img.length; i++){
                    if(e==img[i]){
                        self.process(i);
                        break;
                    }
                }
            };
			
            //Mouseout Event
            img[i].onmouseout = function(){
                self.process(-1);
            };
        }
		
        //Process
        this.process(-1);
        var process = function(){
            self.dockify();
        };
        setTimeout(process, this.speed);
    };
	
    this.dockify = function(){
        var self = this;
        for (i=0; i<img.length; i++){
            img[i].now.left = ((this.pace-1)*img[i].now.left+img[i].target.left)/this.pace;
            img[i].style.left = Math.floor(img[i].now.left)+'px';
	
            img[i].now.top = ((this.pace-1)*img[i].now.top+img[i].target.top)/this.pace;
            img[i].style.top = Math.floor(img[i].now.top)+'px';
	
            img[i].now.size = ((this.pace-1)*img[i].now.size+img[i].target.size)/this.pace;
            img[i].style.width = Math.floor(img[i].now.size)+'px';
            img[i].style.height = Math.floor(img[i].now.size)+'px';
        }	
        var process = function(){
            self.dockify();
        };
        setTimeout(process ,this.speed);
    };
	
    this.process = function(m){
        for(i=0; i<img.length; i++){
            img[i].target.size = sizes[0];
            for(j=0; j<sizes.length-1; j++){
                if(m>-1 && m<img.length && Math.abs(m-i)==j){
                    img[i].target.size = sizes[sizes.length-1-j];
                }
            }
            img[i].target.top = sizes[3] - img[i].target.size;
        }
        var n = m > 2 ? 2 : m;
        if(n > -1){
            img[0].target.left = -(1/2)*(sizes[0]+ sizes.def *(n*(4-(1/2)*n)+3));
        }else{
            img[0].target.left = 0;
        }
		
        for(i=1; i<img.length; i++){
            img[i].target.left = img[i-1].target.left + img[i-1].target.size;
        }	
    };	
};