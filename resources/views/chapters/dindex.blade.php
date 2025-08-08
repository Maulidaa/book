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

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">

    <!-- Core JS files -->
    <script src="{{ asset('global_assets/js/main/jquery.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/main/bootstrap.bundle.min.js') }}"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>
</head>

<body>
    @include('main.navbar')
    @include('main.header')
    <div class="page-content pt-0">
        @include('main.sidebar')
        <div class="content-wrapper">
            <div class="content">
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
                <!-- /main charts -->

                <div class="row">
                    <div class="col-xl-12">
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
                                    <a href="{{ route('chapters.download_all', ['id' => $bookId]) }}" class="btn bg-indigo-300">
                                        <i class="icon-statistics mr-2"></i> Export All Chapters
                                    </a>
                                </div>
                            </div>
                            <!-- Tabel Chapter -->
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('main.footer')
</body>
</html>
