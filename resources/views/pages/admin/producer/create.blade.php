@extends('layouts.default')

@section('content')
<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col">
            <a href="{{ route('producer-manager') }}" class="btn btn-primary"><i class="fas fa-angle-left"></i> Quản lý hãng</a>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-4">
            <h3 class="text-center mb-4">Thêm hãng sản phẩm mới</h3>
            <form method="post">
                @csrf
                <div class="form-outline mb-4">
                    <input type="text" id="input-name" class="form-control" name="code"
                        value="{{ old('code') }}" />
                    <label class="form-label" for="input-name">Mã hãng</label>
                </div>
                <div class="form-outline mb-4">
                    <input type="text" id="input-name" class="form-control" name="name"
                        value="{{ old('name') }}" />
                    <label class="form-label" for="input-name">Tên hãng</label>
                </div>
                @if ($errors->any())
                    <div class="error-box mb-4">
                    @foreach ($errors->all() as $error)
                        <span class="msg-error">{{ $error }}</span>
                    @endforeach
                    </div>
                @elseif(session('success'))
                    <div class="msg-success mb-4">{{ session('success') }}</div>
                @endif

                <!-- Submit button -->
                <button type="submit" class="btn btn-primary btn-block">Thêm mới</button>
            </form>
        </div>
    </div>
</div>
@stop
