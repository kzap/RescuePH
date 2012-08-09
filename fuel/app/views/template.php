<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo $title; ?></title>
	<?php echo Asset::css('bootstrap.css'); ?>
	<style>
		body { margin: 40px; }
	</style>
	<!--<script type="text/javascript" src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=AIzaSyB2iWAYJDQbYu4WIMVHRJ0dKTDrNVpfYIc"></script>-->
	
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-347140-18']);
  _gaq.push(['_setDomainName', 'rescueph.com']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

</head>
<body>
	<div class="container">
		<div class="row">
			<div class="span16">
				<h1><?php echo $title; ?></h1>
				<hr>
<?php if (Session::get_flash('success')): ?>
				<div class="alert-message success">
					<p>
					<?php echo implode('</p><p>', e((array) Session::get_flash('success'))); ?>
					</p>
				</div>
<?php endif; ?>
<?php if (Session::get_flash('error')): ?>
				<div class="alert-message error">
					<p>
					<?php echo implode('</p><p>', e((array) Session::get_flash('error'))); ?>
					</p>
				</div>
<?php endif; ?>
			</div>
			<div class="span16">
<?php echo $content; ?>
			</div>
		</div>
		<footer>
			<p class="pull-right">Page rendered in {exec_time}s using {mem_usage}mb of memory.</p>
			<p>
				<a href="http://www.arnoldgamboa.com">- @arnoldgamboa -</a></small>
			</p>
		</footer>
	</div>
</body>
</html>
