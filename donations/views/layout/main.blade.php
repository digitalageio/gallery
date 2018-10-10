<!DOCTYPE html>
<html>
    <head>
        <title>Authentication System</title>
        @include('layout.includes')
    </head>
    <body>
    <div class="page">
        <header>
            <div class="logo">
                <a href="{{ URL::home }}">Donations</a>
            </div>
            @if(Auth::check())
            <div class="topNav link">
                <a href="{{ URL::route('user-add-user-manual') }}">+Add Donor</a>
            </div>
            <div class="topNav link">
            <a href="{{ URL::route('account-change-settings') }}"><img class="settings-icon" src="{{ URL::asset('assets/gear.png') }}">Settings</a>
            </div>
            <div class="search">
                @include('layout.search')
            </div>
            @if(!empty($user))
            <div class="user link">
                @if(!empty($user->profile_icon))
                <img class="profile-icon" src="{{ '/uploads/users/' . $user->username . '/' . $user->profile_icon }}" />
                @else
                <img class="profile-icon" src="{{ URL::asset('assets/default.png') }}" />
                @endif
                @if(!empty($user->first_name) && !empty($user->last_name))
                <a href={{ URL::route('user-change-settings') }}>{{ $user->first_name . ' ' . $user->last_name }}</a>
                @else
                <a href={{ URL::route('user-change-settings') }}>{{ $user->username }}</a>
                @endif
            </div>
            @endif
            @else
            <div class="topNav link">
                <a href="{{ URL::route('user-sign-in') }}">Sign In</a>
            </div>
            <div class="topNav link">
                <a href="{{ URL::route('user-create') }}">Register</a>
            </div>
            @endif
        </header>
        @if(Auth::check())
            <div class="navContainer">
            @include('layout.navigation')
            </div>
        @endif
            <div class="title">
            @if(!empty($title))
            {{ $title }}
            @endif
            </div>
            @if(!empty($global))
            {{ $global }}
            @endif
            <div class="content">
            @yield('content')
            </div>
    </page>
    </body>
</html>
