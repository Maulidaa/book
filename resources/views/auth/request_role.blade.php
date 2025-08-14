<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Update User</title>

	<!-- Global stylesheets -->
	 @include('main.stylesheets')
</head>

<body>

	<!-- Main navbar -->
	@include('main.navbar')
	<!-- /main navbar -->


	<!-- Page header -->
	@include('main.header')
	<!-- /page header -->
		

	<!-- Page content -->
	<div class="page-content pt-0">

		<!-- Main sidebar -->
		@include('main.sidebar')
		<!-- /main sidebar -->

		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Content area -->
			<div class="content">

				<!-- Dashboard content -->
				 <div class="card">
							<div class="card-header header-elements-sm-inline">
								<h6 class="card-title">Update Role</h6>
								<div class="header-elements">
			                	</div>
							</div>
							<div class="card-body">
							<form action="{{ route('role.request') }}" method="POST" enctype="multipart/form-data">
							@csrf
							<div class="form-group">
								<label class="mb-1">Your Role</label>
								<input type="text" class="form-control" value="{{ auth()->user()->role->name }}" readonly>
							</div>
							<div class="form-group">
								<label class="mb-1">New Role</label>
								<select name="role_id" class="form-control select2" required data-placeholder="-- Select New Role --">
									<option value="">-- Select New Role --</option>
									@foreach($roles ?? [] as $role)
										@if($role->id != auth()->user()->role_id)
											<option value="{{ $role->id }}">{{ $role->name }}</option>
										@endif
									@endforeach
								</select>
							</div>
							<button type="submit" class="btn bg-indigo-300 btn-block">Request</button>
						</form>
							</div>
                    @if(session('success'))
                        <div class="alert alert-success mt-2">{{ session('success') }}</div>
                    @endif
                </div>
				<!-- /dashboard content -->

			</div>
			<!-- /content area -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->
	 
	
	<!-- Footer -->
	@include('main.footer')
	<!-- /footer -->
		
	<script>
		$(document).ready(function() {
			$('.select2').select2({
				theme: 'bootstrap4',
				placeholder: function(){
					$(this).data('placeholder');
				},
				allowClear: true
			});

			// Preview picture
			$('#profile-picture-input').on('change', function(){
				const [file] = this.files;
				if (file) {
					$('#profile-picture-preview').attr('src', URL.createObjectURL(file)).show();
				} else {
					$('#profile-picture-preview').hide();
				}
			});
		});
	</script>
</body>
</html>
