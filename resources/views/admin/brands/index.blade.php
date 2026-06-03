@extends('admin.layouts.admin')

@section('title', 'Thương Hiệu')

@section('content')

<h2 class="mb-3">DANH SÁCH THƯƠNG HIỆU</h2>

<table class="table table-bordered table-hover table-striped">
    <thead class="table-dark">
        <tr>
            <th>STT</th>
            <th>Ảnh</th>
            <th>Mã thương hiệu</th>
            <th>Tên thương hiệu</th>
            <th>Slug</th>
            <th>Trạng thái</th>
        </tr>
    </thead>

    <tbody>
        @foreach($list as $key => $item)
            <tr>
                <td>{{ $key + 1 }}</td>

                <td>
                    <img
                        src="{{ asset('images/brand/' . (!empty($item->image) ? $item->image : 'default.png')) }}"
                        alt="{{ $item->brandname }}"
                        width="80"
                        height="80"
                        class="img-thumbnail">
                </td>

                <td>{{ $item->id }}</td>
                <td>{{ $item->brandname }}</td>
                <td>{{ $item->slug }}</td>

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