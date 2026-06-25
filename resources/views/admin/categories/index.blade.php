@extends('admin.layouts.admin')

@section('content')
    <div class="container mt-3">

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
            <h3>Danh sách loại sản phẩm</h3>

            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                + Thêm loại sản phẩm
            </a>
        </div>

        <table class="table table-bordered table-hover align-middle">
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
                @forelse($list as $key => $item)
                    <tr>
                        <td>{{ $list->firstItem() + $key }}</td>

                        <td>
                            <img src="{{ asset('images/category/' . ($item->image ?: 'default.png')) }}"
                                alt="{{ $item->catename }}" width="80" height="80" class="img-thumbnail rounded">
                        </td>

                        <td>{{ $item->cateid }}</td>

                        <td>{{ $item->catename }}</td>

                        <td>{{ $item->slug }}</td>

                        <td>
                            @if ($item->status)
                                <span class="badge bg-success">
                                    Hiển thị
                                </span>
                            @else
                                <span class="badge bg-danger">
                                    Ẩn
                                </span>
                            @endif
                        </td>

                        <td>
                            {{ $item->created_at?->format('d/m/Y H:i') }}
                        </td>

                        <td>
                            <a href="{{ route('admin.categories.edit', $item->cateid) }}" class="btn btn-warning btn-sm">
                                Sửa
                            </a>

                            <form action="{{ route('admin.categories.destroy', $item->cateid) }}" method="POST"
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
                            Không có loại sản phẩm nào
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="d-flex justify-content-center">
            {{ $list->links() }}
        </div>
        ```

    </div>
@endsection
