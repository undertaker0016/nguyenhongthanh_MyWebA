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
            <h3>Danh sách bài viết</h3>

            <div>
                <a href="{{ route('admin.posts.trash') }}" class="btn btn-outline-secondary">
                    Thùng rác ({{ $trashCount ?? 0 }})
                </a>
                <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
                    + Thêm bài viết
                </a>
            </div>
        </div>

        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Tiêu đề</th>
                    <th>Slug</th>
                    <th>Hình ảnh</th>
                    <th>Trạng thái</th>
                    <th>Ngày tạo</th>
                    <th>Chức năng</th>
                </tr>
            </thead>

            <tbody>
                @forelse($list as $item)
                    <tr>
                        <td>{{ $item->id }}</td>

                        <td>{{ $item->title }}</td>

                        <td>{{ $item->slug }}</td>

                        <td>
                            <img src="{{ asset('storage/posts/' . ($item->image ?: 'default.png')) }}"
                                alt="{{ $item->catename }}" width="80" height="80" class="img-thumbnail rounded">
                        </td>

                        <td>
                            @if ($item->status)
                                <span class="badge bg-success">Hiển thị</span>
                            @else
                                <span class="badge bg-danger">Ẩn</span>
                            @endif
                        </td>

                        <td>
                            {{ $item->created_at?->format('d/m/Y H:i') }}
                        </td>

                        <td>
                            <a href="{{ route('admin.posts.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                Sửa
                            </a>

                            <form action="{{ route('admin.posts.destroy', $item->id) }}" method="POST"
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
                        <td colspan="7" class="text-center text-muted">
                            Không có bài viết nào
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
@endsection
