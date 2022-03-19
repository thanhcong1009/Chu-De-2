@extends('layouts.default')

@section('banner')
@include('includes.banner-slide')
@stop

@section('content')
<div class="container-lg mb-3" id="show-products">
    <!-- MENU HÃNG -->
    <div class="row">
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary bg-gradient text-white">
            <div class="container-fluid">
                <!-- Toggle button -->
                <button class="navbar-toggler" type="button" data-mdb-toggle="collapse"
                    data-mdb-target="#navbar-menu" aria-controls="navbar-menu" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                </button>

                <div class="collapse navbar-collapse" id="navbar-menu">
                    <ul class="navbar-nav">
                        <?php
                            $producerCurrent = request()->producer ? request()->producer : '';
                        ?>
                        <li class="nav-item">
                            <a class="nav-link {{ $producerCurrent == '' ? 'active' : '' }}" aria-current="page" href="{{ '?#show-products' }}">TẤT CẢ</a>
                        </li>
                        @foreach ($producers as $producer)
                        <li class="nav-item">
                            <a class="nav-link {{ $producerCurrent == $producer->code ? 'active' : '' }}" href='{{ "?producer=".$producer->code."#show-products" }}'' style="text-transform: uppercase;">{{ $producer->name }}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <form class="d-flex input-group w-auto" method="get">
                    @csrf
                    <input type="search" class="form-control rounded" placeholder="Tìm tên" aria-label="Tìm tên"
                        aria-describedby="search-addon" name="search" />
                </form>
            </div>
        </nav>
    </div>
    <!-- MENU HÃNG -->

    <!-- SHOW SẢN PHẨM -->
    <div class="row">
        @foreach ($products as $product)
        <div class="col-sm-12 col-md-6 col-lg-3 mt-4">
            <a href="{{ route('product-detail', $product->id) }}" class="card-product card text-center shadow-5" style="height: 100%;">
                <div class="bg-image hover-overlay ripple p-4" data-mdb-ripple-color="light">
                    <img src="/{{ $product->image }}" class="img-fluid" />
                    <div class="mask" style="background-color: rgba(251, 251, 251, 0.15)"></div>
                </div>

                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    @if($product->price_sale == 0)
                        <p class="gia-goc my-0 fw-bolder">{{ number_format($product->price, 0, ',', '.') }} đ</p>
                    @else
                        <p class="gia-goc sale my-0">{{ number_format($product->price, 0, ',', '.') }} đ</p>
                        <p class="gia-hien-tai my-0 fw-bolder">{{ number_format($product->price_sale, 0, ',', '.') }} đ</p>
                    @endif
                </div>
            </a>
        </div>
        @endforeach
    </div>
    <!-- SHOW SẢN PHẨM -->
</div>

<!-- PHÂN TRANG -->
<div class="d-flex justify-content-center mt-4">
    <nav aria-label="...">
        <ul class="pagination pagination-circle">
            <?php
                $search = request()->search ? request()->search : '';
                $page = $products->currentPage();
                $lastPage = $products->lastPage();

                if ($page == $lastPage) {
                    $pageStart = $lastPage - 2;
                    $pageEnd = $lastPage;
                } else if ($page == 1) {
                    $pageStart = 1;
                    $pageEnd = 3;
                } else {
                    $pageStart = $page - 1;
                    $pageEnd = $page + 1;
                }
                if ($pageEnd > $lastPage) {
                    $pageEnd = $lastPage;
                }
                if ($pageStart < 1) {
                    $pageStart = 1;
                }
            ?>
            <li class="page-item {{ $page == 1 ? 'disabled' : '' }}">
                <a class="page-link" href="{{ Request::url() . "?search=$search&page=1&producer=$producerCurrent#show-products" }}">Đầu</a>
            </li>
            @for ($i = $pageStart; $i <= $pageEnd; $i++)
                <li class="page-item {{ $page == $i ? 'active' : '' }}">
                    <a class="page-link" href="{{ Request::url() . "?search=$search&page=$i&producer=$producerCurrent#show-products" }}">{{ $i }}</a>
                </li>
            @endfor
            <li class="page-item {{ $lastPage == $page ? 'disabled' : '' }}">
                <a class="page-link" href="{{ Request::url() . "?search=$search&page=$lastPage&producer=$producerCurrent#show-products" }}">Cuối</a>
            </li>
        </ul>
    </nav>
</div>
@stop
