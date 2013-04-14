@layout('master')

@section('content')
	{{ render('portfolios.info', array('h1' => 'Portfolios')) }}

	<ul class="pm-portfolios">
		@foreach($portfolios as $portfolio)
			<li>
				<a href="/{{ $portfolio->id }}" alt="{{ $portfolio->title }}">
					{{ HTML::image('/uploads/'.$portfolio->id.'/thumb_'.$portfolio->img, $portfolio->title) }}
					{{ $portfolio->title }}
				</a>
			</li>
		@endforeach
	</ul>
@endsection