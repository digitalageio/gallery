@extends('layout.main')

@section('content')
<form action="{{ URL::route('account-forgot-password-post') }}" method="post">
    <div class="field">
    <label for="email">
        Enter the email associated with your account:<br />
    </label>
        <input type="text" name="email" id="email" {{ (Input::old('email')) ? 'value="' . e(Input::old('email')) . '"' : ''}} >
    </div>
    @if($errors->has('email'))
        {{ $errors->first('email') }}
    @endif
    <br />
    {{ Form::token() }} 
    <input type="submit" value="Recover account">
</form>
@stop
