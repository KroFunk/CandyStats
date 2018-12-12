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
background:#24292E;
font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Helvetica,Arial,sans-serif;
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
    max-width:1000px;
    margin:0 auto;
    background:#171a1c;
    color:#B3B4AE;
    padding-top:40px;
    padding-bottom:10px;
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
    max-width:1000px;
    margin:0 auto;
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
    max-width:1000px;
    margin:0 auto;
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
.smallMenuBar .logo{
    color:#FFF6EF;
    font-size: 20px;
    font-weight: 300;
    padding-top:0px;
    padding-left:10px;
    float:left;
    transition: all 0.5s ease-in-out;
}
.menuBar .logo{
    color:#FFF6EF;
    font-size: 30px;
    font-weight: 300;
    padding-top:2px;
    padding-left:10px;
    float:left;
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
.SelectionDiv{
    border:1px solid #24292E;
    transition:0.5s ease-in-out;
}
.SelectionDiv:hover{
    border:1px solid #B3B4AE;
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
#PleaseWait{
    text-align:center;
    font-size:18px;
}
#PleaseWait img{
    border-radius:5px;
    height:200px;
}
.globalLeaderboard_wrapper_wrapper {
    min-height: 602px !important;
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