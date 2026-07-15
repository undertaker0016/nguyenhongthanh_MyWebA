<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt lại mật khẩu</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body{
            background: linear-gradient(135deg, #4f8dfd, #6f42c1);
            min-height: 100vh;
        }

        .reset-card{
            border: none;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,.15);
        }

        .logo{
            width: 80px;
            height: 80px;
            background: #0d6efd;
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 35px;
        }

        .form-control{
            border-radius: 12px;
            padding: 12px;
        }

        .btn{
            border-radius: 12px;
            padding: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-md-6 col-lg-5">

            <div class="card reset-card">
                <div class="card-body p-5">

                    <div class="logo">
                        <i class="bi bi-shield-lock-fill"></i>
                    </div>

                    <h3 class="text-center fw-bold mb-2">
                        Đặt lại mật khẩu
                    </h3>

                    <p class="text-center text-muted mb-4">
                        Nhập mật khẩu mới để tiếp tục.
                    </p>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('reset-password.post', ['token' => $token]) }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Mật khẩu mới
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-lock-fill"></i>
                                </span>
                                <input
                                    type="password"
                                    class="form-control"
                                    name="password"
                                    placeholder="Nhập mật khẩu mới"
                                    required
                                >
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                Xác nhận mật khẩu
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-lock-fill"></i>
                                </span>
                                <input
                                    type="password"
                                    class="form-control"
                                    name="password_confirmation"
                                    placeholder="Nhập lại mật khẩu"
                                    required
                                >
                            </div>
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                Đổi mật khẩu
                            </button>
                        </div>

                        <div class="d-grid">
                            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-2"></i>
                                Quay lại
                            </a>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>