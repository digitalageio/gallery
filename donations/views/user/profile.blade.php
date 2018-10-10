@extends('layout.main')
@section('content')
	@if(!empty($asUser))
		{{ $asUser->username }}
		{{ $asUser->first_name }}
		@include('donation.add')
		@foreach($asUser->donations as $d)
			{{ $d->amount }} <br />
		@endforeach
	@else
		@if(empty($asUser))
			Error: could not retrieve a User with the username: {{ $lookup }}
		@endif
	@endif
@stop