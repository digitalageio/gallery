@extends('layout.main')

@section('content')
	<ul class="stats">
	@foreach($stats as $name => $num)
		<li>{{ $name }}: {{ $num }}</li>
	@endforeach
	</ul>
	<br />
	<ul class="months">
	</ul>
	<ul class="donation-list">
	@foreach($donations as $d)
		<li class="donation-li">
			<div class="donation">
				<span class="editable-icon">
				@if($d->editable() === true)
					edit link
				@else &nbsp;
				@endif
				</span>
				<span class="donation-amount">{{ $d->amount }}</span>
				<span class="donor-name">{{ $d->user->first_name }} {{ $d->user->last_name }}</span>
				<span class="donation-date">{{ date('m/d/Y',strtotime($d->user->created_at)) }}</span>
			</div>
		</li>
	@endforeach
	</ul>
@stop