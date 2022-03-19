<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $carts = Cart::where('user_id', auth()->user()->id)
                    ->join('products', 'products.id', '=', 'carts.product_id')
                    ->select('carts.*', 'products.name', 'products.price', 'products.price_sale', 'products.image')
                    ->get();
        return view('pages.cart', ['carts' => $carts]);
    }

    public function add(Request $request)
    {
        // Xử lý số lượng thêm vào giỏ hàng
        if ($request->amount && $request->amount <= 0) {
            return redirect()->back()->withErrors([
                'amount' => 'Số lượng phải lớn hơn 0',
            ]);
        }
        // Lấy thông tin sản phẩm
        $product = Product::find($request->product_id);
        if ($product) {
            $sCart = session()->get('cart');
            if (!$sCart) {
                $sCart = [];
            }
            // get cart db
            $cart = Cart::where('product_id', $request->product_id)->where('user_id', auth()->user()->id)->first();
            // Nếu đã có sản phẩm trong giỏ hàng thì + số lượng
            if ($cart) {
                $cart->amount += $request->amount;
                $cart->save();
            } else { // Chưa có sản phẩm trong giỏ hàng thì thêm mới
                $cart = new Cart([
                    'user_id' => auth()->user()->id,
                    'product_id' => $request->product_id,
                    'amount' => $request->amount,
                ]);
                $cart->save();
            }
            $sCart[$cart->product_id] = $cart;
            session()->put('cart', $sCart);
            return redirect()->back()->with('cartSuccess', 'Thêm vào giỏ hàng thành công');
        }
        return abort(404);
    }

    public function update(Request $request)
    {
        $cartsId = $request->cartId;
        $cartsAmount = $request->amount;

        for ($i = 0; $i < count($cartsId); $i++) {
            $cart = Cart::find($cartsId[$i]);
            if ($cart) {
                $cart->amount = $cartsAmount[$i];
                $cart->save();
            }
        }

        return redirect()->back()->with('success', 'Cập nhật giỏ hàng thành công');
    }

    public function remove(Request $request, $id)
    {
        $cart = Cart::find($id);
        if ($cart) {
            if ($cart->delete()) {
                // Xóa khỏi session
                $sCart = session()->get('cart');
                if ($sCart) {
                    unset($sCart[$cart->product_id]);
                    session()->put('cart', $sCart);
                }
            }
        }
        return redirect()->back()->with('success', 'Xóa sản phẩm khỏi giỏ hàng thành công');
    }
}
