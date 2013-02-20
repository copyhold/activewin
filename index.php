<?php
$tpl = [];
foreach(explode(' ','home services mobile testimonials about clients contact') as $f) {
	$filename = "tpl/$f.html";
	if (!file_exists($filename)) continue;
	$fp = fopen($filename,'r');
	$tpl[$f] = [trim(fgetss($fp)),trim(fgetss($fp)),fread($fp,10000)];
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
<link href='http://fonts.googleapis.com/css?family=Roboto:700,400' rel='stylesheet' type='text/css'>
<link href='style.css' rel='stylesheet' type='text/css'>
<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<script src="https://raw.github.com/balupton/history.js/master/scripts/bundled/html4+html5/jquery.history.js"></script>
<script>
var allpages, baseURL='/activewin/', currentPage;
$(function(){
	$.getJSON('all',function(data){
		allpages = data
		for (page in data) {
			if (!data.hasOwnProperty(page)) continue;
			$('body > section').append(data[page][2]);
		}
		$('body>section>article:first').remove();

		setInterval(function(){
			var testimonialsRot = $('body > ul');
			var testimonials = $(allpages.testimonials[2]).find('ul')
			if (testimonialsRot.length===0) {
				testimonialsRot = testimonials.clone()
				testimonialsRot.append('<li class=next>&gt;</li>').prepend('<li class=back>&lt;</li>');
				testimonialsRot.insertBefore('footer');
				return;
			}
			var onegoesleft = testimonialsRot.children('li:eq(1)');
			onegoesleft.animate({"margin-left": "-960px"}, function(){
				testimonialsRot.find('.next').before(onegoesleft);
				onegoesleft.css('margin-left',0);
			});
		} , 3000); // rotate testimonials on home

		setInterval(function(){
			var newPage =location.hash.substr(2); 
			if (newPage==currentPage) return;
			var allPagesIndex = newPage==='' ? 'home' : newPage;
			$('body').removeClass().addClass(allPagesIndex);
			$('body>section>article:first').css
			currentPage = newPage;	
		} , 100);	
	})

})
</script>
<script type="text/javascript" src="//use.typekit.net/txb5apz.js"></script>
<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
</head>
<body class="<?php echo $page;?>">
<section>
<nav> <a rel=home href="#!">Home</a><a href="#!services" rel=services>our services</a><a href="#!mobile" rel="mobile">mobile</a><a href="#!clients" rel="clients">clients</a><a rel=about href="#!about">About us</a><a rel=testimonials href="#!testimonials">Testimonials</a><a rel=contact href="#!contact">Contact us</a> </nav>
<hr>
<?php echo $tpl[$page][2];?>
</section>
<footer>Copyright &copy; 2013 ActiveWin.com All Rights Reserved 2013. The ActiveWin.com brand and logo are trademarks of ActiveWin.com <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACMAAAAPCAYAAABut3YUAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyBpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMC1jMDYwIDYxLjEzNDc3NywgMjAxMC8wMi8xMi0xNzozMjowMCAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNSBXaW5kb3dzIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOjRDNzgwRTMxNzQzQjExRTI4MjE3QjczNkI1OThDNUQwIiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOjRDNzgwRTMyNzQzQjExRTI4MjE3QjczNkI1OThDNUQwIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6NEM3ODBFMkY3NDNCMTFFMjgyMTdCNzM2QjU5OEM1RDAiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6NEM3ODBFMzA3NDNCMTFFMjgyMTdCNzM2QjU5OEM1RDAiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz6KW/VfAAACKklEQVR42qxVPUgcQRR+I3cS3Ds1p42ICQZTpEstERH864QgYpPGIqVFikDiERBPQhIwYqeFWFoJdv4UImJqOwVBiBCFEEJyeLp7szPjvLfsZe921j2XPFjem5333X7vm3dvmFIKHhf2Fecc6rV0Og3f8/3MtDcyOaMggW2vzzPW8WFXZVstyFqNdQP//LXh+uoGLmYHqwgNTbxXz/uGk3CBo4MdSGFwHyJorS0PiEytSSHBtl0o/r6KxmYaYGq8F3JaALT84jY05zLAueuRKdkObRxP95J/tvQtnpEIH6uQEoQrQAgRCZsaf1EhQhidixipsSn4j4Y/yLU67h1kfCJf1/bh4meRYsQIIqMr5I7Xcz1fDuv+MCvbRmU412RcGdq7LhWr1ien5+SbrGbCSKkgxcocpCrTxtnbAfJPPu9FxhUypZJBGaVll8ZjWp5/ZVxPz20QBlVtYJqxU3bo8S0Y+0T8uDY3aNiEnAutTPiJMtxDDBLSxyTuPI7Owhb5H/nRqveKmwlhv5h65nV+nfxKYbJq7WO8nnHsRM3KtArRPSNi8cEc6hlUhukKVSIyjnHORCljUjCsTMT5x5IxVN+Ws+Bp90M99NKx+O6u9kqMQ+/mMquVcd1Qf9TGprWSrnnWCEUKxc6kQA5iFP61qcrLX6A62utXRecHi/hH0COSabEisZ9WvfEQzJHCmzMMb+1HLz/eu23ON94Zb+2+sTeJbu2DzQV2K8AAxW1UOh/dT60AAAAASUVORK5CYII=" /></footer>
</body>

</html>
