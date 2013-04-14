@layout('master')

@section('title') | New Portfolio@endsection

@section('content')

	{{ render('portfolios.info', array('h1' => 'New Portfolio')) }}

	<div class="pm-ctn">
		{{ Form::open_for_files('portfolios/create', 'POST', array('id' => 'new_portfolio', 'class' => 'new_portfolio')); }}

			@if (count($errors->messages) > 0)
				<div class="pm-error">
					<div class="pm-error-title">Error! The following problems occured:</div><!-- .pm-error-title -->

					<ul>
						@foreach ($errors->messages as $error)
							<li>{{ $error[0] }}</li>
						@endforeach
					</ul>
				</div><!-- .pm-error -->
			@endif

			<div class="pm-action-bar">
				{{ Form::submit('Create', array('class' => 'pm-btn')); }}
			</div><!-- .pm-action-bar -->


			<div class="pm-form-ctn">
				{{ Form::label('title', 'Title:'); }}
				{{ Form::text('title', null, array('placeholder' => 'Add a title for the portfolio...')); }}

				{{ Form::label('description', 'Description:'); }}
				{{ Form::textarea('description', null, array('placeholder' => 'Add a description for the portfolio...')); }}
			</div><!-- .pm-form-ctn -->

			<br />

			<div class="pm-form-ctn">
				<div class="pm-form-info-add">
					<a href="#">{{ HTML::Image('/img/plus-icon.png'); }}</a>
				</div><!-- .pm-form-info-add -->

				<div class="pm-form-info-header">
					Info Table: 
				</div><!-- .pm-form-info-header -->

				<p>
					Enter key/value pairs to be entered into the info table of the portfolio.
				</p>

				<div class="pm-form-info"></div><!-- .pm-form-info -->
			</div><!-- .pm-form-ctn -->

			<br />

			<div class="pm-form-ctn">
				{{ Form::label('img', 'Upload Image:'); }}

				<div class="pm-upload">
					<div class="pm-upload-img">
						<p>Upload a new file.</p>

						{{ Form::file('img'); }}
					</div><!-- .pm-upload-img -->

					<div class="pm-current-img"></div><!-- .pm-current-img -->
				</div><!-- .pm-upload -->
			</div><!-- .pm-form-ctn -->

			{{ Form::hidden('info', null, array('id' => 'portfolio_info')); }}
		{{ Form::close(); }}
	</div><!-- .pm-ctn -->
@endsection