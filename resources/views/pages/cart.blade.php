@extends('layouts.default')

@section('content')
<div class="container my-5">
    <h3>
        <i class="fas fa-shopping-cart"></i>
        <span class="ms-2">Giỏ hàng</span>
    </h3>
    @if (count($carts) > 0)
    <form class="shadow-3-strong mt-4" method="post" action="{{ route('cart-update') }}">
        @csrf
        <?php
        $priceTotal = 0;
        foreach ($carts as $cart) {  ?>
        <input type="hidden" name="cartId[]" value="{{ $cart->id }}">
        <div class="row p-4">
            <div class="col-1 p-2">
                <img src="{{ $cart->image }}" alt="{{ $cart->name }}" class="img-fluid">
            </div>
            <div class="col-11 row align-items-center">
                <a href="{{ route('product-detail', $cart->product_id) }}" class="col-6">{{ $cart->name }}</a>
                <span class="text-danger col-3">
                    <?php
                    if ($cart->price_sale == 0) {
                        echo number_format($cart->price * $cart->amount, 0, ',', '.');
                        $priceTotal += $cart->price * $cart->amount;
                    } else {
                        echo number_format($cart->price_sale * $cart->amount, 0, ',', '.');
                        $priceTotal += $cart->price_sale * $cart->amount;
                    }
                    ?> đ
                </span>
                <div class="col-2 d-flex justify-content-center">
                    <div class="form-outline" style="width: 100px;">
                        <input name="amount[]" type="number" id="typeNumber" class="form-control" min="1" value="{{ $cart->amount }}"/>
                        <label class="form-label" for="typeNumber">Số lượng</label>
                    </div>
                </div>
                <div class="col text-center">
                    <a type="button" class="btn btn-danger btn-sm px-3" href="{{ route('cart-remove', $cart->id) }}">
                        <i class="fas fa-trash"></i>
                    </a>
                </div>
            </div>
        </div>
        <?php } ?>
        <div class="row px-5">
            <div class="col-6 offset-6 text-end">
                <button class="btn btn-primary" type="submit">Cập nhật giỏ hàng</button>
            </div>
        </div>
        <div class="row px-5 pt-3 pb-4">
            <div class="col-6 d-flex align-items-center">
                <span class="msg-success ms-4">
                    <?php if (session('success')) echo session('success') ?>
                </span>
            </div>
            <div class="col-6 text-end">
                <span class="fw-bold fs-5">Tổng tiền: </span>
                <span class="text-primary fw-bold fs-5">
                    {{ number_format($priceTotal, 0, ',', '.') }} đ
                </span>
                <a href="{{ route('order') }}" class="btn btn-success ms-3">Đặt hàng</a>
            </div>
        </div>
    </form>
    @else
    <div class="container p-4 text-center">
        <div class="fw-bold fs-5">Giỏ hàng của bạn đang trống</div>
        <a href="{{ route('index') }}" class="btn btn-success mt-3">
            <span class="me-1">Thêm sản phẩm vào giỏ hàng</span>
            <i class="fas fa-cart-plus"></i>
        </a>
    </div>
    @endif
</div>
@stop
