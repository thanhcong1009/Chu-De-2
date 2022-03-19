<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProducerController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

// Đăng nhập
Route::prefix('/dang-nhap')->group(function () {
    // Trang đăng nhập
    Route::get('', function () {
        return Auth::check() ? redirect()->route('index') : view('pages.login');
    })->name('login');
    // Xác nhận thông tin đăng nhập
    Route::post('', [UserController::class, 'login']);
});
// Đăng ký tài khoản
Route::prefix('/dang-ky')->group(function () {
    // Trang đăng ký tài khoản
    Route::get('', function () {
        return Auth::check() ? redirect()->route('index') : view('pages.register');
    })->name('register');
    // Xác nhận đăng ký tài khoản
    Route::post('', [UserController::class, 'register']);
});
// Đăng xuất
Route::prefix('/dang-xuat')->group(function () {
    Route::get('', [UserController::class, 'logout'])->name('logout');
});

Route::prefix('/product-manager')->group(function () {
    // Xem tất cả sản phẩm
    Route::get('', [ProductController::class, 'show'])
        ->middleware('auth.admin')
        ->name('product-manager');

    // Trang Thêm sản phẩm mới
    Route::get('/create', [ProductController::class, 'createView'])
        ->middleware('auth.admin')
        ->name('product-manager-create');

    // Xác nhận tạo sản phẩm
    Route::post('/create', [ProductController::class, 'create'])
        ->middleware('auth.admin');

    // Trang xem chi tiết sản phẩm để sửa
    Route::get('/{id}', [ProductController::class, 'getById'])
        ->middleware('auth.admin')
        ->name('product-manager-show');

    // Xác nhận cập nhật sản phẩm
    Route::post('/{id}', [ProductController::class, 'update'])
        ->middleware('auth.admin')
        ->name('product-manager-update');

    // Trang xác nhận xóa sản phẩm
    Route::get('/{id}/delete', [ProductController::class, 'deleteView'])
        ->middleware('auth.admin')
        ->name('product-manager-delete');
    // Xác nhận yêu cầu xóa sản phẩm
    Route::post('/{id}/delete', [ProductController::class, 'delete'])
        ->middleware('auth.admin');
});

Route::prefix('/producer-manager')->group(function () {
    // Xem tất cả hãng
    Route::get('', [ProducerController::class, 'show'])
        ->middleware('auth.admin')
        ->name('producer-manager');

    // Trang thêm hãng sản phẩm mới
    Route::get('/create', function () {
        return view('pages.admin.producer.create');
    })->middleware('auth.admin')->name('producer-manager-create');

    // Xác nhận tạo hãng
    Route::post('/create', [ProducerController::class, 'create']);

    // Hiện thông tin hãng chỉnh sửa cập nhật
    Route::get('/{id}', [ProducerController::class, 'getById'])
        ->middleware('auth.admin')
        ->name('producer-manager-show');

    // Xác nhận cập nhật hãng
    Route::post('/{id}', [ProducerController::class, 'update'])
        ->middleware('auth.admin')
        ->name('producer-manager-update');

    // Trang xác nhận xóa hãng
    Route::get('/{id}/delete', [ProducerController::class, 'deleteView'])
        ->middleware('auth.admin')
        ->name('producer-manager-delete');
    // Xác nhận yêu cầu xóa hãng
    Route::post('/{id}/delete', [ProducerController::class, 'delete'])
        ->middleware('auth.admin');
});

Route::prefix('/cart')->group(function () {
    // Xem sản phẩm có trong giỏ hàng
    Route::get('', [CartController::class, 'index'])->name('cart');

    // Thêm sản phẩm vào giỏ hàng
    Route::post('', [CartController::class, 'add'])->name('cart-add');

    // Cập nhật sản phẩm trong giỏ hàng
    Route::post('/update', [CartController::class, 'update'])->name('cart-update');

    // Xóa sản phẩm trong giỏ hàng
    Route::get('/{id}/remove', [CartController::class, 'remove'])->name('cart-remove');
});

Route::prefix('/order')->group(function () {
    // Xác nhận đặt hàng
    Route::get('', [OrderController::class, 'order'])->name('order');

    // Trang lịch sử mua hàng
    Route::get('/history', [OrderController::class, 'history'])->name('order-history');

    // Trang duyệt đơn hàng
    Route::get('/approve', [OrderController::class, 'approve'])
        ->middleware('auth.admin')
        ->name('order-approve');

    // Xác nhận đã giao đơn hàng
    Route::post('/{id}', [OrderController::class, 'accept'])
        ->middleware('auth.admin')
        ->name('order-accept');
});

// Đăng đánh giá
Route::post('/review', [HomeController::class, 'postReview'])->name('review');

// Trang chi tiết sản phẩm
Route::get('/product/{id}', [HomeController::class, 'details'])->name('product-detail');

Route::get('/', [HomeController::class, 'index'])->name('index');
