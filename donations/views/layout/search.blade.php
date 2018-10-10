<form action="{{ URL::route('user-user-search') }}" method="post">
	<img class="search-icon" src={{ URL::asset('assets/search-icon.png')}}>
	<input class="searchBox" type="text" name="user-search" placeholder="Search Donors">
	{{ Form::token() }}
</form>