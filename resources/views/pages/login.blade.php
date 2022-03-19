@extends('layouts.default')

@section('content')
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-4">
            <h3 class="text-center mb-4">Đăng nhập</h3>
            <form method="post">
                @csrf
                <div class="form-outline mb-4">
                    <input type="text" id="form1Example1" name="username" class="form-control" value="<?php echo empty($_POST["username"]) ? '' : $_POST["username"] ?>" />
                    <label class="form-label" for="form1Example1">Tên đăng nhập</label>
                </div>
                <div class="form-outline mb-3">
                    <input type="password" id="form1Example2" name="password" class="form-control" />
                    <label class="form-label" for="form1Example2">Mật khẩu</label>
                </div>
                @if ($errors->any())
                <div class="msg-error mb-3">{{ $errors->first() }}</div>
                @endif
                <!-- Submit button -->
                <button type="submit" class="btn btn-primary btn-block">Đăng nhập</button>
            </form>
        </div>
    </div>
</div>
@stop
