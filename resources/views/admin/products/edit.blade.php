@extends('admin.layouts.admin')

@section('content')
    <div class="container">
        <h2>Sửa sản phẩm</h2>

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Lỗi!</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Tên sản phẩm</label>
                        <input type="text" name="productname"
                            class="form-control @error('productname') is-invalid @enderror" required
                            value="{{ old('productname', $product->productname) }}">
                        @error('productname')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Slug</label>
                        <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror"
                            value="{{ old('slug', $product->slug) }}">
                        @error('slug')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Loại sản phẩm</label>
                        <select name="cateid" class="form-select @error('cateid') is-invalid @enderror" required>
                            <option value="">-- Chọn loại sản phẩm --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->cateid }}"
                                    {{ old('cateid', $product->cateid) == $category->cateid ? 'selected' : '' }}>
                                    {{ $category->catename }}
                                </option>
                            @endforeach
                        </select>
                        @error('cateid')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Thương hiệu</label>
                        <select name="brandid" class="form-select @error('brandid') is-invalid @enderror">
                            <option value="">-- Chọn thương hiệu --</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}"
                                    {{ old('brandid', $product->brandid) == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->brandname }}
                                </option>
                            @endforeach
                        </select>
                        @error('brandid')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Giá</label>
                        <input type="number" name="price" class="form-control @error('price') is-invalid @enderror"
                            step="0.01" required value="{{ old('price', $product->price) }}">
                        @error('price')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Giá khuyến mãi</label>
                        <input type="number" name="pricediscount"
                            class="form-control @error('pricediscount') is-invalid @enderror" step="0.01"
                            value="{{ old('pricediscount', $product->pricediscount) }}">
                        @error('pricediscount')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label d-block">Trạng thái</label>
                        <input type="radio" class="btn-check" name="status" id="active" value="1"
                            {{ old('status', $product->status) == 1 ? 'checked' : '' }}>
                        <label class="btn btn-outline-success" for="active">Hiển thị</label>

                        <input type="radio" class="btn-check" name="status" id="inactive" value="0"
                            {{ old('status', $product->status) == 0 ? 'checked' : '' }}>
                        <label class="btn btn-outline-danger" for="inactive">Ẩn</label>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mô tả sản phẩm</label>
                        <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Hình ảnh</label>
                @if ($product->image)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->productname }}"
                            width="100" height="100" class="img-thumbnail">
                    </div>
                @endif
                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror"
                    accept="image/*">
                <small class="text-muted">Để trống nếu không thay đổi hình ảnh</small>
                @error('image')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <button type="submit" class="btn btn-primary">Cập nhật</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Quay lại</a>
            </div>
        </form>
    </div>
@endsection
