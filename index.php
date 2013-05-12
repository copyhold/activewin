<?php
$tpl = [];
foreach(explode(' ','services mobile testimonials home about press clients') as $f) {
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
<meta http-equiv="X-UA-Compatible" content=" chrome=1" />
<link href='http://fonts.googleapis.com/css?family=Roboto:700,400,900' rel='stylesheet' type='text/css'>
<link rel="shortcut icon" href="favicon.png" type="image/png">
<link href='style.css' rel='stylesheet' type='text/css'>
<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<script src='//google.com/tools/dlpage/res/chromeframe/script/CFInstall.min.js'></script>
<script>
CFInstall.require();
</script>
<script>
document.createElement('SECTION');
document.createElement('NAV');
document.createElement('ARTICLE');
document.createElement('FOOTER');
document.createElement('ASIDE');
document.createElement('HEADER');
var allpages, currentPage;
$(function(){
	var IE = navigator.appVersion.match(/MSIE (\d)/)
	if (IE && parseInt(IE[1])<9) {
		$('html').addClass('ie')
	}
	$.getJSON('?_escaped_fragment_=all',function(data){
		allpages = data
		for (page in data) {
			if (!data.hasOwnProperty(page)) continue;
			$('#section').append(data[page][2]);
		}
		$('body>section>article:first').remove();

		var Testi = function(){
			var testimonials;
			var pause = false;

			function moveLeft(e) {
				if (pause && typeof e=='undefined') return;
				var onegoesleft = testimonialsRot.find('li:eq(0)');
				if (onegoesleft.is(':animated')) return;
				onegoesleft.animate({"margin-left": "-900px"}, function(){
					onegoesleft.parent().append(onegoesleft);
					onegoesleft.css('margin-left',0);
				});
				setPause(typeof e=='object');
			}
			function moveRite(e) {
				if (pause && typeof e=='undefined') return;
				var onegoesrite = testimonials.find('li:last');
				var onegoesleft = testimonials.find('li:eq(0)');
				if (onegoesleft.is(':animated')) return;
				onegoesrite.css('margin-left','-900px');
				onegoesleft.parent().prepend(onegoesrite);
				onegoesrite.animate({'margin-left':'0px'},function(){});
				setPause(typeof e=='object');
			}
			function setPause(pauseme) {
				if (!pauseme) return;
				pause = true;
				setTimeout(function() { pause = false; }, 5000);
			}
			var init = function(){
				testimonialsRot = $('<DIV id=rotation />').append($(allpages.testimonials[2]).find('ul').clone()).insertBefore('footer');
				testimonials = testimonialsRot.find('ul');
				testimonialsRot.append($('<i class=next></i>').click(moveRite)).prepend($('<i class=back></i>').click(moveLeft));
				testimonialsRot.find('li').each(function() {
					var author = $(this).find('cite').remove();
					var text = $(this).attr('data-text');
					if (!text) text = $(this).text().replace('"','');
					$(this).empty().append($('<button />') , text.split(/[^A-Za-z0-9]/).splice(0,30).join(' ') , $('<button />') , author);
				})
				setInterval(moveLeft,5000);
			}
			return { init: init };
		}
		var testi = new Testi();
		testi.init();


		$('form header i, .lb').click(function(){
			$('body').removeClass('contact');
			$('form').animate({top: -1000},1000,function() {$('form').removeClass('sent')});
			$('form>p').remove();
			$('form input,form textarea').val('');
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
<footer>Copyright &copy; 2013 ActiveWin.co.uk All Rights Reserved 2013. The ActiveWin.com brand and logo are trademarks of ActiveWin.co.uk <a href="https://www.facebook.com/ActiveWinLtd?fref=ts" class=fb>facebook</a><a href="http://www.linkedin.com/company/active-win?trk=top_nav_home" class=linkedin>linkedin</a></footer>
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
