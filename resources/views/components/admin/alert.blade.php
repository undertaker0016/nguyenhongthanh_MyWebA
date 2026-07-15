{{-- hiển thị tất cả các thông báo lỗi validation --}}
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

{{-- thông báo thành công --}}
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Thành công!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

{{-- thông báo lỗi --}}
@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Lỗi!</strong> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

{{-- thông báo message --}}
@if (session('message'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Lỗi!</strong> {{ session('message') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif