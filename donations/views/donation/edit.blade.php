<form action="{{ URL::route('donation-edit-post') }}" method="post">
        @if(!empty($asUser))
        <input type="hidden" name="asUser" value={{ $asUser->id }}>
        @else
        <input type="hidden" name="asUser" value="7">
        @endif
        <div class="field">
            Donation Amount: $<input type="text" id="amount" name="amount" {{ $donation['amount'] ? 'value="' . $donation['amount'] . '"' : '' }}>
        </div>
        <div class="field">
            Month: <select type="text" id="month" name="month" {{ $donation[''] ? 'value="' . e(Input::old('month')) . '"' : '' }}>
                        @for($i=1;$i<=12;$i++)
                            <option value={{ str_pad($i,2,0,STR_PAD_LEFT) }}>{{ str_pad($i,2,0,STR_PAD_LEFT) }}</option>
                        @endfor
                    </select>
            <script type="text/javascript">
                var previous_state = $("#previous_state").val();
                $("#state option[value="+previous_state+"]").attr('selected','selected');
            </script>
        </div>
        <div class="field">
        <!--$days = ($month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year %400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31));-->
            Day: <select type="text" id="day" name="day" {{ (Input::old('day')) ? 'value="' . e(Input::old('day')) . '"' : '' }}>
                        @for($i=1;$i<=31;$i++)
                            <option value={{ str_pad($i,2,0,STR_PAD_LEFT) }}>{{ str_pad($i,2,0,STR_PAD_LEFT) }}</option>
                        @endfor
                </select>
            <script type="text/javascript">
                var previous_state = $("#previous_state").val();
                $("#state option[value="+previous_state+"]").attr('selected','selected');
            </script>
        </div>
        <div class="field">
            Year: <select type="text" id="year" name="year" {{ (Input::old('year')) ? 'value="' . e(Input::old('year')) . '"' : '' }}>
                        @for($i=(date('Y')-5);$i<=(date('Y')+5);$i++)
                            <option value={{ $i }} {{ (Input::old('year')) ? "selected" : ((date('Y') == $i) ? "selected" : "") }}>{{ $i }}</option>
                        @endfor
                </select>
            <script type="text/javascript">
                var previous_state = $("#previous_state").val();
                $("#state option[value="+previous_state+"]").attr('selected','selected');
            </script>
        </div>
        <div class="field">
            Type: <select type="text" id="type" name="type" {{ (Input::old('type')) ? 'value="' . e(Input::old('type')) . '"' : '' }}>
                        <option value="Cash">Cash</option>
                        <option value="Check">Check</option>            
                </select>
            <script type="text/javascript">
                var previous_state = $("#previous_state").val();
                $("#state option[value="+previous_state+"]").attr('selected','selected');
            </script>
        </div>  
        <div class="field">
            Check#: <input type="text" id="optional" name="optional" {{ (Input::old('optional')) ? 'value="' . e(Input::old('optional')) . '"' : '' }}>
        </div>
        <div class="field">
            Fund: <select type="text" id="fund" name="fund" {{ (Input::old('fund')) ? 'value="' . e(Input::old('fund')) . '"' : '' }}>
                        @foreach($account->fund_taglist as $key => $value)
                            <option value=""></option>
                        @endforeach
                </select>
            <script type="text/javascript">
                var previous_state = $("#previous_state").val();
                $("#state option[value="+previous_state+"]").attr('selected','selected');
            </script>
        </div>
        <div class="field">
            Source: <input type="text" id="source" name="source" {{ (Input::old('source')) ? 'value="' . e(Input::old('source')) . '"' : '' }}>
            <script type="text/javascript">
                var previous_state = $("#previous_state").val();
                $("#state option[value="+previous_state+"]").attr('selected','selected');
            </script>
        </div>   
        <input type="submit" value="Submit donation" />
        {{ Form::token() }}
    </form>