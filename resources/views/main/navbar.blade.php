<div class="navbar navbar-expand-md navbar-dark">
		<div class="navbar-brand wmin-200">
			<a href="{{ route('dashboard') }}" class="d-inline-block">
				<img src="../../../../global_assets/images/logo_light.png" alt="">
			</a>
		</div>

		<div class="d-md-none">
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-mobile">
				<i class="icon-tree5"></i>
			</button>
			<button class="navbar-toggler sidebar-mobile-main-toggle" type="button">
				<i class="icon-paragraph-justify3"></i>
			</button>
		</div>

		<div class="collapse navbar-collapse" id="navbar-mobile">
			
			<ul class="navbar-nav ml-md-auto">
				<li class="nav-item dropdown dropdown-user">
					<a href="#" class="navbar-nav-link d-flex align-items-center dropdown-toggle" data-toggle="dropdown">
						@if(auth()->check())
							<img src="{{ auth()->user()->picture ? asset('storage/' . auth()->user()->picture) : asset('global_assets/images/placeholders/placeholder.jpg') }}"
								width="38" height="38" class="rounded-circle" alt="">
							<span>{{ auth()->user()->name }}</span>
						@else
							<img src="{{ asset('global_assets/images/placeholders/placeholder.jpg') }}"
								width="38" height="38" class="rounded-circle" alt="">
							<span>Guest</span>
						@endif
					</a>
					
					<div class="dropdown-menu dropdown-menu-right">
						@if(auth()->check())
							<a href="{{ route('profile', auth()->user()->id) }}" class="dropdown-item"><i class="icon-user-plus"></i> My profile</a>
							<div class="dropdown-divider"></div>
							<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
								@csrf
							</form>
							<a href="#" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
								<i class="icon-switch2"></i> Logout
							</a>
						@else
							<a href="{{ route('login') }}" class="dropdown-item"><i class="icon-user-plus"></i> Login</a>
						@endif
					</div>
				</li>
			</ul>
		</div>
	</div>