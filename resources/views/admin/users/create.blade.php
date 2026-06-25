@extends('admin.layouts.admin')

@section('content')
<div class="container mt-3">
    <h3>Thêm người dùng</h3>

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Lỗi!</strong>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Họ tên</label>
                    <input type="text" name="fullname" class="form-control @error('fullname') is-invalid @enderror" required value="{{ old('fullname') }}">
                    @error('fullname')<span class="text-danger">{{ $message }}</span>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Tên đăng nhập</label>
                    <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" required value="{{ old('username') }}">
                    @error('username')<span class="text-danger">{{ $message }}</span>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" required value="{{ old('email') }}">
                    @error('email')<span class="text-danger">{{ $message }}</span>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Mật khẩu</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                    @error('password')<span class="text-danger">{{ $message }}</span>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Điện thoại</label>
                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}">
                    @error('phone')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Địa chỉ</label>
                    <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address') }}">
                    @error('address')<span class="text-danger">{{ $message }}</span>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Giới tính</label>
                    <select name="gender" class="form-select @error('gender') is-invalid @enderror">
                        <option value="">-- Chọn giới tính --</option>
                        <option value="Nam" {{ old('gender') == 'Nam' ? 'selected' : '' }}>Nam</option>
                        <option value="Nữ" {{ old('gender') == 'Nữ' ? 'selected' : '' }}>Nữ</option>
                    </select>
                    @error('gender')<span class="text-danger">{{ $message }}</span>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Ngày sinh</label>
                    <input type="date" name="birthday" class="form-control @error('birthday') is-invalid @enderror" value="{{ old('birthday') }}">
                    @error('birthday')<span class="text-danger">{{ $message }}</span>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Vai trò</label>
                    <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                        <option value="">-- Chọn vai trò --</option>
                        @foreach($roles as $key => $value)
                            <option value="{{ $key }}" {{ old('role') == $key ? 'selected' : '' }}>
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
                    @error('role')<span class="text-danger">{{ $message }}</span>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label d-block">Trạng thái</label>
                    <input type="radio" class="btn-check" name="status" id="active" value="1" {{ old('status', 1) == 1 ? 'checked' : '' }}>
                    <label class="btn btn-outline-success" for="active">Hoạt động</label>

                    <input type="radio" class="btn-check" name="status" id="inactive" value="0" {{ old('status') == 0 ? 'checked' : '' }}>
                    <label class="btn btn-outline-danger" for="inactive">Khóa</label>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Lưu</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Quay lại</a>
        </div>
    </form>
</div>
@endsection
