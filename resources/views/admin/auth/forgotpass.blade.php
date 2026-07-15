<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên mật khẩu</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">

        <form action="{{ route('admin.forgotpass.post') }}" method="POST" class="mx-auto shadow p-4 w-50 bg-light">

            @csrf

            <h2 class="mb-3">Quên mật khẩu</h2>


            @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif


            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif


            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif



            <div class="mb-3">

                <label>Email</label>

                <input type="email" class="form-control" name="email" value="{{ old('email') }}">

            </div>


            <div class="d-flex gap-2">

                <button class="btn btn-primary">
                    Gửi
                </button>


                <a href="{{ route('admin.login') }}" class="btn btn-warning">
                    Đăng nhập
                </a>

            </div>


        </form>

    </div>

</body>

</html>
