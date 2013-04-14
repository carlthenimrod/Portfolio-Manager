<div class="pm-user-info">
	@if (Auth::check())

		Logged in: <strong>{{ Auth::user()->email }}</strong>

		({{ HTML::link(URL::to_route('logout'), 'Logout') }}) &nbsp;&nbsp;|&nbsp;&nbsp;
		{{ HTML::link(URL::to_route('home'), 'Portfolios') }} &nbsp;&nbsp;|&nbsp;&nbsp;
		{{ HTML::link(URL::to_route('portfolios'), 'Portfolio Manager') }}
	@else
		{{ HTML::link(URL::to_route('login'), 'Click Here to Login') }}
	@endif
</div><!-- .pm-user-info -->

<h1>{{ $h1; }}</h1>