@extends('layout.main')

@section('content')
@if(!empty($account))
    <script type="text/javascript">
    $(document).ready(function(){
        $("#custom").bind("keyup keypress keydown", function(e) {
          var code = e.keyCode || e.which; 
          if (code  == 13) {               
            e.preventDefault();
            return false;
          }
        });
    });
    </script>
    <form action="{{ URL::route('account-general-settings-post') }}" id="general" method="post">
        General Settings <hr>
        <div class="field">
            Organization name: <input type="text" name="name"  {{ ($account['name']) ? ' value="' . $account['name'] . '"' : '' }}>
            @if($errors->has('name'))
                    {{ $errors->first('name') }}
            @endif
        </div>
        <div class="field">
            Website URL: <input type="text" name="website_url" {{ ($account['website_url']) ? ' value="' . $account['website_url'] . '"' : '' }}>
            @if($errors->has('website_url'))
                    {{ $errors->first('website_url') }}
            @endif
        </div>
        <div class="field">
            Support Email: <input type="text" name="support_email" {{ ($account['support_email']) ? ' value="' . $account['support_email'] . '"' : '' }}>
            @if($errors->has('support_email'))
                    {{ $errors->first('support_email') }}
            @endif
        </div>
        <div class="field">
            Phone number: <input type="text" name="phone_number" {{ ($account['phone_number']) ? ' value="' . $account['phone_number'] . '"' : '' }}>
            @if($errors->has('phone_number'))
                    {{ $errors->first('phone_number') }}
            @endif
        </div>
        <div class="field">
            Address: <input type="text" name="address" {{ ($account['address']) ? ' value="' . $account['address'] . '"' : '' }}>
            @if($errors->has('address'))
                    {{ $errors->first('address') }}
            @endif
        </div>
        <div class="field">
            City: <input type="text" name="city" {{ ($account['city']) ? ' value="' . $account['city'] . '"' : '' }}>
            @if($errors->has('city'))
                    {{ $errors->first('city') }}
            @endif
        </div>
        <div class="field">
            State:
            <input type="hidden" id="previous_state" value={{ ($account['state']) ? $account['state'] : 'TN' }}>
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
            Zipcode: <input type="text" size="5" name="zipcode" {{ ($account['zipcode']) ? ' value="' . $account['zipcode'] . '"' : '' }}>
            @if($errors->has('zipcode'))
                    {{ $errors->first('zipcode') }}
            @endif
        </div>
                {{ Form::token() }}
        <input type="submit" value="Save General Settings">
    </form>

