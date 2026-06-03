@extends('admin.layouts.admin')

@section('title', 'Người Dùng')

@section('content')

<h2 class="mb-3">DANH SÁCH NGƯỜI DÙNG</h2>

<table class="table table-bordered table-hover table-striped">
    <thead class="table-dark">
        <tr>
            <th>STT</th>
            <th>Ảnh</th>
            <th>ID</th>
            <th>Họ và tên</th>
            <th>Tên đăng nhập</th>
            <th>Email</th>
            <th>Số điện thoại</th>
            <th>Vai trò</th>
            <th>Trạng thái</th>
        </tr>
    </thead>

    <tbody>
        @foreach($list as $key => $item)
            <tr>
                <td>{{ $key + 1 }}</td>

                <td>
                    <img
                        src="{{ asset('images/user/default.png') }}"
                        alt="User Avatar"
                        width="80"
                        height="80"
                        class="img-thumbnail">
                </td>

                <td>{{ $item->id }}</td>
                <td>{{ $item->fullname }}</td>
                <td>{{ $item->username }}</td>
                <td>{{ $item->email }}</td>
                <td>{{ $item->phone }}</td>
                <td>{{ $item->role }}</td>

                <td>
                    @if($item->status == 1)
                        <span class="badge bg-success">Hoạt động</span>
                    @else
                        <span class="badge bg-danger">Khóa</span>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection