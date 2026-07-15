@extends('admin.layouts.admin')
@section('title', 'Trash-Loại Sản phẩm')
@section('content')
    <h2 class="mb-3">DANH SÁCH LOẠI SẢN PHẨM - ĐANG CHỜ XÓA</h2>
    {{-- gọi component --}}
    <x-admin.alert />
    <div class="mb-3">

        <form action="{{ route('admin.categories.restoreAll') }}" method="POST" class="d-inline">
            @csrf
            @method('PATCH')
            <button class="btn btn-success">
                Khôi phục tất cả
            </button>
        </form>
        <form action="{{ route('admin.categories.forceDeleteAll') }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button onclick="return confirm('Xóa vĩnh viễn tất cả?')" class="btn btn-danger">

                Xóa tất cả
            </button>
        </form>
    </div>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-primary mb-2">
        <i class="bi bi-plus-circle"></i>
        Quay lại danh sách
    </a>
    <table class="table table-bordered table-hover table-striped">
        <thead class="table-dark">
            <tr>
                <th>STT</th>
                <th>Ảnh</th>
                <th>Mã loại</th>
                <th>Tên loại</th>
                <th>Slug</th>
                <th>Trạng thái</th>
                <th>Ngày tạo</th>
                <th>Chức năng</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($list as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <img src="{{ asset('storage/categories/' . ($item->image ?: 'default.png')) }}" alt=""
                            width="50">
                    </td>
                    <td>{{ $item->cateid }}</td>
                    <td>{{ $item->catename }}</td>
                    <td>{{ $item->slug }}</td>
                    <td>
                        @if ($item->status == 1)
                            <span class="badge bg-success">Hiển thị</span>
                        @else
                            <span class="badge bg-danger">Ẩn</span>
                        @endif
                    </td>
                    <td>{{ $item->created_at->format('d/m/Y') }}</td>
                    <td>
                        <form action="{{ route('admin.categories.restore', $item->cateid) }}" method="POST"
                            class="d-inline">

                            @csrf
                            @method('PATCH')
                            <button class="btn btn-success btn-sm">Khôi phục</button>
                        </form>
                        <form action="{{ route('admin.categories.forceDelete', $item->cateid) }}" method="POST"
                            class="d-inline">

                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Xóa vĩnh viễn?')"class="btn btn-danger btn-sm">
                                Xóa
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{-- hiển thị phân trang --}}
    {{ $list->links() }}
@endsection
