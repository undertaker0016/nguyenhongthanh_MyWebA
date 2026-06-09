
@extends('admin.layouts.admin')

@section('title', 'Loại Sản Phẩm')

@section('content')

<h2 class="mb-3">DANH SÁCH LOẠI SẢN PHẨM</h2>
<a href="{{ route('admin.categories.create') }}" class="btn btn-success mb-3">
    + Thêm mới
</a>
<table class="table table-bordered table-hover table-striped">
    <thead class="table-dark">
        <tr>
            <th>STT</th>
            <th>Ảnh</th>
            <th>Mã loại</th>
            <th>Tên loại</th>
            <th>Slug</th>
            <th>Trạng thái</th>
             <th>Chức năng</th>
        </tr>
    </thead>

    <tbody>
        
        @foreach($list as $key => $item)
            <tr>
                <td>{{ $key + 1 }}</td>

                <td>
                    <img
                        src="{{ asset('images/category/' . (!empty($item->image) ? $item->image : 'default.png')) }}"
                        alt="{{ $item->catename }}"
                        width="80"
                        height="80"
                        class="img-thumbnail">
                </td>

                <td>{{ $item->cateid }}</td>
                <td>{{ $item->catename }}</td>
                <td>{{ $item->slug }}</td>
                    
                <td>
                    @if($item->status == 1)
                        <span class="badge bg-success">Hiển thị</span>
                    @else
                        <span class="badge bg-danger">Ẩn</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.categories.edit', $item->cateid) }}" class="btn btn-warning btn-sm">
                        Sửa
                    </a> 
                    <form action="{{ route('admin.categories.destroy', $item->cateid) }}"
                        method="POST"
                        onsubmit="return confirm('Bạn có chắc muốn xóa không?')">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger btn-sm">
                            Xóa
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="d-flex justify-content-center">
    {{ $list->links() }}
</div>
@endsection