<!DOCTYPE html>
<html>
<head>
@include('layout.includes')
</head>
<body>
<script type="text/javascript">
$(document).ready(function(){

	$("input[name='amount']").change(function(){
		var fee = $('input[name="amount"]').val() * 0.039;
		fee = fee.toFixed(2);
		$('#transaction-fee').html(fee);
	});


	function hideSections(){
	$(".iframe-section").each( function(){
		$(this).css("display","none");
	});
	}

	hideSections();
	$("#1").css("display","block");



	$(".next").click(function(){
		var id = $(this).parent().attr("id");
		switch(id) {
			case "1":
				var re = $("input[name='recurring_option']").val();
				console.log(re);
					hideSections();				
				if(re == "0"){

					$("#3").css("display","block");
				} else $("#2").css("display","block");
			break;
			case "2":
				hideSections();
				$("#3").css("display","block");
			break;
			case "3":
				var re = $("input[name='signup']").val();
				hideSections();				
				console.log(re);
				if(re == "0"){
					$("#4").css("display","block");
				} else $("#5").css("display","block");			
			break;
			case "4":
				hideSections();
				$("#5").css("display","block");
			break;
			case "5":
			break;
			default:
				$("iframe-section").css("display","block");
			break;
		}
	});
});
</script>
<form>

	<section class="iframe-section" id="1">
	        1 Your Donation <hr>
        <div class="field">
            Will this be a one time or recurring donation?
 			<input type="radio" name="recurring_option" value="1" {{ Input::old('recurring_option') ? 'checked' : ''}} /> Yes
            <input type="radio" name="recurring_option" value="0" {{ Input::old('recurring_option') ? 'checked' : ''}}/> No
            @if($errors->has('recurring_option'))
                    {{ $errors->first('recurring_option') }}
            @endif
        </div>
        <div class="field">
            What amount would you like to donate? 
            <input type="text" name="amount"  {{ Input::old('amount') ? ' value="' . Input::old('amount') . '"' : '' }}>
            @if($errors->has('amount'))
                    {{ $errors->first('amount') }}
            @endif
        </div>
        <div class="field">
            Select a fund:
            <select name="fund">
            @foreach($account->funds as $f) 
            	<option value={{ $f->name }}>{{ $f->name }}</option>
            @endforeach
            </select>
            @if($errors->has('name'))
                    {{ $errors->first('name') }}
            @endif
        </div>
         <div class="field">
            <input type="checkbox" name="transaction-fee-option"  {{ Input::old('transaction-fee-option') ? 'checked' : '' }}>
            @if($errors->has('name'))
                    {{ $errors->first('name') }}
            @endif
            I'll cover the $<span id="transaction-fee">0.00</span> transaction fee.
            <p>Every donation has a 3.9% transaction fee deducted - by checking this box you'll cover that fee and ensure <strong>{{ $account->name }}</strong> recieves 100% of your gift amount.</p>
        </div>
        <span class="next">Continue</span>
	</section>
		<section  class="iframe-section" id="2">
			<div class="field">
				How often?
				<select name="interval">
					<option value="monthly">monthly</option>
					<option value="biannually">biannually</option>
					<option value="annually">annually</option>
				</select>
			</div>
			<div class="field">
				Day of the month?
				<select name="day">
					<option value="1">1st</option>				
					<option value="2">2nd</option>				
					<option value="3">3rd</option>				
					<option value="4">4th</option>
					<option value="5">5th</option>
					<option value="10">10th</option>
					<option value="15">15th</option>
				</select>
			</div>
			<div class="field">
				How many installments?
				<select name="duration">
					<option value="1"></option>
					<option value=""></option>
					<option value="0">Indefinitely</option>
				</select> 
			</div>
        <span class="next">Continue</span>					
		</section>
			<section class="iframe-section" id="3">
				<div class="field">
				First name
				<input type="text" name="first_name">
				</div>
				<div class="field">
				Last name
				<input type="text" name="last_name">
				</div>
				<div class="field">
				Mailing address
				<input type="text" name="address">
				</div>
				<div class="field">
				City
				<input type="text" name="city">
				</div>
				<div class="field">
				State
				<input type="text" name="state">
				</div>
				<div class="field">
				Zipcode
				<input type="text" name="zipcode">
				</div>
				<div class="field">
				Email
				<input type="text" name="email">
				</div>
				<div class="field">
				Phone number
				<input type="text" name="phone_number">	
				</div>
        <div class="field">
            Would you like to sign up?
 			<input type="radio" name="signup" value="1" {{ Input::old('signup') ? 'checked' : ''}} /> Yes
            <input type="radio" name="signup" value="0" {{ Input::old('signup') ? 'checked' : ''}}/> No
            @if($errors->has('signup'))
                    {{ $errors->first('signup') }}
            @endif
        </div>
        <span class="next">Continue</span>																													
			</section>
			<section class="iframe-section" id="4">
				<input type="text" name="username">
				<input type="text" name="password">
				<input type="text" name="password_confirm">
	        <span class="next">Continue</span>			
			</section>			
			<section class="iframe-section" id="5">
				<script type="text/javascript">
$(document).ready(function () {

    function handleResponse(response) {

        if (response.status_code === 201) {
            var fundingInstrument = response.cards[0];
            	$("#cc-uri").val(fundingInstrument.href);
        } else {
        }
    }

    $('#submit').click(function (e) {
        e.preventDefault();

        $('#response').hide();

        var payload = {
            name: $('#cc-name').val(),
            number: $('#cc-number').val(),
            expiration_month: $('#cc-ex-month').val(),
            expiration_year: $('#cc-ex-year').val(),
            cvv: $('#ex-cvv').val(),
            address: {
                postal_code: $('#ex-postal-code').val()
            }
        };

        balanced.card.create(payload, handleResponse);
    });
});
    </script>
  <div>
    <label>Name on Card</label>
    <input type="text" id="cc-name" autocomplete="off" placeholder="John Doe" />
  </div>
  <div>
    <label>Card Number</label>
    <input type="text" id="cc-number" autocomplete="off" placeholder="4111111111111111" maxlength="16" />
  </div>
  <div>
    <label>Expiration</label>
    <input type="text" id="cc-ex-month" autocomplete="off" placeholder="01" maxlength="2" />
    <input type="text" id="cc-ex-year" autocomplete="off" placeholder="2013" maxlength="4" />
  </div>
  <div>
    <label>Card Verification Code (CVV)</label>
    <input type="text" id="ex-cvv" autocomplete="off" placeholder="453" maxlength="4" />
  </div>
  <div>
    <label>Postal Code</label>
    <input type="text" id="ex-postal-code" autocomplete="off" placeholder="453" />
  </div>
  <input type="hidden" id="cc-uri">

				</section>

Iframe form of {{ $account->name }}
<button type="submit" id="submit">Ready</button>
</form>
</body>
</html>