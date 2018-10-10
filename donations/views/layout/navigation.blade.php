<nav>
	<ul>
		@if(Auth::check())
			<li><a href="{{ URL::route('account-dashboard') }}">Account Dashboard</a></li>
			<li><a href="{{ URL::route('create-account') }}">Create an account</a></li>
			<li><a href="{{ URL::route('user-list') }}">Donor List</a></li>
			<li><a href="{{ URL::route('donation-list-donations') }}">Donations list</a></li>
			<li><a href="{{ URL::route('sign-out') }}">Sign out</a></li>
		@else
			<li><a href="{{ URL::route('user-create') }}">Register</a></li>
			<li><a href="{{ URL::route('user-sign-in') }}">Sign in</a></li>
		@endif
	</ul>
</nav>