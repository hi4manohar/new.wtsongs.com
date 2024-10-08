<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>Jekyll pjax demo</title>
	<link rel="stylesheet" href="/css/layout.css?1334952487" />
	<meta name="description" content="A basic Jekyll template designed to work with pjax">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<style type="text/css">
	.container {
		width:800px;
		margin:0 auto;
		font-family:Helvetica, Arial, sans-serif;
		font-size:13px;
	}
	
	#time {
		color:#888;
	}
	</style>
</head>
<body>	
	<div class="container">
		<div class="holder">
	
		<div class="header">
			<h1>Jekyll pjax demo</h1>	
			<p>
				This is a Jekyll template that's designed to work nicely with <a href="https://github.com/defunkt/jquery-pjax">pjax</a>.
			</p>
			<p>
				Current time: <span id="time"></span>
			</p>
			
			<ul>

					<?php include 'link.php'; ?>
	
			</ul>
			
		</div>
	
		<div id="main">
	<h1>Home</h1>

<p>This is the home page. You'll notice that the time stamp up above doesn't change as you click from page to page. However, if you refresh the page you should see it change. This tells you that pjax is working correctly.</p>
		
		</div>

		</div> <!-- /.holder -->
	</div>	<!-- /.container -->

<script src="/assets/js/pjax/jquery.js"></script>
<script src="/assets/js/pjax/jquery.pjax.js"></script>
<script src="/assets/js/pjax/script.js"></script>

</body>
</html>