@extends('layout.main')

@section('content')

    @if(!empty($account))
    You are already an administrator for "{{ $account->name }}". Policy prevents a user from administrating more than one account at a time. If you wish to edit this account's settings, <a href={{ '/account/' . $account->subdomain }}>click here.</a>
    @else
    <form action="{{ URL::route('create-account-post') }}" id="general" method="post">
        General Settings <hr>
        <div class="field">
            Organization name: <input type="text" name="name">
            @if($errors->has('name'))
                    {{ $errors->first('name') }}
            @endif
        </div>
        <div class="field">
            Subdomain: <input type="text" name="subdomain">
            @if($errors->has('subdomain'))
                    {{ $errors->first('subdomain') }}
            @endif
        </div>
        <div class="field">
            Support email address: <input type="text" name="support_email">
            @if($errors->has('support_email'))
                    {{ $errors->first('support_email') }}
            @endif
        </div>
                {{ Form::token() }}
        <input type="submit" value="Create">
    </form>
    @endif

 
@stop
