@extends('layout.main')

@section('content')
    <form action="{{ URL::route('user-change-info-post') }}" method="post">
        <div class="field">
            Website: <input type="text" name="website_url" value="{{ website_url }}">
        </div>
            Phone Number: <input type="text" name="phone_number" value="{{ phone_number }}">
            Support Email Address: <input type="text" name="support_email" value="{{ support_email }}">
            Address: <input type="text" name="address" value="{{ address }}">
            City: <input type="text" name="city" value="{{ city }}">
            State: <input type="text" name="state" value="{{ state }}">
            Zip Code: <input type="text" name="zipcode" value="{{ zipcode }}">
            Give donors the option to cover the transaction fee: <input type="text" name="transaction_fee_option" value="{{ transaction_fee_option }}">
            Send quarterly statement to donors via email: <input type="text" name="quarterly_statement_option" value="{{ quarterly_statement_option }}">
            Custom messsage in email receipt: <input type="text" name="custom_message" value="{{ custom_message }}">
        <input type="submit" value="Save Changes" />
        {{ Form::token() }}
    </form>
@stop
