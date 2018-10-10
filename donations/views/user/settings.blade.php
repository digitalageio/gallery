@extends('layout.main')

@section('content')

    <form action="{{ URL::route('user-change-password-post') }}" method="post">
        Password Settings <hr>
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
        <input type="submit" value="Change Password">
    </form>

    <form action="{{ URL::route('user-change-info-post') }}" id="general" method="post">
        General Settings <hr>
        <div class="field">
            First name: <input type="text" name="first_name"  {{ ($user['first_name']) ? ' value="' . $user['first_name'] . '"' : '' }}>
            @if($errors->has('first_name'))
                    {{ $errors->first('first_name') }}
            @endif
        </div>
        <div class="field">
            Last name: <input type="text" name="last_name" {{ ($user['last_name']) ? ' value="' . $user['last_name'] . '"' : '' }}>
            @if($errors->has('last_name'))
                    {{ $errors->first('last_name') }}
            @endif
        </div>
        <div class="field">
            Phone number: <input type="text" name="phone_number" {{ ($user['phone_number']) ? ' value="' . $user['phone_number'] . '"' : '' }}>
            @if($errors->has('phone_number'))
                    {{ $errors->first('phone_number') }}
            @endif
        </div>
        <div class="field">
            Address: <input type="text" name="address" {{ ($user['address']) ? ' value="' . $user['address'] . '"' : '' }}>
            @if($errors->has('address'))
                    {{ $errors->first('address') }}
            @endif
        </div>
        <div class="field">
            City: <input type="text" name="city" {{ ($user['city']) ? ' value="' . $user['city'] . '"' : '' }}>
            @if($errors->has('city'))
                    {{ $errors->first('city') }}
            @endif
        </div>
        <div class="field">
            State:
            <input type="hidden" id="previous_state" value={{ ($user['state']) ? $user['state'] : 'TN' }}>
            <select name="state" id="state">
                <option value="AL">Alabama</option>
                <option value="AK">Alaska</option>
                <option value="AZ">Arizona</option>
                <option value="AR">Arkansas</option>
                <option value="CA">California</option>
                <option value="CO">Colorado</option>
                <option value="CT">Connecticut</option>
                <option value="DE">Delaware</option>
                <option value="DC">District Of Columbia</option>
                <option value="FL">Florida</option>
                <option value="GA">Georgia</option>
                <option value="HI">Hawaii</option>
                <option value="ID">Idaho</option>
                <option value="IL">Illinois</option>
                <option value="IN">Indiana</option>
                <option value="IA">Iowa</option>
                <option value="KS">Kansas</option>
                <option value="KY">Kentucky</option>
                <option value="LA">Louisiana</option>
                <option value="ME">Maine</option>
                <option value="MD">Maryland</option>
                <option value="MA">Massachusetts</option>
                <option value="MI">Michigan</option>
                <option value="MN">Minnesota</option>
                <option value="MS">Mississippi</option>
                <option value="MO">Missouri</option>
                <option value="MT">Montana</option>
                <option value="NE">Nebraska</option>
                <option value="NV">Nevada</option>
                <option value="NH">New Hampshire</option>
                <option value="NJ">New Jersey</option>
                <option value="NM">New Mexico</option>
                <option value="NY">New York</option>
                <option value="NC">North Carolina</option>
                <option value="ND">North Dakota</option>
                <option value="OH">Ohio</option>
                <option value="OK">Oklahoma</option>
                <option value="OR">Oregon</option>
                <option value="PA">Pennsylvania</option>
                <option value="RI">Rhode Island</option>
                <option value="SC">South Carolina</option>
                <option value="SD">South Dakota</option>
                <option value="TN">Tennessee</option>
                <option value="TX">Texas</option>
                <option value="UT">Utah</option>
                <option value="VT">Vermont</option>
                <option value="VA">Virginia</option>
                <option value="WA">Washington</option>
                <option value="WV">West Virginia</option>
                <option value="WI">Wisconsin</option>
                <option value="WY">Wyoming</option>
            </select>
            <script type="text/javascript">
                var previous_state = $("#previous_state").val();
                $("#state option[value="+previous_state+"]").attr('selected','selected');
            </script>
            @if($errors->has('state'))
                    {{ $errors->first('state') }}
            @endif
        </div>
        <div class="field">
            Zipcode: <input type="text" size="5" name="zipcode" {{ ($user['zipcode']) ? ' value="' . $user['zipcode'] . '"' : '' }}>
            @if($errors->has('zipcode'))
                    {{ $errors->first('zipcode') }}
            @endif
        </div>
                {{ Form::token() }}
        <input type="submit" value="Save General Settings">
    </form>

    <form action="{{ URL::route('user-change-financial-settings-post') }}" method="post">
        Financial Settings <hr>
        <div class="field">
            Checking Account #: <input type="text" name="checking_account">
            @if($errors->has('checking_account'))
                    {{ $errors->first('checking_account') }}
            @endif
        </div>
        <div class="field">
            Bank Routing #: <input type="text" name="bank_routing">
            @if($errors->has('bank_routing'))
                    {{ $errors->first('bank_routing') }}
            @endif
        </div>
                {{ Form::token() }}
        <input type="submit" value="Change Financial Settings">
    </form>

    <form action="{{ URL::route('user-change-icon-post') }}" enctype="multipart/form-data" method="post" id="custom">
        Profile Icon <hr>
        @if(!empty($user->profile_icon))
        <img src={{ "/uploads/users/" . $user->username . "/" . $user->profile_icon }} height="100px" width="100px" />
        @else
        <img src="/assets/default.png" height="100px" width="100px" />
        @endif
        <div class="field">
            Profile Icon: <input type="file" name="profile_icon">
            @if($errors->has('profile_icon'))
                    {{ $errors->first('profile_icon') }}
            @endif
        </div>  
                {{ Form::token() }}
        <input type="submit" value="Change Icon"> 
    </form>

@stop
