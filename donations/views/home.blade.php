@extends('layout.main')

@section('content')
    @if(Session::get('subdomain'))
        {{ Session::get('subdomain') }}
        <hr>
    @endif
@stop
