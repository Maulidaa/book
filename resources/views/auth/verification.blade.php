
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Email Verification</title>
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">Verifikasi Email</h5>
                    </div>
                    <div class="card-body text-center">
                        @if(isset($status) && $status == 'success')
                            <div class="alert alert-success">
                                {{ $message ?? 'Email berhasil diverifikasi. Silakan login.' }}
                            </div>
                            <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                        @else
                            <div class="alert alert-danger">
                                {{ $message ?? 'Token tidak valid atau sudah digunakan.' }}
                            </div>
                            <a href="{{ route('login') }}" class="btn btn-secondary">Kembali ke Login</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>