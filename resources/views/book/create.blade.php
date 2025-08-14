<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Create Book</title>

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

                                <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label class="mb-1">Book Title</label>
                                        <input type="text" name="title" class="form-control" placeholder="Enter book title" required>
                                    </div>
                                    @if($user->role_id == 1)
                                        <div class="form-group">
                                            <label class="mb-1">Author</label>
                                            <select name="author_id" class="form-control select2" required data-placeholder="-- Select Author --">
                                                <option value="">-- Select Author --</option>
                                                @foreach($authors as $id => $name)
                                                    <option value="{{ $id }}">{{ $name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif
                                    <div class="form-group">
                                        <label class="mb-1">ISBN</label>
                                        <input type="text" name="isbn" class="form-control" placeholder="Enter ISBN">
                                    </div>
                                    <div class="form-group">
                                        <label class="mb-1">Category</label>
                                        <select name="category_id" class="form-control select2" required data-placeholder="-- Select Category --">
                                            <option value="">-- Select Category --</option>
                                            @foreach($categories ?? [] as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="mb-1">Description</label>
                                        <textarea name="description" class="form-control" rows="3" placeholder="Book description"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="mb-1">Cover Image</label>
                                        <input type="file" name="cover" class="form-control-file" id="cover-input">
                                        <img id="cover-preview" src="#" alt="Cover Preview" style="display:none; max-width:150px; margin-top:10px;" />
                                    </div>
                                    <button type="submit" class="btn bg-indigo-300 btn-block">Create Book</button>
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
