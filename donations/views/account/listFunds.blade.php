@if(!empty($funds))
	@foreach($funds as $f)
		<li>{{ $f->name }}
			<img class="trash" src={{ URL::asset('/assets/check-box-checked.png') }} onclick={{ 'removeFund(' . $f->id . ')' }}>
		</li>
	@endforeach
@else 
	No custom funds found.
@endif