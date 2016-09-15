<!DOCTYPE HTML>
<!--
	Identity by HTML5 UP
	html5up.net | @n33co
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<?php
$user = "";
$pass = "";
if (isset($_GET['u'])) {
     $user = $_GET['u'];
}
if (isset($_GET['p'])) {
     $pass = $_GET['p'];
}
?>
<html>
	<head>
		<title>Patton Secret Santa</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!--[if lte IE 8]><script src="assets/js/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="assets/css/main.min.css" />
		<!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->
		<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
	</head>
	<body class="">

		<!-- Wrapper -->
			<div id="wrapper">

				<!-- Main -->
					<section id="main">
						<header>
							<span class="avatar"><img src="images/christmas-presents-red.jpg" alt="" /></span>
							<h1>2016 Patton Gift Exchange</h1>
						</header>
						
						<hr />
						<h2 class="loggedout">Login to see who you have</h2>
						<h4 class="hide loggedout loginerror">Oh no! I couldn't log you in. Please try agian.</h4>
						<h4 class="hide loggedout loginerror">If you keep getting this error, please contact Justin.</h4>
						<form method="post" action="#" class="loggedout">
							<div class="field">
								<input type="text" name="name" id="name" placeholder="Name" value="<?php echo $user ?>"/>
							</div>
							<div class="field">
								<input type="password" name="password" id="password" placeholder="Password" value="<?php echo $pass ?>"/>
							</div>
							
							
							<ul class="actions">
								<li><a class="button">See Who You Have!</a></li>
							</ul>
						</form>

						<div class="loggedin hide">
							<h1 style="margin:0"><span id="secretSanta"></span>, you have</h1>
							<h1 id="giftee"></h1>
						</div>

						<!--
						<hr />
						<footer>
							<ul class="icons">
								<li><a href="#" class="fa-twitter">Twitter</a></li>
								<li><a href="#" class="fa-instagram">Instagram</a></li>
								<li><a href="#" class="fa-facebook">Facebook</a></li>
							</ul>
						</footer>
						-->

					</section>

				<!-- Footer -->
					<footer id="footer">
						<ul class="copyright">
							<li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
						</ul>
					</footer>

			</div>

		<!-- Scripts -->
			<!--[if lte IE 8]><script src="assets/js/respond.min.js"></script><![endif]-->
			<script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
			<script>
				if ('addEventListener' in window) {
					window.addEventListener('load', function() { document.body.className = document.body.className.replace(/\bis-loading\b/, ''); });
					document.body.className += (navigator.userAgent.match(/(MSIE|rv:11\.0)/) ? ' is-ie' : '');
				}

				$('.actions a.button').click(function(event){
					event.preventDefault();
					$.ajax({
						url: "login.php?" + $('form').serialize(),
						dataType: 'json',
						success: function(result){
							console.log(result);
							if(result.loggedin=='true'){
								$('#secretSanta').text(result.name);
								$('#giftee').text(result.giftee);
								$('.loggedout').hide();
								$('.loggedin').show();
							} else {
								$('.loginerror').show();
							}
						}
					});
				});

				<?php 
				if($user != "" && $pass != ""){
				?>
				$(document).ready(function(){
					$('.actions a.button').click();
				});
				<?php
				}
				?>

				(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
				(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
				m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
				})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
				
				ga('create', 'UA-75794674-1', 'auto');
				ga('send', 'pageview');
			</script>

	</body>
</html>
