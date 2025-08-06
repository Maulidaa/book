<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Limitless - Responsive Web Application Kit by Eugene Kopyov</title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="{{ asset('global_assets/css/icons/icomoon/styles.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('assets/css/bootstrap_limitless.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('assets/css/layout.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('assets/css/components.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('assets/css/colors.min.css') }}" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script src="{{ asset('global_assets/js/main/jquery.min.js') }}"></script>
	<script src="{{ asset('global_assets/js/main/bootstrap.bundle.min.js') }}"></script>
	<script src="../../../../global_assets/js/plugins/loaders/blockui.min.js"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script src="../../../../global_assets/js/plugins/visualization/d3/d3.min.js"></script>
	<script src="../../../../global_assets/js/plugins/visualization/d3/d3_tooltip.js"></script>
	<script src="../../../../global_assets/js/plugins/forms/styling/switchery.min.js"></script>
	<script src="../../../../global_assets/js/plugins/ui/moment/moment.min.js"></script>
	<script src="../../../../global_assets/js/plugins/pickers/daterangepicker.js"></script>

	<script src="assets/js/app.js"></script>
	<script src="../../../../global_assets/js/demo_pages/dashboard.js"></script>
	<script src="../../../../global_assets/js/demo_charts/pages/dashboard/light/streamgraph.js"></script>
	<script src="../../../../global_assets/js/demo_charts/pages/dashboard/light/sparklines.js"></script>
	<script src="../../../../global_assets/js/demo_charts/pages/dashboard/light/lines.js"></script>	
	<script src="../../../../global_assets/js/demo_charts/pages/dashboard/light/areas.js"></script>
	<script src="../../../../global_assets/js/demo_charts/pages/dashboard/light/donuts.js"></script>
	<script src="../../../../global_assets/js/demo_charts/pages/dashboard/light/bars.js"></script>
	<script src="../../../../global_assets/js/demo_charts/pages/dashboard/light/progress.js"></script>
	<script src="../../../../global_assets/js/demo_charts/pages/dashboard/light/heatmaps.js"></script>
	<script src="../../../../global_assets/js/demo_charts/pages/dashboard/light/pies.js"></script>
	<script src="../../../../global_assets/js/demo_charts/pages/dashboard/light/bullets.js"></script>
	<!-- /theme JS files -->

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
								<div class="header-elements">
									<div class="form-check form-check-right form-check-switchery form-check-switchery-sm">
									</div>
								</div>
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

							<!-- <div class="chart position-relative" id="traffic-sources"></div> -->
						</div>
						<!-- /statistics -->

					</div>
				</div>
				<!-- /main charts -->

				<!-- Dashboard content -->
				<div class="row">
					<div class="col-xl-12">

						<!-- Marketing campaigns -->
						<div class="card">
							<div class="card-header header-elements-sm-inline">
								<h6 class="card-title">Chapter Of {{ $bookTitle }}</h6>
								<div class="header-elements">
									<div class="list-icons ml-3">
				                		<div class="dropdown">
				                			<a href="#" class="list-icons-item dropdown-toggle" data-toggle="dropdown"><i class="icon-menu7"></i></a>
											<div class="dropdown-menu">
												<a href="#" class="dropdown-item"><i class="icon-sync"></i> Update data</a>
												<a href="#" class="dropdown-item"><i class="icon-list-unordered"></i> Detailed log</a>
												<a href="#" class="dropdown-item"><i class="icon-pie5"></i> Statistics</a>
												<div class="dropdown-divider"></div>
												<a href="#" class="dropdown-item"><i class="icon-cross3"></i> Clear list</a>
											</div>
				                		</div>
				                	</div>
			                	</div>
							</div>

							<div class="card-body d-sm-flex align-items-sm-center justify-content-sm-between flex-sm-wrap">
								
								<div>
									<a href="{{ route('books.export.excel') }}" class="btn bg-indigo-300">
										<i class="icon-statistics mr-2"></i> Export To Excel
									</a>
								</div>
							</div>

							<div class="table-responsive">
								<table class="table text-nowrap">
									<thead>
										<tr>
											<th>Title</th>
											<th>Publish Date</th>
											<th>Author</th>
											<th>Status</th>
											<th class="text-center" style="width: 20px;"><i class="icon-arrow-down12"></i></th>
										</tr>
									</thead>
									<tbody>
										@foreach($listChapters as $chapter)
										<tr>
											<td>
												<div class="d-flex align-items-center">
													<div class="mr-3">
														<a href="#">
															<img src="{{ $chapter->book && $chapter->chapter_cover ? asset('storage/' . $chapter->chapter_cover) : asset('storage/covers/book.jpg') }}"
																 class="rounded-circle" width="32" height="32" alt="">
														</a>
													</div>
													<div>
														<a href="#" class="text-default font-weight-semibold">{{ $chapter->title }}</a>
														<div class="text-muted font-size-sm">
															<span class="badge badge-mark border-blue mr-1"></span>
															{{ $chapter->created_at ? $chapter->created_at->format('d M Y') : '-' }}
														</div>
													</div>
												</div>
											</td>
											<!-- <td>
												<span class="badge badge-success">{{ $chapter->created_at ? $chapter->created_at->format('d M Y') : '-' }}</span> -->
											<td>
												<span class="text-muted">{{ $chapter->created_at ? $chapter->created_at->format('d M Y') : '-' }}</span>
											<td><span class="text-muted">{{ $chapter->book->author->name ?? '-' }}</span></td>
											<td><span class="badge bg-blue">{{ $chapter->status ?? '-' }}</span></td>	
											<td class="text-center">
												<div class="list-icons">
													<div class="dropdown">
														<a href="#" class="list-icons-item dropdown-toggle caret-0" data-toggle="dropdown"><i class="icon-menu7"></i></a>
														<div class="dropdown-menu dropdown-menu-right">
															<a href="{{ route('chapters.download_pdf', ['id' => $chapter->book_id, 'chapterId' => $chapter->id]) }}" class="dropdown-item">
																<i class="icon-file-stats"></i> Download
															</a>
															<a href="{{ route('chapters.edit', ['id' => $chapter->book_id, 'chapterId' => $chapter->id]) }}" class="dropdown-item">
																<i class="icon-file-text2"></i> Edit
															</a>
															<form action="{{ route('chapters.destroy', ['id' => $chapter->book_id, 'chapterId' => $chapter->id]) }}" method="POST" style="display:inline;">
																@csrf
																@method('DELETE')
																<button type="submit" class="dropdown-item" style="background:none; border:none; width:100%; text-align:left;">
																	<i class="icon-file-locked"></i> Delete
																</button>
															</form>
														</div>
													</div>
												</div>
											</td>
										</tr>
										@endforeach
									</tbody>
								</table>
							</div>
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
