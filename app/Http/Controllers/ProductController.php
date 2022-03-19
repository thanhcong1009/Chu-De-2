<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Producer;
use Illuminate\Support\Facades\Storage;
use File;

class ProductController extends Controller
{
    public function show(Request $request)
    {
        $currentPage = $request->page ? $request->page : 1;
        $perPage = $request->perPage ? $request->perPage : 2;
        // Nếu tìm kiếm
        if ($request->search) {
            $products = Product::where('name', 'like', '%' . $request->search . '%')->paginate($perPage, "*", "page", $currentPage);
        } else {
            $products = Product::paginate($perPage, "*", "page", $currentPage);
        }
        // total: số lượng
        // lastPage: Trang cuối
        // perPage: Số lượng trên 1 trang
        // currentPage: Trang hiện tại
        return view('pages.admin.product.index', ['products' => $products]);
    }

    public function createView(Request $request)
    {
        // Lấy danh sách hãng sản phẩm
        $producers = Producer::all();
        return view('pages.admin.product.create', ['producers' => $producers]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric',
            'producer_code' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Xử lý file ảnh
        $image = $request->file('image');
        $imageName = uniqid('', true) . '.' . $image->getClientOriginalExtension();
        $path = $image->move('upload/images', $imageName);

        $product = new Product([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'price_sale' => $request->price_sale ? $request->price_sale : 0,
            'image' => $path,
            'producer_code' => $request->producer_code,
        ]);

        if ($product->save()) {
            return redirect()->route('product-manager-create')->with('success', 'Thêm sản phẩm thành công');
        } else {
            return redirect()->route('product-manager-create')->withErrors([
                'error' => 'Thêm sản phẩm thất bại'
            ]);
        }
    }

    public function getById(Request $request, $id)
    {
        $product = Product::find($id);
        if ($product) {
            $producers = Producer::all();
            return view('pages.admin.product.edit', ['product' => $product, 'producers' => $producers]);
        } else {
            return abort(404);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric',
            'producer_code' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $product = Product::find($id);

        if ($request->hasFile('image')) {
            // upload ảnh mới
            $image = $request->file('image');
            $imageName = uniqid('', true) . '.' . $image->getClientOriginalExtension();
            $path = $image->move('upload/images', $imageName);
            // Xóa ảnh cũ
            File::delete(public_path($product->image));
        } else {
            $path = $product->image;
        }

        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->price_sale = $request->price_sale ? $request->price_sale : $product->price_sale;
        $product->image = $path;
        $product->producer_code = $request->producer_code;

        if ($product->save()) {
            return redirect()->back()->with('success', 'Cập nhật sản phẩm thành công');
        } else {
            return redirect()->back()->withErrors([
                'error' => 'Cập nhật sản phẩm thất bại'
            ]);
        }
    }

    public function deleteView(Request $request, $id)
    {
        $product = Product::find($id);
        if ($product) {
            return view('pages.admin.product.delete', ['product' => $product]);
        } else {
            return abort(404);
        }
    }

    public function delete(Request $request)
    {
        $product = Product::find($request->id);
        if ($product) {
            try {
                $product->delete();
                // Xóa ảnh cũ
                File::delete(public_path($product->image));
                return redirect()->route('product-manager');
            } catch (\Illuminate\Database\QueryException $e) {
                return redirect()->back()->with([
                    'error' => 'Không thể xóa sản phẩm này vì đã có đơn hàng đặt mua sản phẩm này'
                ]);
            }
            return redirect('/');
        } else {
            return abort(404);
        }
    }
}
