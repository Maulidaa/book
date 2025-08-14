<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Edit User</title>

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
								<h5 class="card-title">Edit User</h5>
								<div class="header-elements">
									<div class="list-icons">
										<a class="list-icons-item" data-action="collapse"></a>
										<a class="list-icons-item" data-action="reload"></a>
										<a class="list-icons-item" data-action="remove"></a>
									</div>
								</div>
							</div>
							<div class="card-body">
								@if(session('success'))
									<div class="alert alert-success">
										{{ session('success') }}
									</div>
								@endif

								@if ($errors->any())
									<div class="alert alert-danger">
										<ul class="mb-0">
											@foreach ($errors->all() as $error)
												<li>{{ $error }}</li>
											@endforeach
										</ul>
									</div>
								@endif

								<form action="{{ route('user.update', $user->id) }}" method="POST">
									@csrf
									@method('PUT')
									<div class="form-group">
										<label class="mb-1">Name</label>
										<input type="text" name="name" class="form-control" required value="{{ old('name', $user->name) }}">
									</div>
									<div class="form-group">
										<label class="mb-1">Email</label>
										<input type="email" name="email" class="form-control" required value="{{ old('email', $user->email) }}">
									</div>
									<div class="form-group">
										<label class="mb-1">Password <small>(Kosongkan jika tidak diubah)</small></label>
										<input type="password" name="password" class="form-control" placeholder="Enter new password">
									</div>
									<div class="form-group">
										<label class="mb-1">Role</label>
										<select name="role_id" class="form-control select2" required data-placeholder="-- Select Role --">
											<option value="">-- Select Role --</option>
											@foreach($roles as $role)
												<option value="{{ $role->id }}" {{ (old('role_id', $user->role_id) == $role->id) ? 'selected' : '' }}>
													{{ $role->name }}
												</option>
											@endforeach
										</select>
									</div>
									<button type="submit" class="btn bg-indigo-300 btn-block">Update User</button>
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

	<!-- /footer -->
	 @include('main.footer')
</body>
</html>
