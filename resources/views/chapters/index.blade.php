<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>List of Chapters</title>

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

				<!-- Main charts -->
				<div class="row">
					<div class="col-xl-12">

						<!-- Statistics -->
						<div class="card">
                            <div class="card-header header-elements-inline">
                                <h6 class="card-title">Statistics</h6>
                            </div>
                            <div class="card-body py-0">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="d-flex align-items-center justify-content-center mb-2">
                                            <a href="#" class="btn bg-transparent border-teal text-teal rounded-round border-2 btn-icon mr-3">
                                                <i class="icon-plus3"></i>
                                            </a>
                                            <div>
                                                <div class="font-weight-semibold">Chapter</div>
                                                <span class="text-muted" id="stat-author">{{ $countChapters }}</span>
                                            </div>
                                        </div>
                                        <div class="w-75 mx-auto mb-3" id="new-visitors"></div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="d-flex align-items-center justify-content-center mb-2">
                                            <a href="#" class="btn bg-transparent border-warning-400 text-warning-400 rounded-round border-2 btn-icon mr-3">
                                                <i class="icon-watch2"></i>
                                            </a>
                                            <div>
                                                <div class="font-weight-semibold">Comment</div>
                                                <span class="text-muted" id="stat-publisher">{{ $comments }}</span>
                                            </div>
                                        </div>
                                        <div class="w-75 mx-auto mb-3" id="new-sessions"></div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="d-flex align-items-center justify-content-center mb-2">
                                            <a href="#" class="btn bg-transparent border-indigo-400 text-indigo-400 rounded-round border-2 btn-icon mr-3">
                                                <i class="icon-people"></i>
                                            </a>
                                            <div>
                                                <div class="font-weight-semibold">Views</div>
                                                <span class="text-muted" id="stat-book">{{ $views }}</span>
                                            </div>
                                        </div>
                                        <div class="w-75 mx-auto mb-3" id="total-online"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
						<!-- /statistics -->

					</div>
				</div>

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
                                    <a href="{{ route('chapters.download_all', ['id' => $bookId]) }}" class="btn bg-indigo-300">
                                        <i class="icon-statistics mr-2"></i> Export All Chapters
                                    </a>
                                    @if(auth()->check() && auth()->user()->role_id == 2)
                                        <a href="{{ route('chapters.create', ['id' => $bookId]) }}" class="btn bg-success-600">
                                            <i class="icon-plus3 mr-2"></i> Create New Chapters
                                        </a>
                                    @endif
                                </div>
                            </div>

							<!-- Tabel -->
							<div class="card p-3" style="overflow-x:auto;">
                                <table id="chapters-table" class="table table-hover text-center w-100">
                                    <thead>
                                        <tr>
                                            <th>Cover</th>
                                            <th>Title</th>
                                            <th>Author</th>
                                            <th>Status</th>
                                            <th>Created At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <!-- Script DataTables -->
                            <script>
                            $(function() {
                                $('#chapters-table').DataTable({
                                    processing: true,
                                    serverSide: true,
                                    ajax: '{{ route("chapters.data", ["id" => $bookId]) }}',
                                    dom: "<'row mb-2'<'col-sm-6'l><'col-sm-6'f>>" +
                                         "<'row'<'col-sm-12'tr>>" +
                                         "<'row mt-2'<'col-sm-5'i><'col-sm-7'p>>",
                                    columns: [
                                        {
                                            data: 'chapter_cover',
                                            name: 'chapter_cover',
                                            orderable: false,
                                            searchable: false,
                                            render: function(data, type, row) {
                                                if (data) {
                                                    return '<img src="/storage/' + data + '" style="max-width:40px;max-height:40px;object-fit:cover;">';
                                                }
                                                return '-';
                                            }
                                        },
                                        { data: 'title', name: 'title' },
                                        { data: 'book.author.name', name: 'book.author.name', defaultContent: '-' },
                                        { data: 'status', name: 'status', defaultContent: '-' },
                                        { data: 'created_at', name: 'created_at', defaultContent: '-' },
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
