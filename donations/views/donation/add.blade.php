<form action="{{ URL::route('donation-add-manual-post') }}" method="post">
        @if(!empty($asUser))
        <input type="hidden" name="asUser" value={{ $asUser->id }}>
        @else
        <input type="hidden" name="asUser" value="7">
        @endif
        <div class="field">
            Donation Amount: $<input type="text" id="amount" name="amount" {{ (Input::old('amount')) ? 'value="' . e(Input::old('amount')) . '"' : '' }}>
        </div>
        <div class="field">
            Month: <select type="text" id="month" name="month" {{ (Input::old('month')) ? 'value="' . e(Input::old('month')) . '"' : '' }}>
                        @for($i=1;$i<=12;$i++)
                            <option value={{ str_pad($i,2,0,STR_PAD_LEFT) }}>{{ str_pad($i,2,0,STR_PAD_LEFT) }}</option>
                        @endfor
                    </select>
        </div>
        <div class="field">
        <!--$days = ($month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year %400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31));-->
            Day: <select type="text" id="day" name="day" {{ (Input::old('day')) ? 'value="' . e(Input::old('day')) . '"' : '' }}>
                        @for($i=1;$i<=31;$i++)
                            <option value={{ str_pad($i,2,0,STR_PAD_LEFT) }}>{{ str_pad($i,2,0,STR_PAD_LEFT) }}</option>
                        @endfor
                </select>
        </div>
        <div class="field">
            Year: <select type="text" id="year" name="year" {{ (Input::old('year')) ? 'value="' . e(Input::old('year')) . '"' : '' }}>
                        @for($i=(date('Y')-5);$i<=(date('Y')+5);$i++)
                            <option value={{ $i }} {{ (Input::old('year')) ? "selected" : ((date('Y') == $i) ? "selected" : "") }}>{{ $i }}</option>
                        @endfor
                </select>
        </div>
        <div class="field">
            Type: <select type="text" id="type" name="type" {{ (Input::old('type')) ? 'value="' . e(Input::old('type')) . '"' : '' }}>
                        <option value="Cash">Cash</option>
                        <option value="Check">Check</option>            
                </select>
        </div>  
        <div class="field">
            Check#: <input type="text" id="optional" name="optional" {{ (Input::old('optional')) ? 'value="' . e(Input::old('optional')) . '"' : '' }}>
        </div>
        <div class="field">
            Fund: <select type="text" id="fund" name="fund" {{ (Input::old('fund')) ? 'value="' . e(Input::old('fund')) . '"' : '' }}>
                @include('account.selectFunds')
            </select>
        </div>
        <div class="field">
            Source: <input type="text" id="source" name="source" {{ (Input::old('source')) ? 'value="' . e(Input::old('source')) . '"' : '' }}>
        </div>   
        <input type="submit" value="Submit donation" />
        {{ Form::token() }}
    </form>