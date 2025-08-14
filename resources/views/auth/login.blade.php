{{-- filepath: resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Login - Book App</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet">
    <link href="{{ asset('global_assets/css/icons/icomoon/styles.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/bootstrap_limitless.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/layout.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/components.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/colors.min.css') }}" rel="stylesheet">
    <!-- /global stylesheets -->
</head>
<body>

    <div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh;">
        <div class="card w-100" style="max-width: 400px;">
            <div class="card-body">
                <div class="text-center mb-3">
                    <i class="icon-user-lock icon-2x text-indigo-300"></i>
                    <h5 class="mb-0 mt-2">Login to your account</h5>
                </div>
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <label class="mb-0">Email:</label>
                        <input type="email" name="email" class="form-control" required autofocus>
                    </div>
                    <div class="form-group">
                        <label class="mb-0">Password:</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn bg-indigo-300 btn-block">Login</button>
                </form>
                <div class="text-center mt-3">
                    <a href="{{ route('register') }}">Don't have an account? Register</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Core JS files -->
    <script src="{{ asset('global_assets/js/main/jquery.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/main/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
</body>
</html>