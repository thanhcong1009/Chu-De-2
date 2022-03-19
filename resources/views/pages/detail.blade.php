@extends('layouts.default')

@section('content')
<div class="container dark-grey-text my-5">

    <!--Chi tiết sản phẩm-->
    <div class="row wow fadeIn" style="visibility: visible; animation-name: fadeIn;">
        <div class="col-md-6 mb-4 d-flex justify-content-center">
            <img src="/{{ $product->image }}" alt="" class="w-75">
        </div>

        <div class="col-md-6 mb-4">

            <!--Content-->
            <div class="p-4">

                <h4><strong>{{ $product->name }}</strong></h4>

                <p class="lead">
                @if($product->price_sale == 0)
                    <span class="gia-goc my-0 fw-bolder">{{ number_format($product->price, 0, ',', '.') }} đ</span>
                @else
                    <span class="gia-goc sale my-0">{{ number_format($product->price, 0, ',', '.') }} đ</span>
                    <span class="gia-hien-tai my-0 fw-bolder">{{ number_format($product->price_sale, 0, ',', '.') }} đ</span>
                @endif
                </p>

                <p class="lead font-weight-bold">Mô tả</p>

                <p style="white-space: pre-wrap;">{{ $product->description }}</p>

                <form class="d-flex justify-content-left" method="post" action="{{ route('cart-add') }}">
                    @csrf
                    <input type="hidden" value="{{ $product->id }}" name="product_id">
                    <div class="form-outline me-2">
                        <input name="amount" type="number" id="typeNumber" class="form-control" value="1" min="1" style="width: 100px" />
                        <label class="form-label" for="typeNumber">Số lượng</label>
                    </div>
                    @if(Auth::check())
                    <button class="btn btn-primary btn-md my-0 p waves-effect waves-light" type="submit">
                        Thêm vào giỏ hàng<i class="fas fa-shopping-cart ms-1"></i>
                    </button>
                    @else
                    <a href="{{ route('login') }}" class="btn btn-primary btn-md my-0 p waves-effect waves-light">
                        Thêm vào giỏ hàng<i class="fas fa-shopping-cart ms-1"></i>
                    </a>
                    @endif
                </form>
                @if($errors->get('amount'))
                <div class="msg-error mt-3">{{ $errors->first('amount') }}</div>
                @elseif(session('cartSuccess'))
                <div class="msg-success mt-3">{{ session('cartSuccess') }}</div>
                @endif
            </div>
            <!--Content-->
        </div>
    </div>
    <!--Chi tiết sản phẩm-->

    <hr>

    <!--Thông tin chi tiết-->
    <div class="row d-flex justify-content-center wow fadeIn" style="visibility: visible; animation-name: fadeIn;">
        <div class="col-md-6 text-center">
            <h4 class="my-4 h4">Thông tin chi tiết</h4>
            <p class="text-left"></p>
        </div>
    </div>
    <!--Thông tin chi tiết-->

    <hr>

    <!--Số sao review tổng-->
    <div class="row d-flex justify-content-center wow fadeIn" style="visibility: visible; animation-name: fadeIn;">
        <div class="col-md-6 text-center">

            <h4 class="my-2 h4">Review</h4>

            <div class="review-rate">
                <div class="review-star">
                    <div class="review-star-default d-flex align-items-center">
                        <i class="far fa-star"></i>
                        <i class="far fa-star"></i>
                        <i class="far fa-star"></i>
                        <i class="far fa-star"></i>
                        <i class="far fa-star"></i>
                    </div>
                    <div class="review-star-rate" style="--width-star: {{ ($starTotal/5)*100 }}%;">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>
                <span class="review-star-total ms-2" style="line-height: 0px;">
                    {{ $starTotal }}/5
                    <span class="ms-2">({{ $reviewTotalCount }} đánh giá)</span>
                </span>
            </div>
        </div>
    </div>
    <!--Số sao review tổng-->

    <!--Bình luận review-->
    <div class="row d-flex justify-content-center wow fadeIn mt-4" style="visibility: visible; animation-name: fadeIn;">
        <!--CÁC ĐÁNH GIÁ TỪ NGƯỜI ĐÃ MUA HÀNG-->
        @foreach ($reviews as $review)
            <div class="col-lg-8 col-sm-10 list-comments shadow-2-strong p-4 my-2">
                <div class="star-review mb-1" style="user-select: none;">
                    <?php
                        $star = $review['star'];
                        for ($i=0; $i < 5; $i++) {
                            if ($star >= 1) {
                                echo '<i class="fas fa-star"></i>';
                            } else if ($star == 0.5) {
                                echo '<i class="fas fa-star-half-alt"></i>';
                            } else {
                                echo '<i class="far fa-star"></i>';
                            }
                            $star--;
                        }
                    ?>
                </div>
                <div class="content-box mt-2">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="fw-normal d-flex align-items-center">
                            <span class="name me-2">{{ $review->name }}</span>
                            <span class="badge rounded-pill bg-success">Đã mua hàng</span>
                        </div>
                        <div class="time-review fst-italic" style="font-size: 14px;">{{ date_format(date_create($review['created_at']), 'd/m/Y') }}</div>
                    </div>
                    <div class="content-review fw-light" style="text-align: justify;">
                        <span style="white-space: pre-wrap;">{{ $review->content }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        <!--CÁC ĐÁNH GIÁ TỪ NGƯỜI ĐÃ MUA HÀNG-->

        <!--PHÂN TRANG CÁC ĐÁNH GIÁ-->
        <div class="col-lg-8 col-sm-10 d-flex justify-content-center mt-3">
            <nav aria-label="...">
                <ul class="pagination pagination-circle">
                    <?php
                        $page = $reviews->currentPage();
                        $lastPage = $reviews->lastPage();

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
                    <li class="page-item {{ $page == 1 ? 'disabled' : ''}}">
                        <a class="page-link" href="{{ Request::url() }}">Đầu</a>
                    </li>
                    @for ($i = $pageStart; $i <= $pageEnd; $i++)
                        <li class="page-item {{ $page == $i ? 'active' : ''}}">
                            <a class="page-link" href="{{ Request::url() }}?page={{ $i }}">{{ $i }}</a>
                        </li>
                    @endfor
                    <li class="page-item {{ $page >= $lastPage ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ Request::url() . "?page=$lastPage" }}">Cuối</a>
                    </li>
                </ul>
            </nav>
        </div>
        <!--PHÂN TRANG CÁC ĐÁNH GIÁ-->

        <!-- VIẾT ĐÁNH GIÁ -->
        @if(Auth::check())
        <form class="col-lg-8 col-sm-10 comment p-3 shadow-3-strong" method="post" action="{{ route('review') }}">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <div class="form-outline">
                <textarea class="form-control" id="txt-comment" rows="4" name="content" style="resize: none;"></textarea>
                <label class="form-label" for="txt-comment">Viết đánh giá</label>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="review-star-vote">
                    <input type="radio" name="star" value="5">
                    <input type="radio" name="star" value="4.5">
                    <input type="radio" name="star" value="4">
                    <input type="radio" name="star" value="3.5">
                    <input type="radio" name="star" value="3">
                    <input type="radio" name="star" value="2.5">
                    <input type="radio" name="star" value="2">
                    <input type="radio" name="star" value="1.5">
                    <input type="radio" name="star" value="1">
                    <input type="radio" name="star" value="0">
                </div>
                <button class="btn btn-success" type="submit" name="review">Đánh giá</button>
            </div>
            @if ($errors->any())
                <div class="error-box ms-1 mt-2">
                @foreach ($errors->all() as $error)
                    <span class="msg-error">{{ $error }}</span>
                @endforeach
                </div>
            @elseif(session('reviewSuccess'))
                <div class="msg-success mt-2 ms-1">{{ session('reviewSuccess') }}</div>
            @endif
        </form>
        @endif
        <!--Grid column-->
    </div>
    <!--Grid row-->
</div>
@stop
