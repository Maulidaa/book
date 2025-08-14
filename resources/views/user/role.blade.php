<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>User Management</title>

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
					<div class="col-xl-12">

						<!-- Marketing campaigns -->
						<div class="card">
							<div class="card-header header-elements-sm-inline">
								<h6 class="card-title">Books</h6>
								<div class="header-elements">
			                	</div>
							</div>

							<div class="card-body d-sm-flex align-items-sm-center justify-content-sm-between flex-sm-wrap">
								<div>
									<a href="{{ route('user.create') }}" class="btn bg-success-600">
										<i class="icon-plus3 mr-2"></i> Create New User
									</a>

									<a href="{{ route('user.import_excel') }}" class="btn bg-warning">
										<i class="icon-plus3 mr-2"></i> Import Excel
									</a>
								</div>
							</div>

							<!-- Tabel -->
							<div class="card p-3" style="overflow-x:auto;">
							    <table id="roles-table" class="table table-hover text-center w-100">
							        <thead>
							            <tr>
							                <th>Nama</th>
											<th>Email</th>
							                <th>Request Role</th>
							                <th>Status</th>
							                <th>Action</th>
							            </tr>
							        </thead>
							    </table>
							</div>

							<!-- Script DataTables -->
							<script>
							$(function() {
							    $('#roles-table').DataTable({
							        processing: true,
							        serverSide: true,
							        ajax: '{{ route("role.data") }}',
							        columns: [
							            { data: 'user.name', name: 'user.name' },
							            { data: 'user.email', name: 'user.email' },
							            { data: 'role.name', name: 'role.name' },
							            { data: 'status', name: 'status' },
							            { data: 'action', name: 'action', orderable: false, searchable: false }
							        ]
							    });
							});
							</script>
						</div>
						<!-- /marketing campaigns -->
					</div>

					<div class="col-xl-4">


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
</body>
</html>
