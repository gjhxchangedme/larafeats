<!DOCTYPE html>
<html>
	<head>
		<title>Larafeats</title>

		<link href="{{ asset('css/app.css') }}" rel="stylesheet" />
		<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>

		@yield('styles')
	</head>
	<body>
		@yield('content')
		@yield('scripts')
	</body>
</html>
