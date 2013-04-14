@layout('master')

@section('title') | {{ $portfolio->title }}@endsection

@section('content')
	{{ render('portfolios.info', array('h1' => $portfolio->title)) }}

	<p>{{ $portfolio->description }}</p>

	<a href="/uploads/{{ $portfolio->id }}/{{ $portfolio->img }}">
		{{ HTML::image('/uploads/'.$portfolio->id.'/thumb_'.$portfolio->img) }}
	</a>

	@if($portfolio->info)
		<table>
			<tr>
				<th>KEY</th>
				<th>VALUE</th>
			</tr>

			@foreach($portfolio->info as $row)
				<tr>
					<td>{{ $row[0] }}</td>
					<td>{{ $row[1] }}</td>
				</tr>
			@endforeach
		</table>
	@endif
@endsection