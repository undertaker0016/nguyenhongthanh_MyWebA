@extends('admin.layouts.admin')

@section('content')
<div class="container mt-3">
    <h3>Sửa người dùng</h3>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <strong>Lỗi!</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">

            {{-- LEFT --}}
            <div class="col-md-6">

                <div class="mb-3">
                    <label>Họ tên</label>
                    <input type="text" name="fullname"
                        class="form-control @error('fullname') is-invalid @enderror"
                        value="{{ old('fullname', $user->fullname) }}">
                    @error('fullname')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label>Tên đăng nhập</label>
                    <input type="text" name="username"
                        class="form-control @error('username') is-invalid @enderror"
                        value="{{ old('username', $user->username) }}">
                    @error('username')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email', $user->email) }}">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label>Mật khẩu (để trống nếu không đổi)</label>
                    <input type="password" name="password"
                        class="form-control @error('password') is-invalid @enderror">
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label>Điện thoại</label>
                    <input type="text" name="phone"
                        class="form-control @error('phone') is-invalid @enderror"
                        value="{{ old('phone', $user->phone) }}">
                    @error('phone')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- RIGHT --}}
            <div class="col-md-6">

                <div class="mb-3">
                    <label>Địa chỉ</label>
                    <input type="text" name="address"
                        class="form-control @error('address') is-invalid @enderror"
                        value="{{ old('address', $user->address) }}">
                    @error('address')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label>Giới tính</label>
                    <select name="gender" class="form-select @error('gender') is-invalid @enderror">
                        <option value="">-- Chọn giới tính --</option>
                        <option value="1" {{ old('gender', $user->gender) == 1 ? 'selected' : '' }}>Nam</option>
                        <option value="2" {{ old('gender', $user->gender) == 2 ? 'selected' : '' }}>Nữ</option>
                    </select>
                    @error('gender')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label>Ngày sinh</label>
                    <input type="date" name="birthday"
                        class="form-control @error('birthday') is-invalid @enderror"
                        value="{{ old('birthday', $user->birthday) }}">
                    @error('birthday')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label>Vai trò</label>
                    <select name="role" class="form-select @error('role') is-invalid @enderror">
                        <option value="">-- Chọn vai trò --</option>
                        @foreach ($roles as $key => $value)
                            <option value="{{ $key }}"
                                {{ old('role', $user->role) == $key ? 'selected' : '' }}>
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
                    @error('role')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label>Trạng thái</label>
                    <div class="d-flex gap-3">

                        <label>
                            <input type="radio" name="status" value="1"
                                {{ old('status', $user->status) == 1 ? 'checked' : '' }}>
                            Hoạt động
                        </label>

                        <label>
                            <input type="radio" name="status" value="0"
                                {{ old('status', $user->status) == 0 ? 'checked' : '' }}>
                            Khóa
                        </label>

                    </div>
                </div>

            </div>
        </div>

        <div class="mt-3">
            <button class="btn btn-primary">Cập nhật</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Quay lại</a>
        </div>

    </form>
</div>
@endsection