@extends('admin.layouts.admin')

@section('title', 'Sản Phẩm')

@section('content')

<h2 class="mb-3">DANH SÁCH SẢN PHẨM</h2>

<table class="table table-bordered table-hover table-striped">
    <thead class="table-dark">
        <tr>
            <th>STT</th>
            <th>Ảnh</th>
            <th>ID</th>
            <th>Tên sản phẩm</th>
            <th>Danh mục</th>
            <th>Thương hiệu</th>
            <th>Giá</th>
            <th>Giá KM</th>
            <th>Trạng thái</th>
        </tr>
    </thead>

    <tbody>
        @foreach($list as $key => $item)
            <tr>
                <td>{{ $key + 1 }}</td>

                <td>
                    <img
                        src="{{ asset('images/product/' . (!empty($item->image) ? $item->image : 'default.png')) }}"
                        alt="{{ $item->productname }}"
                        width="80"
                        height="80"
                        class="img-thumbnail">
                </td>

                <td>{{ $item->id }}</td>
                <td>{{ $item->productname }}</td>
                <td>{{ $item->catename }}</td>
                <td>{{ $item->brandname }}</td>
                <td>{{ number_format($item->price) }} VNĐ</td>
                <td>{{ number_format($item->pricediscount) }} VNĐ</td>

                <td>
                    @if($item->status == 1)
                        <span class="badge bg-success">Hiển thị</span>
                    @else
                        <span class="badge bg-danger">Ẩn</span>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection