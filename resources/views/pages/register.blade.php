@extends('layouts.default')

@section('content')
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-4">
            <h3 class="text-center mb-4">Đăng ký</h3>
            <form method="post">
                @csrf
                <div class="form-outline mb-4">
                    <input type="text" id="input-fullname" class="form-control" name="name" value="{{ old('name') }}"/>
                    <label class="form-label" for="input-fullname">Họ và tên</label>
                </div>
                <div class="form-outline mb-4">
                    <input type="text" id="input-phonenumber" class="form-control" name="phone_number" value="{{ old('phone_number') }}"/>
                    <label class="form-label" for="input-phonenumber">Số điện thoại</label>
                </div>
                <div class="form-outline mb-4">
                    <input type="text" id="input-address" class="form-control" name="address" value="{{ old('address') }}"/>
                    <label class="form-label" for="input-address">Địa chỉ</label>
                </div>
                <hr>

                <div class="form-outline mb-4">
                    <input type="text" id="input-username" class="form-control" name="username" value="{{ old('username') }}"/>
                    <label class="form-label" for="input-username">Tên đăng nhập</label>
                </div>
                <!-- Password input -->
                <div class="form-outline mb-4">
                    <input type="password" id="input-password" class="form-control" name="password"/>
                    <label class="form-label" for="input-password">Mật khẩu</label>
                </div>
                <div class="form-outline mb-4">
                    <input type="password" id="password_confirmation" class="form-control" name="password_confirmation"/>
                    <label class="form-label" for="password_confirmation">Nhập lại mật khẩu</label>
                </div>
                @if ($errors->any())
                    <div class="error-box mb-4">
                    @foreach ($errors->all() as $error)
                        <span class="msg-error">{{ $error }}</span>
                    @endforeach
                    </div>
                @endif
                <!-- Submit button -->
                <button type="submit" class="btn btn-primary btn-block">Đăng ký</button>
            </form>
        </div>
    </div>
</div>
@stop
