@extends('layout.main')

@section('content')
    {{ $user->username }}
    {{ $user->email }}
@stop
