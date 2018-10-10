@if(!empty($account))
	@foreach($account->funds as $f)
		<option class="fund" type="text" value={{ $f->id }}>{{ $f->name }}</option>
	@endforeach
@else 
	No custom funds found.
@endif