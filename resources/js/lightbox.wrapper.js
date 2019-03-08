/*
The MIT License (MIT)

Copyright (c) 2015 Robin Paul Wright

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
*/


// Fetch this scripts location so resources can be located
var scripts = document.getElementsByTagName('script');
var path = scripts[scripts.length-1].src.split('?')[0];
var mydir = path.split('/').slice(0, -1).join('/')+'/';

// Add the LightBox to the HTML body
var lightBox = document.createElement("div");
lightBox.id = 'lightBoxWrapper';
document.body.appendChild(lightBox);
document.getElementById('lightBoxWrapper').innerHTML = '<div id="grey" style="-webkit-transition: 0.5s; -moz-transition: 0.5s; transition: 0.5s;position:fixed; left:-5%; top:-5%; opacity:0.4; background:#000; width:110%; height:110%; display: none; visibility: hidden;" onclick="closewrapper();">&nbsp;</div><div id="lightBoxwrapper" style="-webkit-transition: 0.5s; -moz-transition: 0.5s; transition: 0.5s;background-color:rgba(255,255,255,0); border-radius: 0px; padding:0px; position: fixed; left: 50%; top: 50%; z-index: 999999; width:0px; height:0px; margin-left:0px; margin-top:0px; display: none; visibility: hidden;"><a href="javascript:void(0);" onclick="closewrapper();"><img id="lightBoxX" src="'+mydir+'X.png" style="-webkit-transition: 0.5s; -moz-transition: 0.5s; transition: 0.5s;position:relative; top:-0px; left:0px; border:0 none;"></a><div id="lightBoxBorder" style="overflow: auto; overflow-x: hidden; -webkit-overflow-scrolling: touch;-webkit-transition: 0.5s; -moz-transition: 0.5s; transition: 0.5s; background:#171A1C; border-radius:2px; margin-top:-10px;"><iframe id="lightBox" style="-webkit-transition: 0.5s; -moz-transition: 0.5s; transition: 0.5s; border:0 none; height:220px; width:100%;" border="0" frameborder="0"></iframe></div></div>';

// Stop scroll event 'bubble' - requires jQuery



function openwrapper(url, x, y, border){
//set border
if(typeof border === 'number') {
document.getElementById("lightBoxBorder").style.border = border+"px solid #393d42";
}
else {
document.getElementById("lightBoxBorder").style.border = "none";
border = 0;
}

// Show popup elements
document.getElementById('grey').style.display='block';
document.getElementById('lightBoxwrapper').style.display='block'; 
document.getElementById('grey').style.visibility='visible';
document.getElementById('lightBoxwrapper').style.visibility='visible'; 

// Resize elements
document.getElementById('lightBoxwrapper').style.width=x + ((2 * border) + 2) + "px";
document.getElementById('lightBoxwrapper').style.height=y + (2 * border) + "px";
document.getElementById('lightBox').style.height=(y) + "px";
document.getElementById('lightBox').style.width=(x) + "px";

// Position elements
document.getElementById('lightBoxwrapper').style.marginLeft="-" + ((x + (2 * border)) / 2) + "px";
document.getElementById('lightBoxwrapper').style.marginTop="-" + ((y + (2 * border)) / 2) + "px";
document.getElementById('lightBoxX').style.left=(x - (10 - (border * 2))) + "px";

// Set Path on lightBox
document.getElementById('lightBox').src = url;
}

function closewrapper() { 
// hide popup elements
 document.getElementById('lightBox').src = 'about:blank';
document.getElementById('lightBoxwrapper').style.display='none'; 
document.getElementById('grey').style.display='none';
document.getElementById('grey').style.visibility='hidden';
document.getElementById('lightBoxwrapper').style.visibility='hidden'; 
}


// Stop double scroll // https://stackoverflow.com/questions/32165246/prevent-parent-page-from-scrolling-when-mouse-is-over-embedded-iframe-in-firefox
iframe = document.getElementById('lightBox');
grey = document.getElementById('grey');
(function(w) {
    var s = { insideIframe: false } 
    var v = { insidegrey: false }

    iframe.addEventListener('mouseenter', function() {
        s.insideIframe = true;
        s.scrollX = w.scrollX;
        s.scrollY = w.scrollY;
    });

    grey.addEventListener('mouseenter', function() {
        v.insidegrey = true;
        v.scrollX = w.scrollX;
        v.scrollY = w.scrollY;
    });

    iframe.addEventListener('mouseleave', function() {
        s.insideIframe = false;
    });

    grey.addEventListener('mouseleave', function() {
        v.insidegrey = false;
    });

    document.addEventListener('scroll', function() {
        if (s.insideIframe)
            w.scrollTo(s.scrollX, s.scrollY);
    });

    document.addEventListener('scroll', function() {
        if (v.insidegrey)
            w.scrollTo(s.scrollX, s.scrollY);
    });
})(window);