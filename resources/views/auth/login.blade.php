@extends('auth.template.master')

@section('content')

<body class="hold-transition login-page" style="background: #f4f6f9;">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary shadow-lg rounded-3">
            <div class="card-header text-center bg-white border-0">
                <a href="#" class="h1" style="font-weight: bold; color: #007bff;"><b>Kasir</b>Jojo</a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Masuk dengan menggunakan akun anda</p>

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('login.check') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-group">
                            <input type="email" class="form-control rounded-start" name="email" placeholder="Email" required>
                            <div class="input-group-text rounded-end">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control rounded-start" name="password" placeholder="Password" required>
                            <div class="input-group-text rounded-end">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block btn-lg rounded-pill">Sign In</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->
</body>

@endsection
