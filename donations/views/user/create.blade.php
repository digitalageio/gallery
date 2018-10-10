@extends('layout.main')

@section('content')
    @if(!empty($manual))
        @if($manual)
    <form action="{{ URL::route('user-add-user-manual-post') }}" method="post">
        <div class="field">
            Is a Manager of this account? <input type="checkbox" id="is_manager" name="is_manager" value="1">
        </div>
        @endif
    @else
    <form action="{{ URL::route('user-create-post') }}" method="post">
    @endif
        <div class="field">
            Email: <input type="text" name="email" {{ (Input::old('email')) ? 'value="' . e(Input::old('email')) . '"' : '' }}>
            @if($errors->has('email'))
                {{ $errors->first('email') }}
            @endif
        </div>
        <div class="field">
            Username: <input type="text" id="username" name="username" {{ (Input::old('username')) ? 'value="' . e(Input::old('username')) . '"' : '' }}>
            @if($errors->has('username'))
                {{ $errors->first('username') }}
            @endif
        </div>
        <div class="field">
            Password: <input type="password" id="password" name="password">
            @if($errors->has('password'))
                {{ $errors->first('password') }}
            @endif
        </div>
        <div class="field">
            Confirm password: <input type="password" id="password_again" name="password_again">
            @if($errors->has('password_again'))
                {{ $errors->first('password_again') }}
            @endif
        </div>
        <input type="submit" value="Create account" />
        {{ Form::token() }}
    </form>
@stop
