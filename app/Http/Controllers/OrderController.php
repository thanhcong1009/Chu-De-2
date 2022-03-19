<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\ProductOrder;

class OrderController extends Controller
{
    public function history(Request $request)
    {
        $orders = Order::where('user_id', $request->user()->id)->orderBy('created_at', 'desc')->get();

        foreach ($orders as $order) {
            $order->products = ProductOrder::where('order_id', $order->id)
            ->join('products', 'product_orders.product_id', '=', 'products.id')
            ->select('product_orders.*', 'products.name', 'products.image')
            ->get();
        }
        return view('pages.order', compact('orders'));
    }

    public function order(Request $request)
    {
        $carts = Cart::where('user_id', auth()->user()->id)
                    ->join('products', 'products.id', '=', 'carts.product_id')
                    ->select('carts.*', 'products.price', 'products.price_sale')
                    ->get();
        if (count($carts) == 0) {
            return redirect()->route('cart');
        }
        // Tạo order
        $order = new Order([
            'user_id' => auth()->user()->id,
            'status' => 1,
        ]);
        $order->save();

        // Tạo chi tiết order
        foreach ($carts as $cart) {
            $productOrder = new ProductOrder([
                'product_id' => $cart->product_id,
                'order_id' => $order->id,
                'price' => $cart->price_sale ? $cart->price_sale : $cart->price,
                'amount' => $cart->amount,
            ]);
            $productOrder->save();
        }

        // Xóa giỏ hàng
        Cart::where('user_id', auth()->user()->id)->delete();
        // Xóa giỏ hàng session
        session()->put('cart', []);


        return redirect()->back();
    }

    public function approve(Request $request)
    {
        $orders = Order::where('status', 1)->get();

        foreach ($orders as $order) {
            $order->products = ProductOrder::where('order_id', $order->id)
            ->join('products', 'product_orders.product_id', '=', 'products.id')
            ->select('product_orders.*', 'products.name', 'products.image')
            ->get();
        }
        return view('pages.admin.order', compact('orders'));
    }

    public function accept(Request $request, $id)
    {
        $order = Order::find($id);
        if ($order && $order->status == 1) {
            $order->status = 2;
            $order->save();
            return redirect()->back();
        }
        return abort(404);
    }
}
