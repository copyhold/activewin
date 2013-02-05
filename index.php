<?php
$d=dir('tpl');
$tpl = [];
while ($f=$d->read()) {
	if ($f[0]=='.') continue;
	$fp = fopen("tpl/$f",'r');
	$k = substr($f,0,-5);
	$tpl[$k] = [trim(fgetss($fp)),trim(fgetss($fp)),fread($fp,10000)];
}
$page = $_GET['page'];

if ($page=='all') {
	unset($tpl['404']);
	echo json_encode($tpl);
	exit;
}
if (!isset($page , $tpl[$page])) {
	header('HTTP/1.1 403 Hack Denied');
	exit;
}
?>
<!Doctype html>
<html>
<head>
<title><?php echo $tpl[$page][0];?></title>
<meta name=description value="<?php echo $tpl[$page][1];?>" />
<link href='http://fonts.googleapis.com/css?family=Roboto:700' rel='stylesheet' type='text/css'>
<style>
body {
  background: #2d2d2d;
margin:0;
}
body > section {
	height: 570px;
	overflow: hidden;
	margin-top: 60px;
position: relative;
transition: margin-top 300ms linear;
-webkit-transition: margin-top 300ms linear;
}
body.home > section {
margin-top: 0;
}
article {
	position: absolute;
	top: 0;
	right: 0;
	left: 0;
	z-index: 1;
height: 570px;
}
article.next {
	top: 570px;
}
article > section {
	width: 960px;
	position: relative;
	margin: 0 auto;
	font-family: Arial;
	font-size: 12px;
}
article > section  > * {
	position: relative;
	z-index: 10;
}
article > section > img {
	position: absolute;
	top: 0;
	width: 1224px;
	height: 570px;
	left: 50%;
	margin-left: -612px;
	z-index: 1;
}
article > section > a {
	display: inline-block;
	position: relative;
	margin: 120px 0 43px;
	text-decoration: none;
	outline: none;
}

article > section > h1 {
	font-family: "museo";
	font-size: 77px;
	line-height: 68px;
	color: #000;
	width: 408px;
	margin: 0;
	letter-spacing: -0.05em;
}
article > section > p {
	width: 480px;
}
article > section > h2 {
	height: 57px;
	margin: 0;
}
article > section > h2 a {
	margin: 0 0 0 10px;
	display: inline-block;
	height: 57px;
	WIDTH: 57px;
	color: #fff;
	text-align: center;
	line-height: 57px;
	text-decoration: none;
	background: url("data:image/png;base64,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");
}
article > section > h2 a:hover { 
background-position: 0 -57px;
}
article > section > h2 a:active{ 
background-position: 0 -114px;
}

article#home {
background: rgb(255,255,255);
background: -moz-linear-gradient(top,  rgba(255,255,255,1) 0%, rgba(221,221,221,1) 100%);
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(255,255,255,1)), color-stop(100%,rgba(221,221,221,1)));
background: -webkit-linear-gradient(top,  rgba(255,255,255,1) 0%,rgba(221,221,221,1) 100%);
background: -o-linear-gradient(top,  rgba(255,255,255,1) 0%,rgba(221,221,221,1) 100%);
background: -ms-linear-gradient(top,  rgba(255,255,255,1) 0%,rgba(221,221,221,1) 100%);
background: linear-gradient(to bottom,  rgba(255,255,255,1) 0%,rgba(221,221,221,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#dddddd',GradientType=0 );
}

nav {
position: absolute;
z-index: 10;
background: red;
height: 60px;
line-height: 60px;
top: 0px;
left:0;
right: 0;
font-family: 'Roboto', sans-serif;
background: rgb(56,56,56);
background: -moz-linear-gradient(top,  rgba(56,56,56,1) 0%, rgba(5,5,5,1) 100%);
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(56,56,56,1)), color-stop(100%,rgba(5,5,5,1)));
background: -webkit-linear-gradient(top,  rgba(56,56,56,1) 0%,rgba(5,5,5,1) 100%);
background: -o-linear-gradient(top,  rgba(56,56,56,1) 0%,rgba(5,5,5,1) 100%);
background: -ms-linear-gradient(top,  rgba(56,56,56,1) 0%,rgba(5,5,5,1) 100%);
background: linear-gradient(to bottom,  rgba(56,56,56,1) 0%,rgba(5,5,5,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#383838', endColorstr='#050505',GradientType=0 );
text-align: center;
transition: top 300ms linear;
-webkit-transition: top 300ms linear;
}
.home nav {
	top: 570px;
}
nav a {
font-size: 14px;
color: #e3e3e3;
text-decoration: none;
display: inline-block;
padding: 0 35px;
text-transform: uppercase;
background:url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAARCAYAAAAcw8YSAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyBpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMC1jMDYwIDYxLjEzNDc3NywgMjAxMC8wMi8xMi0xNzozMjowMCAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNSBXaW5kb3dzIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOjhDQzc3RDk2NkY3MTExRTI4NTUwRkQ5QTI3QUNGMEYwIiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOjhDQzc3RDk3NkY3MTExRTI4NTUwRkQ5QTI3QUNGMEYwIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6OENDNzdEOTQ2RjcxMTFFMjg1NTBGRDlBMjdBQ0YwRjAiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6OENDNzdEOTU2RjcxMTFFMjg1NTBGRDlBMjdBQ0YwRjAiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz67hpGUAAAALUlEQVR42oSKMQ4AIBDCkP9/F9aa0zi7kNLUSbCkNSMBclsujZp76Ne9mC3AAE0QH3OPMB3lAAAAAElFTkSuQmCC") 0 50% no-repeat;
}
nav a[rel=home] {
text-indent: -1000px;
width: 160px;
overflow: hidden;
background: url(./images/nav-logo.png) no-repeat;
padding: 0 15px 0 0;
}
</style>
<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<script src="https://raw.github.com/balupton/history.js/master/scripts/bundled/html4+html5/jquery.history.js"></script>
<script>
var allpages, baseURL='/activewin/';
$(function(){
	$.getJSON('all',function(data){
		allpages = data
	})
	var History = window.History;
	if (!History.enabled) {
		return false;
	}
	History.Adapter.bind(window,'statechange',function(){
		var State = History.getState(),
				nextArticle = $(State.data[2]).addClass('next');
		$('body>section').append(nextArticle);
		nextArticle.animate({top: 0} , 300 , function(){$('section>article:first').remove();});
	});
	$('a:not([href^=http])').click(function(){
		var page = allpages[$(this).attr('rel')];
		var url = $(this).attr('rel');
		$('body').removeClass().addClass(url);
		if (url==='home') url = '';
		History.pushState(page,page[0],baseURL + url);
		return false;
	})
})
</script>
<script type="text/javascript" src="//use.typekit.net/txb5apz.js"></script>
<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
</head>
	<body class="<?php echo $page;?>">
<nav>
	<a rel=home href="./">Home</a><a rel=about href="about">About us</a><a rel=testimonials href="testimonials">Testimonials</a><a rel=contact href="contact">Contact us</a>
</nav>
<section><?php echo $tpl[$page][2];?></section>
</body>
</html>
