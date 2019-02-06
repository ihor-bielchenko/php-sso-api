<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	@include('base.meta')
</head>
<body class="root">
	@include('base.header')
	<div class="content__container position-absolute">
		@yield('content')
		@include('base.footer')
	</div>
	@include('forms.register')
</body>
</html>
