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
            <h3>Danh sách thương hiệu</h3>

            <a href="{{ route('admin.brands.create') }}" class="btn btn-primary">
                + Thêm thương hiệu
            </a>
        </div>

        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>STT</th>
                    <th>Ảnh</th>
                    <th>Mã thương hiệu</th>
                    <th>Tên thương hiệu</th>
                    <th>Slug</th>
                    <th>Trạng thái</th>
                    <th>Ngày tạo</th>
                    <th>Chức năng</th>
                </tr>
            </thead>

            <tbody>
                @forelse($list as $key => $item)
                    <tr>
                        <td>{{ $key + 1 }}</td>

                        <td>
                            <img src="{{ asset('images/brand/' . ($item->image ?: 'default.png')) }}"
                                alt="{{ $item->brandname }}" width="80" height="80" class="img-thumbnail rounded">
                        </td>

                        <td>{{ $item->id }}</td>

                        <td>{{ $item->brandname }}</td>

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
                            <a href="{{ route('admin.brands.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                Sửa
                            </a>

                            <form action="{{ route('admin.brands.destroy', $item->id) }}" method="POST"
                                style="display:inline-block" onsubmit="return confirm('Bạn có chắc muốn xóa không?')">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger btn-sm">
                                    Xóa
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">
                            Không có thương hiệu nào
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
@endsection
