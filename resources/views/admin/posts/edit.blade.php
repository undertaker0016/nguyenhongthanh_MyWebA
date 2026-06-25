@extends('admin.layouts.admin')

@section('content')
    <div class="container mt-3">
        <h3>Sửa bài viết</h3>

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Lỗi!</strong>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form action="{{ route('admin.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label">Tiêu đề</label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                            required value="{{ old('title', $post->title) }}">
                        @error('title')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Slug</label>
                        <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror"
                            required value="{{ old('slug', $post->slug) }}">
                        @error('slug')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nội dung</label>
                        <textarea name="content" class="form-control @error('content') is-invalid @enderror" rows="8" required>{{ old('content', $post->content) }}</textarea>
                        @error('content')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Tác giả</label>
                        <select name="user_id" class="form-select @error('user_id') is-invalid @enderror" required>
                            <option value="">-- Chọn tác giả --</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ old('user_id', $post->user_id) == $user->id ? 'selected' : '' }}>
                                    {{ $user->fullname }}
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label d-block">Trạng thái</label>
                        <input type="radio" class="btn-check" name="status" id="status_active" value="1"
                            {{ old('status', $post->status) == 1 ? 'checked' : '' }}>
                        <label class="btn btn-outline-success" for="status_active">Hiển thị</label>

                        <input type="radio" class="btn-check" name="status" id="status_inactive" value="0"
                            {{ old('status', $post->status) == 0 ? 'checked' : '' }}>
                        <label class="btn btn-outline-danger" for="status_inactive">Ẩn</label>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Hình ảnh</label>
                        @if ($post->image)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $post->image) }}" alt="Current image"
                                    style="max-width: 100%; height: auto;">
                            </div>
                        @endif
                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror"
                            accept="image/*">
                        @error('image')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Cập nhật</button>
                <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">Quay lại</a>
            </div>
        </form>
    </div>
@endsection
