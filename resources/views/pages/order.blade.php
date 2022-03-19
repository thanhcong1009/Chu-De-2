@extends('layouts.default')

@section('content')
<div class="container my-5">
    <h3>
        <i class="fas fa-shopping-cart"></i>
        <span class="ms-2">Lịch sử mua hàng</span>
    </h3>
    @if(count($orders) > 0)
    @foreach ($orders as $order)
    <div class="shadow-3-strong mt-4">
        <div class="d-flex p-4 head-order-history" style="cursor: pointer;">
            <span class="fw-bold">Đơn hàng {{ count($order->products) }} sản phẩm</span>
            <div class="ms-auto">
                <span class="fw-bold">{{ date_format(date_create($order->created_at), 'H:i d/m/Y') }}</span>
                @if($order->status == 1)
                <span class="fw-bold text-danger">(Đang giao hàng)</span>
                @elseif($order->status == 2)
                <span class="fw-bold text-success">(Đã nhận hàng)</span>
                @endif
            </div>
        </div>
        <div class="body-order-history">
            @foreach ($order->products as $product)
            <div class="row py-3 px-4">
                <div class="col-1 p-2">
                    <img src="/{{ $product->image }}" class="img-fluid">
                </div>
                <div class="col-11 row align-items-center">
                    <a href="{{ route('product-detail', $product->product_id) }}" class="col-6">{{ $product->name }}</a>
                    <span class="text-danger col-4">
                        {{ number_format($product->price, 0, ',', '.') }} đ
                    </span>
                    <div class="col-2 d-flex justify-content-center">
                        <span>Số lượng: {{ $product->amount }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endforeach
    @else
    <div class="container p-4 text-center">
        <div class="fw-bold fs-5">Bạn chưa đặt đơn hàng nào</div>
        <a href="./" class="btn btn-success mt-3">
            <span class="me-1">Mua hàng ngay</span>
            <i class="fas fa-cart-plus"></i>
        </a>
    </div>
    @endif

</div>

<script>
    window.addEventListener('DOMContentLoaded', (event) => {
        document.querySelectorAll('.head-order-history').forEach(item => {
            item.addEventListener('click', (event) => {
                // Thu nhỏ toàn bộ body khác
                document.querySelectorAll('.head-order-history').forEach(item2 => {
                    if (item != item2) {
                        item2.nextElementSibling.style.maxHeight = null;
                    }
                });

                let body = item.nextElementSibling;
                if (body.style.maxHeight) {
                    // Nếu đang mở thì thu nhỏ lại
                    body.style.maxHeight = null;
                } else {
                    // Nếu đang thu nhỏ thì mở lại
                    body.style.maxHeight = body.scrollHeight + "px";
                }
            });
        });
    });
</script>
@stop
