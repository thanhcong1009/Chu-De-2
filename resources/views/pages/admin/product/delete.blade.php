@extends('layouts.default')

@section('content')
<div class="container my-5">
    @if(session('error'))
    <div class="row text-center">
        <h1 class="text-danger">{{ session('error') }}</h1>
    </div>
    <div class="d-flex justify-content-center">
        <a href="{{ route('product-manager') }}" class="btn btn-primary">
            <i class="fas fa-angle-left"></i>
            Quay lại
        </a>
    </div>
    @else
    <div class="row text-center">
        <h1>Bạn có muốn xóa sản phẩm <span class="text-danger">{{ $product->name }}</span>?</h1>
    </div>
    <div class="mt-3 mb-5 d-flex justify-content-center">
        <img src="/{{ $product->image }}" alt="" class="w-25" id="previewImg">
    </div>
    <div class="d-flex justify-content-center">
        <span class="me-3">
            <a href="{{ route('product-manager') }}" class="btn btn-primary">
                <i class="fas fa-angle-left"></i>
                Quay lại
            </a>
        </span>
        <form method="post">
            @csrf
            <button type="submit" class="btn btn-danger">
                <i class="fas fa-trash-alt"></i>
                Xóa
            </button>
        </form>
    </div>
    @endif
</div>
@stop
