<div class="page-header">
		<div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
			<div class="d-flex">
				<div class="breadcrumb">
					<a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
					@if(isset($breadcrumb) && is_array($breadcrumb))
						@foreach($breadcrumb as $item)
							@if($loop->last)
								<span class="breadcrumb-item active">{{ $item['title'] }}</span>
							@else
								<a href="{{ $item['url'] }}" class="breadcrumb-item">{{ $item['title'] }}</a>
							@endif
						@endforeach
					@else
						<span class="breadcrumb-item active">Dashboard</span>
					@endif
				</div>

				<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
			</div>

		</div>

		<div class="page-header-content header-elements-md-inline">
			<div class="page-title d-flex">
				<h4>
					<i class="icon-arrow-left52 mr-2"></i>
					@if(isset($breadcrumb) && is_array($breadcrumb))
						<span class="font-weight-semibold">
							{{ collect($breadcrumb)->pluck('title')->implode(' - ') }}
						</span>
					@else
						<span class="font-weight-semibold">Dashboard</span>
					@endif
				</h4>
				<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
			</div>
		</div>
	</div>