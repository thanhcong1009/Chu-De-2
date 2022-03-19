<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cart;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'password' => 'required|min:6|max:20|confirmed',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|numeric|digits_between:10,11',
        ]);

        $user = new User([
            'name' => $request->name,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'address' => $request->address,
            'phone_number' => $request->phone_number,
        ]);

        $user->save();
        return redirect()->route('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('username', 'password');

        if (auth()->attempt($credentials)) {
            // Đăng nhập thành công rồi lấy thông tin giỏ hàng
            $carts = Cart::where('user_id', auth()->user()->id)->get();
            // Lưu giỏ hàng vào session
            $sCart = [];
            foreach ($carts as $cart) {
                $sCart[$cart->product_id] = $cart;
            }
            session()->put('cart', $sCart);
            return redirect()->route('index');
        }

        return redirect()->back()
                        ->withInput($request->only('username'))
                        ->withErrors(['msg' => 'Tên đăng nhập hoặc mật khẩu không đúng']);
    }

    public function logout()
    {
        auth()->logout();

        return redirect()->route('login');
    }
}
