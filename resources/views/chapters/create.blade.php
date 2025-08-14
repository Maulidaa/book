<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Create New Chapter</title>

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
								<h5 class="card-title">New Chapter of {{ $bookTitle }}</h5>
								<div class="header-elements">
									<div class="list-icons">
										<a class="list-icons-item" data-action="collapse"></a>
										<a class="list-icons-item" data-action="reload"></a>
										<a class="list-icons-item" data-action="remove"></a>
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

                                <form action="{{ route('chapters.store', ['id' => $bookId]) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label class="mb-1">Chapter Cover</label>
                                        <input type="file" name="chapter_cover" class="form-control-file" id="cover-input">
                                        <img id="cover-preview"
                                             src="{{ asset('storage/covers/book.jpg') }}"
                                             alt="Cover Preview"
                                             style="max-width:150px; margin-top:10px; display:none;" />
                                    </div>
                                    <div class="form-group">
                                        <label class="mb-1">Title</label>
                                        <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="mb-1">Content</label>
                                        <textarea name="content" class="form-control" rows="10" required>{{ old('content') }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="mb-1">Status</label>
                                        <select name="status" class="form-control" required>
                                            <option value="">- Choose Status -</option>
                                            <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                                            <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                            <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>Archived</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn bg-indigo-300 btn-block">Save Chapter</button>
                                </form>

                                <script>
                                $(document).ready(function() {
                                    $('#cover-input').on('change', function(){
                                        const [file] = this.files;
                                        if (file) {
                                            $('#cover-preview').attr('src', URL.createObjectURL(file)).show();
                                        } else {
                                            $('#cover-preview').hide();
                                        }
                                    });
                                });
                                </script>
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
