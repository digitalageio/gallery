    <form action="{{ URL::route('account-edit-donor-post') }}" method="post">
        <div class="field">
            Email: <input type="text" name="email" {{ (Input::old('email')) ? 'value="' . e(Input::old('email')) . '"' : '' }}>
            @if($errors->has('email'))
                {{ $errors->first('email') }}
            @endif
        </div>
        <div class="field">
            Phone number: <input type="text" id="phone_number" name="phone_number" {{ (Input::old('phone_number')) ? 'value="' . e(Input::old('phone_number')) . '"' : '' }}>
        </div>
        <div class="field">
            First name: <input type="text" id="first_name" name="first_name" {{ (Input::old('first_name')) ? 'value="' . e(Input::old('first_name')) . '"' : '' }}>
        </div>
        <div class="field">
            Last name: <input type="text" id="last_name" name="last_name" {{ (Input::old('last_name')) ? 'value="' . e(Input::old('last_name')) . '"' : '' }}>
        </div>
        <div class="field">
            Username: <input type="text" id="username" name="username" {{ (Input::old('username')) ? 'value="' . e(Input::old('username')) . '"' : '' }}>
        </div>
        <div class="field">
            User role: <select id="userrole" name="userrole">
                            <option value="0">Donor</option>
                            <option value="1">Manager</option>
                        </select>
        </div>
        <div class="field">
            Password: <input type="password" id="password" name="password">
        </div>
            @if($errors->has('email'))
                {{ $errors->first('email') }}
            @endif
        <div class="field">
            Confirm password: <input type="password" id="password_again" name="password_again">
        </div>
            @if($errors->has('email'))
                {{ $errors->first('email') }}
            @endif
        <input type="submit" value="Save changes to donor" />
        {{ Form::token() }}
    </form>

