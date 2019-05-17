<?php
header("Content-type: text/css");
header("X-Content-Type-Options: nosniff");
?>
.text-center{
    text-align: center;
}
.text-left{
    text-align: left;
}
.text-right{
    text-align: right;
}
body, HTML{
padding:0;
margin:0;
font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Helvetica,Arial,sans-serif;
}
body{
background:#24292E url("../images/UI/trianglify.png") fixed;
background-size: cover;
}
h1{
    font-weight:300;
    font-size: 48px;
    color:#FFF6EF;
    margin-bottom:0;
    padding-bottom:0;
}
h2{
    font-weight:300!important;
    color:#FFF6EF;
    margin-bottom:0;
    padding-bottom:0;
}
h3{
    font-weight:300!important;
    color:#FFF6EF;
    margin-bottom:0;
    padding-bottom:0;
}
.h1Subheading{
    padding-top:0;
    margin-top:0;
}
hr{
    border:0;
    border-top: 1px solid #24292E;
}
a{
    color:#8e7bd5;
    text-decoration:none;
}
a:hover{
    color:#8e7bd5;
    text-decoration: underline;
}
a:visited{
    color:#8e7bd5;
}
.bodyWrapper{
    max-width:1200px;
    margin:0 auto;
    background:#171a1c;
    color:#B3B4AE;
    padding-top:40px;
    padding-bottom:10px;
    /*box-shadow: 0px 0px 50px #000;*/
}
.glossyButton{
    display:inline-block;
    border:1px solid #4e277b;
    border-radius:4px;
    color:#FFF6EF;
    padding:10px;
    font-size:18px;
    background: #8241f9; /* Old browsers */
    background: -moz-linear-gradient(top, #8241f9 0%, #8845d3 50%, #6733b8 50%, #4e277b 100%); /* FF3.6-15 */
    background: -webkit-linear-gradient(top, #8241f9 0%,#8845d3 50%,#6733b8 50%,#4e277b 100%); /* Chrome10-25,Safari5.1-6 */
    background: linear-gradient(to bottom, #8241f9 0%,#8845d3 50%,#6733b8 50%,#4e277b 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#8241f9', endColorstr='#4e277b',GradientType=0 ); /* IE6-9 */
    outline:0 none;
}
.glossyButton:active{
/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#9d6cf7+0,9b6cd1+50,805db7+50,593e7a+100 */
background: #9d6cf7; /* Old browsers */
background: -moz-linear-gradient(top, #9d6cf7 0%, #9b6cd1 50%, #805db7 50%, #593e7a 100%); /* FF3.6-15 */
background: -webkit-linear-gradient(top, #9d6cf7 0%,#9b6cd1 50%,#805db7 50%,#593e7a 100%); /* Chrome10-25,Safari5.1-6 */
background: linear-gradient(to bottom, #9d6cf7 0%,#9b6cd1 50%,#805db7 50%,#593e7a 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#9d6cf7', endColorstr='#593e7a',GradientType=0 ); /* IE6-9 */
}
.glossyButton:hover{
/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#691df7+0,7b30d1+50,5619b7+50,41127a+100 */
background: #691df7; /* Old browsers */
background: -moz-linear-gradient(top, #691df7 0%, #7b30d1 50%, #5619b7 50%, #41127a 100%); /* FF3.6-15 */
background: -webkit-linear-gradient(top, #691df7 0%,#7b30d1 50%,#5619b7 50%,#41127a 100%); /* Chrome10-25,Safari5.1-6 */
background: linear-gradient(to bottom, #691df7 0%,#7b30d1 50%,#5619b7 50%,#41127a 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#691df7', endColorstr='#41127a',GradientType=0 ); /* IE6-9 */
}
.glossyButtonRED{
    display:inline-block;
    border:1px solid #4F0B0B;
    border-radius:4px;
    color:#FFF6EF;
    padding:10px;
    font-size:18px;
    /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#f4241d+0,c92e2e+50,ba241a+50,771111+100 */
background: #f4241d; /* Old browsers */
background: -moz-linear-gradient(top, #f4241d 0%, #c92e2e 50%, #ba241a 50%, #771111 100%); /* FF3.6-15 */
background: -webkit-linear-gradient(top, #f4241d 0%,#c92e2e 50%,#ba241a 50%,#771111 100%); /* Chrome10-25,Safari5.1-6 */
background: linear-gradient(to bottom, #f4241d 0%,#c92e2e 50%,#ba241a 50%,#771111 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f4241d', endColorstr='#771111',GradientType=0 ); /* IE6-9 */
    outline:0 none;
}
.glossyButtonRED:active{
/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#9d6cf7+0,9b6cd1+50,805db7+50,593e7a+100 */
/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#ff7070+0,ff8484+49,e02c2c+49,7f4141+100 */
background: #ff7070; /* Old browsers */
background: -moz-linear-gradient(top, #ff7070 0%, #ff8484 49%, #e02c2c 49%, #7f4141 100%); /* FF3.6-15 */
background: -webkit-linear-gradient(top, #ff7070 0%,#ff8484 49%,#e02c2c 49%,#7f4141 100%); /* Chrome10-25,Safari5.1-6 */
background: linear-gradient(to bottom, #ff7070 0%,#ff8484 49%,#e02c2c 49%,#7f4141 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ff7070', endColorstr='#7f4141',GradientType=0 ); /* IE6-9 */
}
.glossyButtonRED:hover{
/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#bc1616+0,9e4545+50,a01616+50,4f0b0b+100 */
background: #bc1616; /* Old browsers */
background: -moz-linear-gradient(top, #bc1616 0%, #9e4545 50%, #a01616 50%, #4f0b0b 100%); /* FF3.6-15 */
background: -webkit-linear-gradient(top, #bc1616 0%,#9e4545 50%,#a01616 50%,#4f0b0b 100%); /* Chrome10-25,Safari5.1-6 */
background: linear-gradient(to bottom, #bc1616 0%,#9e4545 50%,#a01616 50%,#4f0b0b 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#bc1616', endColorstr='#4f0b0b',GradientType=0 ); /* IE6-9 */
}
.smallglossyButton{
    display:inline-block;
    border:1px solid #4e277b;
    border-radius:4px;
    color:#FFF6EF;
    padding:5px;
    font-size:12px;
    background: #8241f9; /* Old browsers */
    background: -moz-linear-gradient(top, #8241f9 0%, #8845d3 50%, #6733b8 50%, #4e277b 100%); /* FF3.6-15 */
    background: -webkit-linear-gradient(top, #8241f9 0%,#8845d3 50%,#6733b8 50%,#4e277b 100%); /* Chrome10-25,Safari5.1-6 */
    background: linear-gradient(to bottom, #8241f9 0%,#8845d3 50%,#6733b8 50%,#4e277b 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#8241f9', endColorstr='#4e277b',GradientType=0 ); /* IE6-9 */
    outline:0 none;
}
.smallglossyButton:active{
    /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#9d6cf7+0,9b6cd1+50,805db7+50,593e7a+100 */
    background: #9d6cf7; /* Old browsers */
    background: -moz-linear-gradient(top, #9d6cf7 0%, #9b6cd1 50%, #805db7 50%, #593e7a 100%); /* FF3.6-15 */
    background: -webkit-linear-gradient(top, #9d6cf7 0%,#9b6cd1 50%,#805db7 50%,#593e7a 100%); /* Chrome10-25,Safari5.1-6 */
    background: linear-gradient(to bottom, #9d6cf7 0%,#9b6cd1 50%,#805db7 50%,#593e7a 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#9d6cf7', endColorstr='#593e7a',GradientType=0 ); /* IE6-9 */
}
.smallglossyButton:hover{
    /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#691df7+0,7b30d1+50,5619b7+50,41127a+100 */
    background: #691df7; /* Old browsers */
    background: -moz-linear-gradient(top, #691df7 0%, #7b30d1 50%, #5619b7 50%, #41127a 100%); /* FF3.6-15 */
    background: -webkit-linear-gradient(top, #691df7 0%,#7b30d1 50%,#5619b7 50%,#41127a 100%); /* Chrome10-25,Safari5.1-6 */
    background: linear-gradient(to bottom, #691df7 0%,#7b30d1 50%,#5619b7 50%,#41127a 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#691df7', endColorstr='#41127a',GradientType=0 ); /* IE6-9 */
}
.menuBar{
    width:100%;
    position:fixed;
    top:0;
    height:50px;
    /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#691df7+0,7b30d1+50,5619b7+50,41127a+100 */
    background: url('../images/UI/bannerGlow.png'),#691df7; /* Old browsers */
    background: url('../images/UI/bannerGlow.png'),-moz-linear-gradient(top, #691df7 0%, #7b30d1 50%, #5619b7 50%, #41127a 100%); /* FF3.6-15 */
    background: url('../images/UI/bannerGlow.png'),-webkit-linear-gradient(top, #691df7 0%,#7b30d1 50%,#5619b7 50%,#41127a 100%); /* Chrome10-25,Safari5.1-6 */
    background: url('../images/UI/bannerGlow.png'),linear-gradient(to bottom, #691df7 0%,#7b30d1 50%,#5619b7 50%,#41127a 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#691df7', endColorstr='#41127a',GradientType=0 ); /* IE6-9 */
    color:#FFF6EF;
    transition: all 0.2s ease-in-out;
    z-index: 999999;
}
.smallMenuBar{
    width:100%;
    position:fixed;
    top:0;
    height:30px;
    /*background: url('../images/UI/bannerGlow.png'),linear-gradient(to bottom, #8241f9, #4e277b);*/
    background: url('../images/UI/bannerGlow.png'),#691df7; /* Old browsers */
    background: url('../images/UI/bannerGlow.png'),-moz-linear-gradient(top, #691df7 0%, #7b30d1 50%, #5619b7 50%, #41127a 100%); /* FF3.6-15 */
    background: url('../images/UI/bannerGlow.png'),-webkit-linear-gradient(top, #691df7 0%,#7b30d1 50%,#5619b7 50%,#41127a 100%); /* Chrome10-25,Safari5.1-6 */
    background: url('../images/UI/bannerGlow.png'),linear-gradient(to bottom, #691df7 0%,#7b30d1 50%,#5619b7 50%,#41127a 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#691df7', endColorstr='#41127a',GradientType=0 ); /* IE6-9 */
    color:#FFF6EF;
    transition: all 0.5s ease-in-out;
    z-index: 999999;
}
.card {
    position: relative;
    display:inline-block;
    width:350px;
    min-height: 360px;
    border-radius:4px;
    box-shadow: 0px 0px 10px #000;
    background:#24292E;
    margin-left:10px;
    margin-right:10px;
    margin-bottom:20px;
}
.card h3 {
    position:absolute;
    top: 130px;
    left: 5px;
    text-align: left;
    font-family: 'Special Elite', cursive;
    text-shadow: 0px 0px 10px #000;
    -webkit-text-stroke: 1px #000;
    text-stroke: 1px #000;
    font-size:36px;
    color: #fff;
}
.cardImage img {
    width:350px;
    border-top-left-radius:4px;
    border-top-right-radius:4px;
    border-bottom:4px solid #691df7;
}
.fullWidthSection {
    /* Permalink - use to edit and share this gradient: https://colorzilla.com/gradient-editor/#171a1c+0,171a1c+100&1+50,1+50,0+98 */
    background: #171a1c;
    color:#B3B4AE;
    padding-top:40px;
    z-index: 999999;
}
.fullWidthSectionGrad {
    /* Permalink - use to edit and share this gradient: https://colorzilla.com/gradient-editor/#171a1c+0,171a1c+100&1+0,0+98 */
    background: -moz-linear-gradient(top,  rgba(23,26,28,1) 0%, rgba(23,26,28,0) 98%, rgba(23,26,28,0) 100%); /* FF3.6-15 */
    background: -webkit-linear-gradient(top,  rgba(23,26,28,1) 0%,rgba(23,26,28,0) 98%,rgba(23,26,28,0) 100%); /* Chrome10-25,Safari5.1-6 */
    background: linear-gradient(to bottom,  rgba(23,26,28,1) 0%,rgba(23,26,28,0) 98%,rgba(23,26,28,0) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#171a1c', endColorstr='#00171a1c',GradientType=0 ); /* IE6-9 */
    color:#B3B4AE;
    padding-bottom:460px;
    margin-bottom:-500px;
    z-index: 999999;
}
.smallMenuBar .logo{
    /*-webkit-text-stroke: 1px #000;*/
    color:#FFF6EF;
    font-size: 20px;
    font-weight: 300;
    padding-top:0px;
    padding-left:10px;
    float:left;
    transition: all 0.5s ease-in-out;
}
.smallMenuBar .logo img {
    height:25px;
    margin-right:-5px;
    vertical-align: middle;
    transition: all 0.5s ease-in-out;
}
.menuBar .logo{
    /*text-shadow:0px 0px 5px #000;*/
    color:#FFF6EF;
    font-size: 30px;
    font-weight: 300;
    padding-top:2px;
    padding-left:10px;
    float:left;
    transition: all 0.2s ease-in-out;
}
.menuBar .logo img {
    height:50px;
    margin-right:-10px;
    vertical-align: middle;
    transition: all 0.2s ease-in-out;
}
.smallMenuBar .menuButton{
    float:right;
    padding:5px;
    padding-left:0;
    transition: all 0.5s ease-in-out;
}
.menuBar .menuButton{
    float:right;
    padding:10px;
    padding-left:0;
    transition: all 0.2s ease-in-out;
}
.smallMenuBar .menuButton img{
    width:20px;
    height:20px;
    transition: all 0.5s ease-in-out;
}
.menuBar .menuButton img{
    width:30px;
    height:30px;
    transition: all 0.2s ease-in-out;
}
.smallMenuBar .menuLink{
    float:right;
    padding-top:2px;
    transition: all 0.5s ease-in-out;
}
.menuBar .menuLink{
    float:right;
    padding-top:12px;
    transition: all 0.2s ease-in-out;
}
.menuLink a{
    display:inline-block;
    margin-right:10px;
    color:#FFF6EF;
    font-size:14px;
    text-decoration: none;
}
.menuLink a:hover{
    text-decoration: underline;
    color:#fff;
}
.contentDiv{
    padding:20px;
}
#drop_file_zone {
    border: #B3B4AE 5px dashed;
    width: 290px; 
    height: 200px;
    padding: 8px;
    font-size: 18px;
    margin:0 auto;
    margin-top:20px;
}
#drag_upload_file {
    width:50%;
    margin:0 auto;
    margin-top:35px;
}
#drag_upload_file img {
    width:50px;
}
#drag_upload_file p {
    text-align: center;
}
#drag_upload_file #selectfile {
    display: none;
}
#debugOutput {
    width:1160px;
    height:520px;
    margin-top:20px;
    overflow-x:scroll;
    overflow-y:scroll;
    border:1px solid #24292E;
    border-radius: 2px;
}
::-webkit-scrollbar {
    width:15px;
    height:15px;
    background:rgba(0,0,0,0)
}
::-webkit-scrollbar-track {
    border-radius: 2px;
    -webkit-box-shadow: inset 0 0 2px #24292E;
    box-shadow: inset 0 0 2px #24292E;
}
::-webkit-scrollbar-thumb {
    -webkit-border-radius: 2px;
    border-radius: 2px;
    background: #B3B4AE;
    -webkit-box-shadow: inset 0 0 2px #24292E;
    box-shadow: inset 0 0 2px #24292E;
}
::-webkit-scrollbar-thumb:window-inactive {
    background: #B3B4AE;
}
::-webkit-scrollbar-corner {
    background: rgba(0,0,0,0);
}
.SelectionDivNoHover{
    border:1px solid #24292E;
    transition:0.2s ease-in-out;
    height:340px;
    overflow-y: scroll;
    clear:both;
}
.sessionDate{
    border-bottom:1px solid #24292E;
    clear:both;
}
.SelectionDiv{
    border:1px solid #24292E;
    transition:0.2s ease-in-out;
    height:340px;
    overflow-y: scroll;
    clear:both;
}
.SelectionDiv:hover{
    border:1px solid #B3B4AE;
}
.SelectionDivItem {
    padding:5px;
    border-bottom:1px solid #24292E;
    clear:both;
    padding-left:40px;
}
.Selected {
    padding:5px;
    border-bottom:1px solid #24292E;
    clear:both;
    padding-left:40px;
    background: #691df7;
}
.clearP {
    margin:0;
    padding:0;
    height:0;
    clear:both;
}
.clear {
    clear:both;
}
.SelectionDivItem:hover {
    background:#24292E;
}
.Selected:hover {
    background:#7b30d1;
}
.SelectionButton{
    text-align: center;
    padding:5px;
    padding-top:10px;
    margin:3px 0 3px 0;
}
.SelectionButton:hover{
    background:#24292E;
}
.popupFormTextInput {
    border: 1px solid #24292E;
    padding: 5px;
    margin:0;
    background:#24292E;
    color:#FFF6EF;
    border-radius: 4px;
    outline: 0 none;
}
.footerLink {
    text-decoration: none;
    color:#B3B4AE;
}
.footerLink:visited {
    color: #b3b3b3;
}
.footerLink:hover {
    text-decoration: underline;
    color:#8e7bd5;
}

#PleaseWait{
    text-align:center;
    font-size:18px;
}
#PleaseWait img{
    border-radius:5px;
    height:200px;
}
.globalLeaderboard_wrapper_wrapper {
    min-height: 636px !important;
}
.configNumber {
    width:50px;
    background: #24292E;
    border:0 none;
    outline:0 none;
    color:#FFF6EF;
    padding:5px;
    border-radius: 2px;
    transition: 0.2s ease-in-out;
}
.configNumber:hover, .configNumber:active, .configNumber:focus {
    background: #393d42;
}
.gunIcon {
    max-width: 80px;
    max-height: 80px;
    vertical-align: middle;
}
.tagdiv {
    background: #8845d3;
    border-radius: 5px;
    border: 1px solid #171a1c;
    font-size: 10px;
    color: white;
    float:left;
    margin-right:5px;
    padding-left:4px;
    padding-right:4px;
}
.playerStats {
    /*nothing of note right now*/
    padding:10px;
    overflow: hidden;
}
.display {
    font-size:14px;
}
.displayNone {
    display: none;
    height:0px;
}
.displayBlock {
    display: block;
}
.invisible {
    transition: visibility 0.5s ease-in-out,opacity 0.5s ease-in-out,max-height 0.8s ease-in-out,display 0.8s ease-in-out,height 0.8s ease-in-out;
    visibility:hidden;
    opacity:0;
    height:0px;
    max-height: 0px;
}
.visible {
    transition: visibility 1s ease-in-out,opacity 1s ease-in-out,max-height 1s ease-in-out,display 1s ease-in-out,height 1s ease-in-out;
    visibility:visible;
    opacity:1;
    height: 100%;
    max-height: 1200px;
}
/* Fix flashing tooltip */
svg > g > g:last-child { pointer-events: none }