<script type="text/javascript">
$(document).ready(function () {
    // Callback for handling responses from Balanced
    function handleResponse(response) {
        // Successful tokenization
        if (response.status_code === 201) {
            var fundingInstrument = response.bank_accounts[0];
            var _csrf = $("#financials-form input[name='_token']").val();

            $.ajax({
                url: "/balanced/create-bank-account",
                type: 'post',
                dataType: 'html',
                data: {'uri' : fundingInstrument.href, '_token' : _csrf},
                success: function(r){
                    $('#response').html(r);
                }
            });
        } else {
            $('#response').html('Balanced Payments failed to tokenize the information.');
        }
    }

    // Click event for tokenize bank account
    $('#ba-submit').click(function (e) {
        e.preventDefault();

        var payload = {
            name: $('#ba-name').val(),
            account_number: $('#ba-number').val(),
            routing_number: $('#ba-routing').val()
        };

        // Tokenize bank account
        balanced.bankAccount.create(payload, handleResponse);
    });
});
</script>
    Financial Settings <hr>
    <form id="financials-form" role="form">
        <div id="response">
                
        </div>
          <div>
            <label>Account Holder's Name</label>
            <input type="text" id="ba-name" autocomplete="off" placeholder="John Doe" />
          </div>
          <div>
            <label>Routing Number</label>
            <input type="text" id="ba-routing" autocomplete="off" placeholder="322271627" />
          </div>
          <div>
            <label>Account Number</label>
            <input type="text" id="ba-number" autocomplete="off" placeholder="9900000000" />
          </div>
          {{ Form::token() }}
        <a id="ba-submit">Submit</a>
        <div id="account_message"></div>
    </form>
    <br />
    Account Verification<br />
    @if(!empty($verified))
        @if($verified['status'])
            {{ $verified['message'] }}
        @else
            {{ $verified['message'] }}
    <script type="text/javascript">
        $(document).ready(function () {

            $('#verification-submit').click(function (e) {
                e.preventDefault();
                var amount_1 = $('#first-amount').val();
                var amount_2 = $('#second-amount').val();
                    $.ajax({
                        url: "/balanced/submit-account-verification",
                        type: 'post',
                        dataType: 'html',
                        data: {'amount_1' : amount_1,'amount_2' : amount_2, '_token' : _csrf},
                        success: function(r){
                            $('#verification-response').html('Verification status: ' + r);
                        }
                    });
            });
        });
    </script>
    <form id="verification-form" role="form">
            <div id="verification-response">
                    
            </div>
              <div>
                <label>First Amount</label>
                <input type="text" id="first-amount" autocomplete="off" placeholder="1.00" />
              </div>
              <div>
                <label>Second Amount</label>
                <input type="text" id="second-amount" autocomplete="off" placeholder="0.01" />
              </div>
              {{ Form::token() }}
            <a id="verification-submit">Submit</a>
            <div id="verification-message"></div>
        </form>
        @endif
    @endif

    <form action="{{ URL::route('account-change-icon-post') }}" enctype="multipart/form-data" method="post" id="custom">
        Profile Icon <hr>
        @if(!empty($account->logo_filename))
        <img src={{ "/uploads/accounts/" . $account->subdomain . "/" . $account->logo_filename }} height="100px" width="100px" />
        @else
        <img src="/assets/default.png" height="100px" width="100px" />
        @endif
        <div class="field">
            Profile Icon: <input type="file" name="logo_filename">
            @if($errors->has('logo_filename'))
                    {{ $errors->first('logo_filename') }}
            @endif
        </div>
                        {{ Form::token() }}
        <input type="submit" value="Change Account Icon"> 
        </form>

        <form id="fundform">
        <div class="field">
                    Custom funds:
            <ul id="funds_ul">
            @include('account.listFunds')
            </ul>

            <input type="text" id="fund_entry" name="fund_entry"><button type="button" name="fund_button" onclick="addFund()">Add Fund</button>

        </div>
                {{ Form::token() }}
        <script type="text/javascript">
        var _csrf = $("#fundform input[name='_token']").val();

        function addFund(){
            var newfund = $('#fund_entry').val();
            $.ajax({
                url: "/account/account-add-fund",
                type: 'post',
                dataType: 'html',
                data: {'name': newfund,'_token': _csrf },
                success: function(r){
                    $('#funds_ul').html(r);
                }
            });
        }
        function removeFund(id){
           $.ajax({
                url: "/account/account-remove-fund",
                type: 'post',
                dataType: 'html',
                data: { 'id': id, '_token': _csrf },
                success: function(r){
                    $('#funds_ul').html(r);
                }
            });
        }
        </script>
    </form>

    <form action="{{ URL::route('account-payment-settings-post') }}" method="post">
        Financial Settings <hr>
        <div class="field">
            Give donors the option to pay the transaction fee? 
            <input type="radio" name="transaction_fee_option" value="1" {{ ($account->transaction_fee_option == 1) ? 'checked' : ''}} /> Yes
            <input type="radio" name="transaction_fee_option" value="0" {{ ($account->transaction_fee_option == 0) ? 'checked' : ''}}/> No
            @if($errors->has('transaction_fee_option'))
                    {{ $errors->first('transaction_fee_option') }}
            @endif
        </div>
                {{ Form::token() }}
        <input type="submit" value="Change Payment Settings">
    </form>

    <form action="{{ URL::route('account-communication-settings-post') }}" method="post">
        Communication Settings <hr>
        <div class="field">
            Send quarterly statements? 
            <input type="radio" name="quarterly_statement_option" value="1" {{ ($account->quarterly_statement_option == 1) ? 'checked' : ''}} /> Yes
            <input type="radio" name="quarterly_statement_option" value="0" {{ ($account->quarterly_statement_option == 0) ? 'checked' : ''}}/> No
            @if($errors->has('quarterly_statement_option'))
                    {{ $errors->first('quarterly_statement_option') }}
            @endif
        </div>
        <div class="field">
            Send weekly donation summary? 
            <input type="radio" name="weekly_summary_option" value="1" {{ ($account->weekly_summary_option == 1) ? 'checked' : ''}} /> Yes
            <input type="radio" name="weekly_summary_option" value="0" {{ ($account->weekly_summary_option == 0) ? 'checked' : ''}}/> No
            @if($errors->has('weekly_summary_option'))
                    {{ $errors->first('weekly_summary_option') }}
            @endif
        </div>
        <div class="field">
            Custom Message on receipts:<br />
            <textarea for="custom" rows="10" cols="50" name="custom_message">{{ ($account->custom_message) ? $account->custom_message : '' }}</textarea>
            @if($errors->has('custom_message'))
                    {{ $errors->first('custom_message') }}
            @endif
        </div>  
                {{ Form::token() }}
        <input type="submit" value="Change Communication Settings">
    </form>



@else
    This is page is accessible only by this account's administrator.
@endif
@stop
