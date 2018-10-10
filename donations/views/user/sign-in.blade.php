@extends('layout.main')

@section('content')
    <form action="{{ URL::route('user-sign-in-post') }}" method="post">
        <div class="field">
            Username: <input type="text" name="username" {{ (Input::old('username')) ? 'value="' . Input::old('username') . '"' : '' }}>
            @if($errors->has('username'))
                {{ $errors->first('username') }}
            @endif
        </div>
        <div class="field">
            Password: <input type="password" name="password" {{ (Input::old('password')) ? 'value="' . Input::old('password') . '"' : '' }}>
            @if($errors->has('password'))
                {{ $errors->first('password') }}
            @endif
        </div>
        <div class="field">
            <input type="checkbox" name="remember" id="remember">
            <label for="remember">
                Remember me
            </label>
        </div>
        <input type="submit" value="Sign in">
        {{ Form::token() }}
    </form>
@stop
