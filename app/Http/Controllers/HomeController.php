<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Producer;
use App\Models\Review;
use App\Models\Order;
use App\Models\ProductOrder;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $currentPage = $request->page ? $request->page : 1;
        $perPage = $request->perPage ? $request->perPage : 8;

        $search = $request->search ? $request->search : '';
        $producerCode = $request->producer ? $request->producer : '';
        if ($producerCode != '') { // Nếu lọc hãng
            $products = Product::where('name', 'like', '%' . $search . '%')
                        ->where('producer_code', '=', $producerCode)
                        ->paginate($perPage, "*", "page", $currentPage);
        }
        else if ($request->search) { // Nếu tìm kiếm
            $products = Product::where('name', 'like', '%' . $search . '%')
                        ->paginate($perPage, "*", "page", $currentPage);
        } else {
            $products = Product::paginate($perPage, "*", "page", $currentPage);
        }

        $producers = Producer::all();
        // total: số lượng
        // lastPage: Trang cuối
        // perPage: Số lượng trên 1 trang
        // currentPage: Trang hiện tại
        return view('pages.index', ['products' => $products, 'producers' => $producers]);
    }

    public function details(Request $request, $id)
    {
        $currentPage = $request->page ? $request->page : 1;
        $perPage = $request->perPage ? $request->perPage : 4;

        $product = Product::find($id);
        // all review
        $reviewTotal = Review::where('product_id', '=', $id)->select('star')->get();
        $reviewTotalCount = count($reviewTotal);
        $starTotal = 0;
        foreach ($reviewTotal as $value) {
            $starTotal += $value->star;
        }

        $starTotal = $starTotal > 0 ? round($starTotal / $reviewTotalCount, 1) : 0;

        // review phân trang
        $reviews = Review::where('product_id', '=', $id)
                        ->join('users', 'users.id', '=', 'reviews.user_id')
                        ->select('reviews.*', 'users.name')
                        ->orderBy('created_at', 'desc')
                        ->paginate($perPage, "*", "page", $currentPage);

        return view('pages.detail', [
            'product' => $product,
            'reviews' => $reviews,
            'starTotal' => $starTotal,
            'reviewTotalCount' => $reviewTotalCount,
        ]);
    }

    public function postReview(Request $request)
    {
        $request->validate([
            'star' => 'required',
            'product_id' => 'required'
        ]);

        // Xử lý đã mua hàng mới được đánh giá
        $order = ProductOrder::where('product_id', '=', $request->product_id)
                            ->join('orders', 'orders.id', '=', 'product_orders.order_id')
                            ->select('orders.*')
                            ->where('status', '=', 2)
                            ->where('user_id', '=', auth()->user()->id)
                            ->first();
        if ($order) {
            // Check đã đánh giá chưa
            $review = Review::where('user_id', '=', auth()->user()->id)
                            ->where('product_id', '=', $request->product_id)
                            ->first();
            if ($review) {
                return redirect()->back()->withErrors([
                    'message' => 'Bạn đã đánh giá sản phẩm này rồi!'
                ]);
            } else {
                // Lưu đánh giá
                $review = new Review([
                    'user_id' => auth()->user()->id,
                    'product_id' => $request->product_id,
                    'star' => $request->star,
                    'content' => $request->content ? $request->content : ''
                ]);
                $review->save();
            }

            return redirect()->back()->with(['reviewSuccess' => 'Đánh giá thành công']);
        } else {
            return redirect()->back()->withErrors([
                'message' => 'Bạn chưa mua sản phẩm này!'
            ]);
        }
    }
}
