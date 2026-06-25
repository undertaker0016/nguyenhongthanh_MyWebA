@extends('admin.layouts.admin')

@section('title', 'Người Dùng')

@section('content')

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Thành công!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Lỗi!</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Danh sách người dùng</h3>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            + Thêm người dùng
        </a>
    </div>

    <table class="table table-bordered table-hover align-middle">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Họ tên</th>
                <th>Tên đăng nhập</th>
                <th>Email</th>
                <th>Điện thoại</th>
                <th>Vai trò</th>
                <th>Trạng thái</th>
                <th>Chức năng</th>
            </tr>
        </thead>

        <tbody>
            @forelse($list as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->fullname }}</td>
                    <td>{{ $item->username }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->phone }}</td>
                    <td>
                        @if ($item->role == 'admin')
                            <span class="badge bg-dark">Quản trị viên</span>
                        @else
                            <span class="badge bg-secondary">Người dùng</span>
                        @endif
                    </td>
                    <td>
                        @if ($item->status == 1)
                            <span class="badge bg-success">Hoạt động</span>
                        @else
                            <span class="badge bg-danger">Khóa</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.users.edit', $item->id) }}" class="btn btn-warning btn-sm">
                            Sửa
                        </a>

                        <form action="{{ route('admin.users.destroy', $item->id) }}" method="POST"
                            style="display:inline-block" onsubmit="return confirm('Bạn có chắc muốn xóa?')">
                            @csrf
                            @method('DELETE')

                            <button class="btn btn-danger btn-sm">
                                Xóa
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center text-muted">
                        Không có người dùng nào
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

@endsection
