	@if(Session::get('account_type')=='user')

		
			<ul class="nav nav-pills nav-stacked hidden-sm hidden-xs">
				<li><a class="" href="/users/summary"><i class="icon-chat"></i>&nbsp; Summary</a></li>
				<li><a class="" href="/users/exchange-currencies"><i class="icon-star-1"></i>&nbsp; Exchange</a></li>
				<li><a class="" href="/users/transactions"><i class="icon-chat"></i>&nbsp; Transactions</a></li>
				<li><a class="" href="/users/settings"><i class="icon-cog-alt"></i>&nbsp; Settings</a></li>
			</ul>
		

	@else(Session::get('account_type')=='admin')
	
			<ul class="nav nav-pills nav-stacked hidden-sm hidden-xs">
				<li><a class=""  href="/admin/summary"><i class="icon-layout"></i> &nbsp; Summary</a></li>
				<li><a class=""  href="/admin/transactions"><i class="icon-edit"></i> &nbsp; Transactions</a></li>
				<li><a class=""  href="/admin/users"><i class="icon-users-1"></i> &nbsp; Users</a></li>
				<li><a class=""  href="/admin/currencies"><i class="icon-sitemap"></i> &nbsp;Configuration</a></li>
				<li><a class=""  href="/admin/reports"><i class="icon-chart-bar-1"></i> &nbsp; Reports</a></li>
				<li><a class=""  href="/admin/settings"><i class="icon-cog-alt"></i> &nbsp; Settings</a></li>
			</ul>
		
	@endif
