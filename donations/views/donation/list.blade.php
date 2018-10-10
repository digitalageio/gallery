@extends('layout.main')

@section('content')

@include('donation.add')
{{ $account->id }}
<ul>
@if(!empty($donations))
	@foreach($donations as $donation)
		<li>Donor: {{ $donation->user->first_name }} {{ $donation->user->last_name }} Amount: {{ $donation->amount}} Submitted: {{ $donation->submitted_at }} Type: {{ $donation->type }}</li>
	@endforeach
@endif
</ul>

@stop