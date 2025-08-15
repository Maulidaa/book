<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Chapter Details</title>

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
							<div class="card-body">
								<h5 class="font-weight-bold mb-1 text-center">{{ $bookTitle }}</h5>
								<h6 class="mb-3 text-center">{{ $chapter->title }}</h6>
								<div class="mb-0" style="font-size: 1.1em;">
									{!! nl2br(e($chapter->content)) !!}
								</div>
								<h6 class="mb-3 text-center">End of Chapter</h6>
								<div class="text-center my-3">
									<form id="like-form" action="{{ route('chapters.likes.store', ['id' => $bookId, 'chapterId' => $chapter->id]) }}" method="POST" style="display:inline;">
										@csrf
										<button type="button" id="like-btn" class="btn btn-outline-primary">
											<i class="icon-thumbs-up2"></i>
											<span id="like-count">0</span> Like
										</button>
									</form>
								</div>
							</div>
							<div class="card-body">
<!-- Comments Section -->
<h6 class="mb-3">Comments</h6>
@if($comments && $comments->count())
    <button class="btn btn-outline-secondary mb-2" type="button" data-toggle="collapse" data-target="#commentsCollapse" aria-expanded="false" aria-controls="commentsCollapse">
        Show Comments ({{ $comments->count() }})
    </button>
    <div class="collapse show" id="commentsCollapse">
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

			// Ambil jumlah like saat load
			fetchLikes();

			// Like button click
			$('#like-btn').on('click', function(e) {
				e.preventDefault();
				$.ajax({
					url: "{{ route('chapters.likes.store', ['id' => $bookId, 'chapterId' => $chapter->id]) }}",
					type: "POST",
					data: {
						_token: "{{ csrf_token() }}",
						book_id: "{{ $bookId }}",
						chapter_id: "{{ $chapter->id }}"
					},
					success: function(response) {
						fetchLikes();
					}
				});
			});

			// Ambil jumlah like
			function fetchLikes() {
				$.get("{{ route('chapters.likes.show', ['id' => $bookId, 'chapterId' => $chapter->id]) }}", function(data) {
					if (Array.isArray(data)) {
						$('#like-count').text(data.length);
					} else {
						$('#like-count').text(0);
					}
				});
			}
		});
	</script>
</body>
</html>
