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

	<!-- Select2 CSS -->
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.6.2/dist/select2-bootstrap4.min.css" rel="stylesheet" />
	<!-- Select2 JS -->
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
							<div class="card-body">
								<h5 class="font-weight-bold mb-1 text-center">{{ $bookTitle }}</h5>
								<h6 class="mb-3 text-center">{{ $chapter->title }}</h6>
								<div class="mb-0" style="font-size: 1.1em;">
									{!! nl2br(e($chapter->content)) !!}
								</div>
								<h6 class="mb-3 text-center">End of Chapter</h6>
							</div>
							<div class="card-body">
<!-- Comments Section -->
<h6 class="mb-3">Comments</h6>
@if($comments && $comments->count())
    <button class="btn btn-outline-secondary mb-2" type="button" data-toggle="collapse" data-target="#commentsCollapse" aria-expanded="false" aria-controls="commentsCollapse">
        Show Comments ({{ $comments->count() }})
    </button>
    <div class="collapse" id="commentsCollapse">
        <div class="card card-body">
            @foreach($comments as $comment)
                <div class="mb-2">
                    <strong>{{ $comment->user->name ?? 'Anonymous' }}:</strong>
                    <div>{!! nl2br(e($comment->content)) !!}</div>
                    <small class="text-muted">{{ $comment->created_at->format('d M Y H:i') }}</small>
                </div>
                @if(!$loop->last)
                    <hr class="my-1">
                @endif
            @endforeach
        </div>
    </div>
@else
    <div class="text-muted mb-3">No comments yet.</div>
@endif

<h6 class="mb-3 mt-3">Add a Comment</h6>
<form action="{{ route('chapters.comments.store', ['id' => $bookId, 'chapterId' => $chapter->id]) }}" method="POST">
    @csrf
    <div class="form-group">
        <textarea name="content" class="form-control" rows="3" placeholder="Write your comment..."></textarea>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary">Submit Comment</button>
    </div>
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
			// Select2 tetap
			$('.select2').select2({
				theme: 'bootstrap4',
				placeholder: function(){
					$(this).data('placeholder');
				},
				allowClear: true
			});

			// Autosize textarea
			$('textarea').each(function () {
				this.setAttribute('style', 'height:' + (this.scrollHeight) + 'px;overflow-y:hidden;');
			}).on('input', function () {
				this.style.height = 'auto';
				this.style.height = (this.scrollHeight) + 'px';
			});
		});
	</script>
</body>
</html>
