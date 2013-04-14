@layout('master')

@section('title') | Portfolio Manager@endsection

@section('content')

	{{ render('portfolios.info', array('h1' => 'Portfolio Manager')) }}

	<div class="pm-ctn">
		@if (Session::get('success'))
			<div class="pm-success">
				{{ Session::get('success') }}
			</div><!-- .pm-success -->
		@endif

		{{ Form::open('portfolios/update_multiple'); }}
			<div class="pm-action-bar">
				{{ Form::submit('Save', array('class' => 'pm-btn')); }}

				{{ HTML::link(URL::to_route('new'), 'Add New', array('class' => 'pm-btn')) }}
			</div><!-- .pm-action-bar -->

			<ul class="pm-index-header">
				<li class="pm-index-header-order">Order #</li><!-- .pm-index-header-order -->
				<li class="pm-index-header-item">Item &nbsp;&nbsp;<i>**Click Item to Edit Info**</i></li><!-- .pm-index-header-item -->
				<li class="pm-index-header-delete">Delete</li><!-- .pm-index-header-delete -->
			</ul><!-- .pm-index-header -->

			<div class="pm-index-body">
				@foreach ($portfolios as $portfolio)
					<div class="pm-index-item">
						<div class="pm-index-order">
							<input type="textfield" maxlength="1" name="order_ids[{{ $portfolio->id }}][order_id]" value="{{ $portfolio->order_id }}" />
						</div><!-- .pm-index-order -->

						<a href="{{ URL::to_route('edit', array('id' => $portfolio->id)) }}" class="pm-index-item-body" 
							alt="{{ $portfolio->title }}">
							<ul>
								<li class="pm-index-title">{{ $portfolio->title }}</li><!-- .pm-index-title -->
								<li class="pm-index-update">{{ date('F j, Y', strtotime($portfolio->updated_at)) }}</li><!-- .pm-index-update -->
								<li class="pm-index-thumb">
									{{ HTML::image('/uploads/'.$portfolio->id.'/thumb_'.$portfolio->img) }}
								</li><!-- .pm-index-thumb -->
							</ul>
						</a>

						<div class="pm-index-delete">
							<a href="{{ URL::to_route('delete', array('id' => $portfolio->id)) }}">
								{{ HTML::image('img/delete-icon.png', 'Delete') }}
							</a>
						</div><!-- .pm-index-delete -->
					</div><!-- .pm-index-item -->
				@endforeach
			</div><!-- .pm-index-body -->
		{{ Form::close(); }}	
	</div><!-- .pm-ctn -->
@endsection