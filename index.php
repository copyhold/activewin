<?php
$tpl = [];
foreach(explode(' ','services mobile testimonials home about clients') as $f) {
	$filename = "tpl/$f.html";
	if (!file_exists($filename)) continue;
	$fp = fopen($filename,'r');
	$tpl[$f] = [trim(fgetss($fp)),trim(fgetss($fp)),fread($fp,10000)];
}
$page = $_GET['_escaped_fragment_'];

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
<!DOCTYPE html>
<html>
<head>
<title><?php echo $tpl[$page][0];?></title>
<meta name=description value="<?php echo $tpl[$page][1];?>" />
<link href='http://fonts.googleapis.com/css?family=Roboto:700,400,900' rel='stylesheet' type='text/css'>
<link href='style.css' rel='stylesheet' type='text/css'>
<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<script>
document.createElement('SECTION');
document.createElement('NAV');
document.createElement('ARTICLE');
document.createElement('FOOTER');
document.createElement('ASIDE');
document.createElement('HEADER');
var allpages, currentPage;
$(function(){
	if (parseInt(navigator.appVersion.match(/MSIE (\d)/)[1])<9) {
		$('html').addClass('ie')
	}
	$.getJSON('?_escaped_fragment_=all',function(data){
		allpages = data
		for (page in data) {
			if (!data.hasOwnProperty(page)) continue;
			$('#section').append(data[page][2]);
		}
		$('body>section>article:first').remove();

		setInterval(function(){
			var testimonialsRot = $('#rotation');
			var testimonials = $(allpages.testimonials[2]).find('ul');
				if (testimonialsRot.length===0) {
				testimonialsRot = $('<DIV id=rotation />').append(testimonials.clone()).insertBefore('footer');
				testimonialsRot.append('<i class=next></i>').prepend('<i class=back></i>');
				testimonialsRot.find('li').each(function() {
					var author = $(this).find('cite').remove();
					var text = $(this).text().replace('"','');
					$(this).empty().append($('<button />') , text.split(/[^A-Za-z0-9]/).splice(0,30).join(' ') , $('<button />') , author);
				})
				return;
			}
			var onegoesleft = testimonialsRot.find('li:eq(0)');
			onegoesleft.animate({"margin-left": "-900px"}, function(){
				onegoesleft.parent().append(onegoesleft);
				onegoesleft.css('margin-left',0);
			});
		} , 5000); // rotate testimonials on home

		$('form header i, .lb').click(function(){
			$('body').removeClass('contact');
			$('form').animate({top: -1000},1000,function() {$('form').removeClass('sent')});
			$('html,body').animate({ scrollTop: 0} , 1000);
		})
		$('form').submit(function(e){
			e.preventDefault();
			$('.error', $(this)).removeClass('error');
			$('form *[required]').filter(function(){return $(this).val().length<3}).parent('label').addClass('error');
			if ($('form .error').length>0) {
				$('form button').addClass('error');
			} else {
				$('form').addClass('wait');
				$.post('send.php',$('form').serialize(),function(d) {
					$('form').removeClass().addClass('sent').append($('<p>').text('Your message has been sent successfully. We will get back to you as soon as possible.').fadeIn(700));
				}, 'json');
			}
		});
		$('a[href=#contact]').click(function(e) {
			e.preventDefault();
			$('body').toggleClass('contact');
			$('form').animate({top: 200},1000);
			$('html,body').animate({ scrollTop: 150} , 1000);
			$('form input:eq(0)').focus();
		});
		setInterval(function(){
			var newPage =location.hash.substr(2); 
			if (newPage==currentPage) return;
			var allPagesIndex = newPage==='' ? 'home' : newPage;
			if (typeof allpages[allPagesIndex]==='undefined') return false;
			$('body').removeClass().addClass(allPagesIndex);
			$('body>section').height($('#' + allPagesIndex).height() + 60);
			var hroffset = allPagesIndex==='home' ? 0 : 60;
			$('#' + allPagesIndex).prevAll('article').each(function(){
				hroffset -= $(this).height();
			});
			$('nav a').removeClass('active');

			$('nav a[href="' + location.hash + '"]').append($('#corner')).delay(1000).addClass('active');
			$('section > article:first').animate({'margin-top':hroffset},700);
			window.title = allpages[allPagesIndex][0];
			currentPage = newPage;
		} , 100);
		$('nav').append($('<i id=corner />'))
		setTimeout(function() { 
			$('html').addClass('loaded');
		}, 1000);
	})

})
</script>
<script type="text/javascript" src="//use.typekit.net/txb5apz.js"></script>
<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
</head>
<body class="<?php echo $page;?>">
<section id="section">
<nav> <a rel=home href="#!">Home</a><a href="#!services" rel=services>our services</a><a href="#!mobile" rel="mobile">mobile</a><a href="#!clients" rel="clients">clients</a><!--a rel=about href="#!about">About us</a--><a rel=testimonials href="#!testimonials">Testimonials</a><a rel=contact href="#contact">Contact us</a> </nav>
<?php echo $tpl[$page][2];?>
</section>
<footer>Copyright &copy; 2013 ActiveWin.com All Rights Reserved 2013. The ActiveWin.com brand and logo are trademarks of ActiveWin.com <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACMAAAAPCAYAAABut3YUAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyBpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMC1jMDYwIDYxLjEzNDc3NywgMjAxMC8wMi8xMi0xNzozMjowMCAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNSBXaW5kb3dzIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOjRDNzgwRTMxNzQzQjExRTI4MjE3QjczNkI1OThDNUQwIiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOjRDNzgwRTMyNzQzQjExRTI4MjE3QjczNkI1OThDNUQwIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6NEM3ODBFMkY3NDNCMTFFMjgyMTdCNzM2QjU5OEM1RDAiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6NEM3ODBFMzA3NDNCMTFFMjgyMTdCNzM2QjU5OEM1RDAiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz6KW/VfAAACKklEQVR42qxVPUgcQRR+I3cS3Ds1p42ICQZTpEstERH864QgYpPGIqVFikDiERBPQhIwYqeFWFoJdv4UImJqOwVBiBCFEEJyeLp7szPjvLfsZe921j2XPFjem5333X7vm3dvmFIKHhf2Fecc6rV0Og3f8/3MtDcyOaMggW2vzzPW8WFXZVstyFqNdQP//LXh+uoGLmYHqwgNTbxXz/uGk3CBo4MdSGFwHyJorS0PiEytSSHBtl0o/r6KxmYaYGq8F3JaALT84jY05zLAueuRKdkObRxP95J/tvQtnpEIH6uQEoQrQAgRCZsaf1EhQhidixipsSn4j4Y/yLU67h1kfCJf1/bh4meRYsQIIqMr5I7Xcz1fDuv+MCvbRmU412RcGdq7LhWr1ien5+SbrGbCSKkgxcocpCrTxtnbAfJPPu9FxhUypZJBGaVll8ZjWp5/ZVxPz20QBlVtYJqxU3bo8S0Y+0T8uDY3aNiEnAutTPiJMtxDDBLSxyTuPI7Owhb5H/nRqveKmwlhv5h65nV+nfxKYbJq7WO8nnHsRM3KtArRPSNi8cEc6hlUhukKVSIyjnHORCljUjCsTMT5x5IxVN+Ws+Bp90M99NKx+O6u9kqMQ+/mMquVcd1Qf9TGprWSrnnWCEUKxc6kQA5iFP61qcrLX6A62utXRecHi/hH0COSabEisZ9WvfEQzJHCmzMMb+1HLz/eu23ON94Zb+2+sTeJbu2DzQV2K8AAxW1UOh/dT60AAAAASUVORK5CYII=" /></footer>
<form>
<header><i></i>To embrace a marketing superpower <br>and grow your business, contact us today</header>
<label>Name<sup>*</sup><input value="" name=name required /></label>
<label>Email<sup>*</sup><input name=email value="" type="email" required /></label>
<label>Phone<input type="phone" name=phone value="" /></label>
<label style="height: 190px;">Message<sup>*</sup><textarea name=text resizable="0" required></textarea></label>
<button type=submit>Send</button>
<span>Please complete all fields outlined in red</span>
</form>
<div class=lb></div>
</body>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-38985936-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</html>
