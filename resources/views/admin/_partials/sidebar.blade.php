<div class="admin-sidebar p-3 vh-100">

    <h4 class="sidebar-title mb-4">
        <i class="bi bi-speedometer2"></i>
        Admin
    </h4>

    <ul class="nav flex-column">

        {{-- Dashboard --}}
        <li class="nav-item mb-2">
            <a class="sidebar-link" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-house-door"></i>
                Dashboard
            </a>
        </li>


        {{-- Menu danh mục --}}
        <li class="nav-item mb-2">

            <a class="sidebar-link d-flex justify-content-between align-items-center"
               data-bs-toggle="collapse"
               href="#categoryMenu">

                <span>
                    <i class="bi bi-tags"></i>
                    Quản lý
                </span>

                <i class="bi bi-chevron-down"></i>

            </a>


            <div class="collapse mt-2" id="categoryMenu">

                <ul class="nav flex-column ms-3">


                    <li>
                        <a class="sidebar-sub-link"
                           href="{{ route('admin.categories.index') }}">
                            <i class="bi bi-tag"></i>
                            Loại sản phẩm
                        </a>
                    </li>


                    <li>
                        <a class="sidebar-sub-link"
                           href="{{ route('admin.brands.index') }}">
                            <i class="bi bi-bookmark"></i>
                            Thương hiệu
                        </a>
                    </li>


                    <li>
                        <a class="sidebar-sub-link"
                           href="{{ route('admin.users.index') }}">
                            <i class="bi bi-people"></i>
                            Người dùng
                        </a>
                    </li>


                    <li>
                        <a class="sidebar-sub-link"
                           href="{{ route('admin.products.index') }}">
                            <i class="bi bi-box-seam"></i>
                            Sản phẩm
                        </a>
                    </li>


                    <li>
                        <a class="sidebar-sub-link"
                           href="{{ route('admin.posts.index') }}">
                            <i class="bi bi-file-earmark-text"></i>
                            Bài viết
                        </a>
                    </li>

                </ul>

            </div>

        </li>


        {{-- Thêm sản phẩm --}}
        <li class="nav-item mt-2">

            <a class="sidebar-link"
               href="{{ route('admin.categories.create') }}">

                <i class="bi bi-plus-circle"></i>
                Thêm loại sản phẩm

            </a>

        </li>


    </ul>

</div>