<!-- Main sidebar -->
		<div class="sidebar sidebar-light sidebar-main sidebar-expand-md align-self-start">

			<!-- Sidebar mobile toggler -->
			<div class="sidebar-mobile-toggler text-center">
				<a href="#" class="sidebar-mobile-main-toggle">
					<i class="icon-arrow-left8"></i>
				</a>
				<span class="font-weight-semibold">Main sidebar</span>
				<a href="#" class="sidebar-mobile-expand">
					<i class="icon-screen-full"></i>
					<i class="icon-screen-normal"></i>
				</a>
			</div>
			<!-- /sidebar mobile toggler -->


			<!-- Sidebar content -->
			<div class="sidebar-content">
				<div class="card card-sidebar-mobile">

					<!-- Header -->
					<div class="card-header header-elements-inline">
						<h6 class="card-title">Navigation</h6>
						<div class="header-elements">
							<div class="list-icons">
								<a class="list-icons-item" data-action="collapse"></a>
							</div>
						</div>
					</div>
					
					<!-- User menu -->
					<div class="sidebar-user">
						<div class="card-body">
							<div class="media">
								<div class="mr-3">
									<a href="{{ auth()->check() ? route('profile', auth()->user()->id) : '#' }}">
										<img src="{{ auth()->check() && auth()->user()->picture ? asset('storage/' . auth()->user()->picture) : asset('global_assets/images/placeholders/placeholder.jpg') }}"
											width="38" height="38" class="rounded-circle" alt="">
									</a>
								</div>

								<div class="media-body">
									<a href="{{ auth()->check() ? route('profile', auth()->user()->id) : '#' }}" class="media-title font-weight-semibold text-dark">
										{{ auth()->check() ? auth()->user()->name : 'Guest' }}
									</a>
									<div class="font-size-xs opacity-50">
										<i class="icon-pin font-size-sm"></i>
										&nbsp;{{ auth()->check() ? auth()->user()->email : '-' }}
									</div>
								</div>

								<div class="ml-3 align-self-center">
									@if(auth()->check())
										<a href="{{ route('profile', auth()->user()->id) }}" class="text-white"><i class="icon-cog3"></i></a>
									@endif
								</div>
							</div>
						</div>
					</div>
					<!-- /user menu -->

					
					<!-- Main navigation -->
					<div class="card-body p-0">
						<ul class="nav nav-sidebar" data-nav-type="accordion">

							<!-- Main -->
							<li class="nav-item-header mt-0"><div class="text-uppercase font-size-xs line-height-xs">Main</div> <i class="icon-menu" title="Main"></i></li>
							<li class="nav-item">
								<a href="{{ route('dashboard') }}" class="nav-link active">
									<i class="icon-home4"></i>
									<span>
										Dashboard
										<span class="d-block font-weight-normal opacity-50">No active orders</span>
									</span>
								</a>
							</li>
							
							<li class="nav-item nav-item-menu">
								<a href="{{ route('books.index') }}" class="nav-link"><i class="icon-color-sampler"></i> <span>Book</span></a>
							</li>

							@if(auth()->check() && auth()->user()->role_id == 1)
							<li class="nav-item nav-item-menu">
								<a href="{{ route('role.index') }}" class="nav-link"><i class="icon-color-sampler"></i> <span>User Management</span></a>
							</li>
							@endif
						</ul>
					</div>
					<!-- /main navigation -->

				</div>
			</div>
			<!-- /sidebar content -->
			
		</div>
		<!-- /main sidebar -->