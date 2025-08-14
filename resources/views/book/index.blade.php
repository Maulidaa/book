<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Book Management</title>

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
									<a href="{{ route('books.export.excel') }}" class="btn bg-indigo-300">
										<i class="icon-statistics mr-2"></i> Export To Excel
									</a>
									@if(auth()->check() && auth()->user()->role_id == 2)
										<a href="{{ route('books.create') }}" class="btn bg-success-600">
											<i class="icon-plus3 mr-2"></i> Create New Book
										</a>
										{{-- Jika ada tombol Create New Chapter, tambahkan di sini --}}
										{{-- <a href="{{ route('chapters.create') }}" class="btn bg-primary-600">
											<i class="icon-plus3 mr-2"></i> Create New Chapter
										</a> --}}
									@endif
								</div>
							</div>

							<!-- Tabel -->
							<div class="card p-3" style="overflow-x:auto;">
								<table id="books-table" class="table table-hover text-center w-100">
									<thead>
										<tr>
											<th>Cover</th>
											<th>Title</th>
											<th>Author</th>
											<th>ISBN</th>
											<th>Chapter</th>
											<th>Category</th>
											<th>Action</th>
										</tr>
									</thead>
								</table>
							</div>

							<!-- Script DataTables -->
							<script>
							$(function() {
							    $('#books-table').DataTable({
							        processing: true,
							        serverSide: true,
							        ajax: '{{ route("books.data") }}',
							        columns: [
							            {
							                data: 'url_cover',
							                name: 'url_cover',
							                orderable: false,
							                searchable: false,
							                render: function(data, type, row) {
							                    if (data) {
							                        return '<img src="/storage/' + data + '" style="max-width:60px;max-height:80px;object-fit:cover;">';
							                    }
							                    return '-';
							                }
							            },
							            { data: 'title', name: 'title' },
							            { data: 'author.name', name: 'author.name', defaultContent: '-' },
							            { data: 'isbn', name: 'isbn' },
							            { data: 'chapters_count', name: 'chapters_count', orderable: false, searchable: false, defaultContent: 0 },
							            { data: 'category.name', name: 'category.name', defaultContent: '-' },
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
