<div class="admin-sidebar bg-dark text-white p-3 vh-100">
    <h4 class="mb-4">
        <i class="bi bi-speedometer2"></i>
        Admin
    </h4>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('admin.dashboard') }}"> <i class="bi bi-house-door"></i>
                Dashboard
            </a>
        </li>
        </li>
        {{-- Menu expand --}}
        <li class="nav-item">
            <a class="nav-link text-white" data-bs-toggle="collapse" href="#categoryMenu"> <i class="bi bi-tags">
                </i> Quản lý danh mục <i class="bi bi-chevron-down float-end"></i>
            </a>
            <div class="collapse" id="categoryMenu">
                <ul class="nav flex-column ms-3">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('admin.categories.index') }}"> Loại sản phẩm</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('admin.brands.index') }}">
                            Thương hiệu
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('admin.users.index') }}">
                            <i class="bi bi-people"></i>
                            Người dùng
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('admin.products.index') }}">
                            <i class="bi bi-box-seam"></i>
                            Sản phẩm
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('admin.posts.index') }}">
                            <i class="bi bi-file-earmark-text"></i>
                            Bài viết
                        </a>
                    </li>
        </li>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('admin.categories.create') }}"> Thêm loại sản phẩm</a>
        </li>
    </ul>
</div>

</div>
