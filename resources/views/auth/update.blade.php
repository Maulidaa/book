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
				<div class="row">
					<div class="col-md-12">
						<div class="card">
							<div class="card-header header-elements-inline">
								<h5 class="card-title">User Information</h5>
								<div class="header-elements">
									<div class="list-icons">
										<a href="{{ route('profile.index') }}" class="list-icons-item" data-action="collapse">Update Role</a>
									</div>
								</div>
							</div>
							<div class="card-body">
								@if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label class="mb-1">Name</label>
                                        <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                                    </div>                                    
                                    <div class="form-group">
                                        <label class="mb-1">Profile Picture</label>
                                        <input type="file" name="picture" class="form-control-file" id="profile-picture-input">
										@if ($user->picture)
											<img
												id="profile-picture-preview"
												src="{{ asset('storage/' . $user->picture) }}"
												alt="Profile Picture Preview"
												style="max-width:150px; margin-top:10px;"
											/>
										@else
											<img
												id="profile-picture-preview"
												src="#"
												alt="Profile Picture Preview"
												style="display:none;"
											/>
										@endif
                                    </div>
									
                                    <button type="submit" class="btn bg-indigo-300 btn-block" formaction="{{ route('profile.update', $user->id) }}">Update Profile</button>
                                </form>
							</div>
						</div>
					</div>
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
