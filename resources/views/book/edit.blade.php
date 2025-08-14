<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Limitless - Responsive Web Application Kit by Eugene Kopyov</title>

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
								<h5 class="card-title">Create a New Book</h5>
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

                                <form action="{{ route('books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label class="mb-1">Book Title</label>
                                        <input type="text" name="title" class="form-control" placeholder="Enter book title" required value="{{ old('title', $book->title) }}">
                                    </div>
                                    @if($user->role_id == 1)
                                        <div class="form-group">
                                            <label class="mb-1">Author</label>
                                            <select name="author_id" class="form-control select2" required data-placeholder="-- Select Author --" >
                                                <option value="">-- Select Author --</option>
                                                @foreach($authors as $id => $name)
                                                    <option value="{{ $id }}" {{ $id == old('author_id', $book->author_id) ? 'selected' : '' }}>{{ $name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif
                                    <div class="form-group">
                                        <label class="mb-1">ISBN</label>
                                        <input type="text" name="isbn" class="form-control" placeholder="Enter ISBN" required value="{{ old('isbn', $book->isbn) }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="mb-1">Category</label>
                                        <select name="category_id" class="form-control select2" required data-placeholder="-- Select Category --">
                                            <option value="">-- Select Category --</option>
                                            @foreach($categories ?? [] as $category)
                                                <option value="{{ $category->id }}" {{ $category->id == old('category_id', $book->category_id) ? 'selected' : '' }}>{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="mb-1">Description</label>
                                        <textarea name="description" class="form-control" rows="3" placeholder="Book description">{{ old('description', $book->description) }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="mb-1">Cover Image</label>
                                        <input type="file" name="cover" class="form-control-file" id="cover-input">
                                        @if($book->url_cover)
                                            <img id="cover-preview" src="{{ asset('storage/' . $book->url_cover) }}" alt="Cover Preview" style="display:block; max-width:150px; margin-top:10px;" />
                                        @else
                                            <img id="cover-preview" src="#" alt="Cover Preview" style="display:none; max-width:150px; margin-top:10px;" />
                                        @endif
                                    </div>
                                    <button type="submit" class="btn bg-indigo-300 btn-block">Update Book</button>
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
		
	<script>
		$(document).ready(function() {
			$('.select2').select2({
				theme: 'bootstrap4',
				placeholder: function(){
					$(this).data('placeholder');
				},
				allowClear: true
			});

			// Preview cover image
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
</body>
</html>
