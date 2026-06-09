@extends('admin.layouts.admin')

@section('title', 'Sản Phẩm')

@section('content')

<h2 class="mb-3">DANH SÁCH SẢN PHẨM</h2>

<table class="table table-bordered table-hover table-striped">
    <thead class="table-dark">
        <tr>
            <th>STT</th>
            <th>Tên sản phẩm</th>
            <th>Danh mục</th>
            <th>Thương hiệu</th>
            <th>Giá</th>
            <th>Giá KM</th>
            <th>Trạng thái</th>
            <th>Chức năng</th>
        </tr>
    </thead>

    <tbody>
@forelse($list as $item)
<tr>
    <td>{{ $list->firstItem() + $loop->index }}</td>

    <td>{{ $item->productname }}</td>

    <td>{{ $item->category?->catename }}</td>

    <td>{{ $item->brand?->brandname }}</td>

    <td>{{ number_format($item->price) }} ₫</td>

    <td>
        {{ number_format($item->sale_price ?? 0) }} ₫
    </td>

    <td>
        @if($item->status)
            <span class="badge bg-success">Hiển thị</span>
        @else
            <span class="badge bg-danger">Ẩn</span>
        @endif
    </td>

    <td>
        <a href="{{ route('admin.products.edit', $item->id) }}" class="btn btn-warning btn-sm">
            <i class="bi bi-pencil-square"></i>
        </a>

        <a href="{{ route('admin.products.destroy', $item->id) }}"
           class="btn btn-danger btn-sm"
           onclick="return confirm('Bạn có chắc muốn xóa?')">
            <i class="bi bi-trash"></i>
        </a>
    </td>
</tr>
@empty
<tr>
    <td colspan="8" class="text-center">Không có dữ liệu</td>
</tr>
@endforelse
</tbody>
</table>

@endsection