<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #e3f2fd;">
    <!-- Container wrapper -->
    <div class="container">
        <!-- Toggle button -->
        <button class="navbar-toggler" type="button" data-mdb-toggle="collapse"
            data-mdb-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>
        <!-- Collapsible wrapper -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Navbar brand -->
            <a class="navbar-brand mt-2 mt-lg-0" href="{{ route('index') }}">
                <img src="/assets/image/icon-logo.png" height="32" alt="MDB Logo" loading="lazy" />
            </a>
            <!-- Left links -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('index') }}">Trang chủ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Thông tin</a>
                </li>
                @if (Auth::check() && Auth::user()->is_admin == 1)
                <li class="nav-item">
                    <a class="nav-link text-danger fw-bold" href="{{ route('product-manager') }}">Quản lý sản phẩm</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-danger fw-bold" href="{{ route('producer-manager') }}">Quản lý hãng</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-danger fw-bold" href="{{ route('order-approve') }}">Duyệt đơn hàng</a>
                </li>
                @endif
            </ul>
            <!-- Left links -->
        </div>
        <!-- Collapsible wrapper -->
        <!-- Right elements -->
        <div class="d-flex align-items-center">
            @if (!Auth::check())
            <a href="{{ route('login') }}" type="button" class="btn btn-link px-3 me-2">
                Đăng nhập
            </a>
            <a href="{{ route('register') }}" type="button" class="btn btn-primary me-3">
                Đăng ký
            </a>
            @else
            <!-- Cart -->
            <a class="text-reset me-3" href="{{ route('cart') }}">
                <i class="fas fa-shopping-cart" style="font-size: 18px;"></i>

                <span class="badge rounded-pill badge-notification bg-danger" style="font-size: 0.7rem;">
                    {{ session()->get('cart') ? count(session()->get('cart')) : 0 }}
                </span>
            </a>
            <!-- Avatar -->
            <div style="position: relative;">
                <a type="button" class="dropdown-toggle d-flex align-items-center hidden-arrow" data-mdb-toggle="dropdown"
                    data-mdb-display="static" aria-expanded="false" id="dropdownUser">
                    <img src="/assets/image/user.png" class="rounded-circle" height="28" loading="lazy" />
                </a>
                <ul class="dropdown-menu" style="top: calc(100% + 6px); right: 0; left: auto;" aria-labelledby="dropdownUser">
                    <li>
                        <a class="dropdown-item" href="#">Thông tin tài khoản</a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('order-history') }}">Lịch sử mua hàng</a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('logout') }}">Đăng xuất</a>
                    </li>
                </ul>
            </div>
            @endif
        </div>
        <!-- Right elements -->
    </div>
    <!-- Container wrapper -->
</nav>
<!-- Navbar -->
