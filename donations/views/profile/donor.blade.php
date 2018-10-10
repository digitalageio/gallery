@extends('layout.main')

@section('content')

@if(((Auth::user()->id) === ($donor->users_id)) || ((Auth::donor()->id) === ($donor->id)))
	Edit donor
	@include('account.editDonor')
@endif

	{{ $donor->is_manager }}
	{{ $donor->users_id }}
    {{ $donor->username }}
    {{ $donor->email }}

@include('account.addDonation')

@stop
