@extends('admin.layouts.admin')

@section('content')
    <div class="container">
        <h2>Sửa thương hiệu</h2>

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Lỗi!</strong>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('admin.brands.update', $brand->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Tên thương hiệu</label>
                <input type="text" name="brandname" class="form-control @error('brandname') is-invalid @enderror"
                    required value="{{ old('brandname', $brand->brandname) }}">
                @error('brandname')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label>Slug</label>
                <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" required
                    value="{{ old('slug', $brand->slug) }}">
                @error('slug')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label>Hình ảnh</label>
                @if ($brand->image)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $brand->image) }}" alt="{{ $brand->brandname }}" width="100"
                            height="100" class="img-thumbnail">
                    </div>
                @endif
                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror"
                    accept="image/*">
                @error('image')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label>Mô tả</label>
                <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description', $brand->description) }}</textarea>
                @error('description')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label>Thứ tự</label>
                <input type="number" name="sort_order" class="form-control @error('sort_order') is-invalid @enderror"
                    value="{{ old('sort_order', $brand->sort_order) }}">
                @error('sort_order')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label>Trạng thái</label>
                <select name="status" class="form-control @error('status') is-invalid @enderror">
                    <option value="1" {{ old('status', $brand->status) == 1 ? 'selected' : '' }}>Hiển thị</option>
                    <option value="0" {{ old('status', $brand->status) == 0 ? 'selected' : '' }}>Ẩn</option>
                </select>
                @error('status')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Cập nhật</button>
            <a href="{{ route('admin.brands.index') }}" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>
@endsection
