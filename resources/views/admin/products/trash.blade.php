@extends('admin.layouts.admin')
@section('title', 'Thùng rác sản phẩm')
@section('content')
    <h2 class="mb-3">THÙNG RÁC SẢN PHẨM</h2>
    <x-admin.alert />

    <div class="mb-3">
        <form action="{{ route('admin.products.restoreAll') }}" method="POST" class="d-inline">
            @csrf
            @method('PATCH')
            <button class="btn btn-success">Khôi phục tất cả</button>
        </form>
        <form action="{{ route('admin.products.forceDeleteAll') }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button onclick="return confirm('Xóa vĩnh viễn tất cả?')" class="btn btn-danger">Xóa tất cả</button>
        </form>
        <a href="{{ route('admin.products.index') }}" class="btn btn-primary">Quay lại danh sách</a>
    </div>

    <table class="table table-bordered table-hover table-striped">
        <thead class="table-dark">
            <tr>
                <th>STT</th>
                <th>Tên sản phẩm</th>
                <th>Slug</th>
                <th>Ngày xóa</th>
                <th>Chức năng</th>
            </tr>
        </thead>
        <tbody>
            @forelse($list as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->productname }}</td>
                    <td>{{ $item->slug }}</td>
                    <td>{{ $item->deleted_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <form action="{{ route('admin.products.restore', $item->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button class="btn btn-success btn-sm">Khôi phục</button>
                        </form>
                        <form action="{{ route('admin.products.forceDelete', $item->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Xóa vĩnh viễn?')" class="btn btn-danger btn-sm">Xóa</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center">Không có dữ liệu trong thùng rác</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $list->links() }}
@endsection
