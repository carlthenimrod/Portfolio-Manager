@layout('master')

@section('title') | Login@endsection

@section('content')
	<div class="pm-ctn">
		@if (Session::get('failed'))
			<div class="pm-error pm-error-sign-in">
				<div class="pm-error-title">Error! The following problems occured:</div><!-- .pm-error-title -->

				<ul>
					<li>{{ Session::get('failed') }}</li>
				</ul>
			</div><!-- .pm-error -->
		@endif

		<div class="pm-sign-in">
			<p>Please Login Below!</p>

			{{ Form::open('portfolios/session') }}
				<div class="pm-text-field">
					{{ Form::label('email', 'Email:'); }}
					{{ Form::text('email', null, array('autofocus' => 'autofocus')) }}
				</div><!-- .pm-text-field -->

				<div class="pm-text-field">
					{{ Form::label('password', 'Password:'); }}
					{{ Form::password('password'); }}
				</div><!-- .pm-text-field -->	

				<div class="pm-sign-in-button">
					{{ Form::submit('Login', array('class' => 'pm-btn')); }}
				</div>
			{{ Form::close() }}
		</div><!-- .pm-sign-in -->
	</div><!-- .pm-ctn -->
@endsection