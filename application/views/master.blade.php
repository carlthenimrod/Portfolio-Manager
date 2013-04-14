<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Site Name@yield('title')</title>
	<meta name="viewport" content="width=device-width">
	{{ HTML::script('/js/jquery.js') }}
	{{ HTML::script('/js/portfolio.js') }}

	{{ HTML::style('/css/style.css') }}
</head>
<body>
	<header>
		<div class="wrapper">
		</div>
	</header>

	<div id="main">
		<div class="wrapper">
			@yield('content')
		</div>
	</div>

	<footer>
		<div class="wrapper">
		</div>
	</footer>
</body>
</html>