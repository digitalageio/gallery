@extends('layout.main')

@section('content')
    <form action="{{ URL::route('account-change-password-post') }}" method="post">
        <div class="field">
            Old Password: <input type="password" name="old_password">
            @if($errors->has('old_password'))
                    {{ $errors->first('old_password') }}
            @endif
        </div>
        <div class="field">
            New Password: <input type="password" name="password">
            @if($errors->has('password'))
                    {{ $errors->first('password') }}
            @endif
        </div>
        <div class="field">
            Confirm Password: <input type="password" name="password_confirm">
            @if($errors->has('password_confirm'))
                    {{ $errors->first('password_confirm') }}
            @endif
        </div>
        {{ Form::token() }}
        <input type="submit" value="Change password">
    </form>
@stop
