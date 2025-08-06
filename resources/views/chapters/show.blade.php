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
											<th>Publish</th>
											<th>Author</th>
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
															<img src="{{ $chapter->book && $chapter->book->url_cover ? asset('storage/' . $chapter->book->url_cover) : asset('storage/covers/book.jpg') }}"
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
											<td><span class="text-muted">{{ $chapter->book->author ?? '-' }}</span></td>
											<td><span class="text-success-600">{{ $chapter->book->isbn ?? '-' }}</span></td>
											<td class="text-center">
												<div class="list-icons">
													<div class="dropdown">
														<a href="#" class="list-icons-item dropdown-toggle caret-0" data-toggle="dropdown"><i class="icon-menu7"></i></a>
														<div class="dropdown-menu dropdown-menu-right">
															<a href="{{ route('chapters.download_pdf', ['bookId' => $chapter->book_id, 'chapterId' => $chapter->id]) }}" class="dropdown-item">
																<i class="icon-file-stats"></i> Download
															</a>
															<a href="#" class="dropdown-item">
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
	<div class="navbar navbar-expand-lg navbar-light">
		<div class="text-center d-lg-none w-100">
			<button type="button" class="navbar-toggler dropdown-toggle" data-toggle="collapse" data-target="#navbar-footer">
				<i class="icon-unfold mr-2"></i>
				Footer
			</button>
		</div>

		<div class="navbar-collapse collapse" id="navbar-footer">
			<span class="navbar-text">
				&copy; 2015 - 2018. <a href="#">Limitless Web App Kit</a> by <a href="http://themeforest.net/user/Kopyov" target="_blank">Eugene Kopyov</a>
			</span>

			<ul class="navbar-nav ml-lg-auto">
				<li class="nav-item"><a href="https://kopyov.ticksy.com/" class="navbar-nav-link" target="_blank"><i class="icon-lifebuoy mr-2"></i> Support</a></li>
				<li class="nav-item"><a href="http://demo.interface.club/limitless/docs/" class="navbar-nav-link" target="_blank"><i class="icon-file-text2 mr-2"></i> Docs</a></li>
				<li class="nav-item"><a href="https://themeforest.net/item/limitless-responsive-web-application-kit/13080328?ref=kopyov" class="navbar-nav-link font-weight-semibold"><span class="text-pink-400"><i class="icon-cart2 mr-2"></i> Purchase</span></a></li>
			</ul>
		</div>
	</div>
	<!-- /footer -->
		
</body>
</html>
