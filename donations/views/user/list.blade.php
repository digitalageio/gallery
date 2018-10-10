@extends('layout.main')

@section('content')
{{ $account->id }} : {{ $user->id }}
@foreach($userlist as $u)
	{{ $u->username }}
@endforeach

@stop
