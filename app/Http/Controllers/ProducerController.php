<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producer;

class ProducerController extends Controller
{
    public function show(Request $request)
    {
        $currentPage = $request->page ? $request->page : 1;
        $perPage = $request->perPage ? $request->perPage : 10;
        // Nếu tìm kiếm
        if ($request->search) {
            $producers = Producer::where('name', 'like', '%' . $request->search . '%')->paginate($perPage, "*", "page", $currentPage);
        } else {
            $producers = Producer::paginate($perPage, "*", "page", $currentPage);
        }
        // total: số lượng
        // lastPage: Trang cuối
        // perPage: Số lượng trên 1 trang
        // curentPage: Trang hiện tại
        return view('pages.admin.producer.index', ['producers' => $producers]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'code' => 'required|max:10',
            'name' => 'required|max:255',
        ]);

        $check = Producer::where('code', $request->code)->first();
        if ($check) {
            return redirect()->back()->withErrors(['msg' => 'Mã hãng sản phẩm đã tồn tại']);
        }

        $producer = new Producer([
            'code' => $request->code,
            'name' => $request->name,
        ]);
        if ($producer->save()) {
            return redirect()->back()->with('success', 'Thêm hãng sản phẩm thành công');
        } else {
            return redirect()->back()->withErrors(['msg' => 'Thêm hãng sản phẩm thất bại']);
        }
    }

    public function getById(Request $request, $id)
    {
        $producer = Producer::find($id);
        if ($producer){
            return view('pages.admin.producer.edit', ['producer' => $producer]);
        } else {
            return abort(404);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'code' => 'required|max:10',
            'name' => 'required|max:255',
        ]);

        $producer = Producer::find($id);
        if ($producer) {
            $producer->code = $request->code;
            $producer->name = $request->name;
            $producer->save();
            return redirect()->back()->with('success', 'Cập nhật hãng sản phẩm thành công');
        } else {
            return abort(500);
        }
    }

    public function deleteView(Request $request, $id)
    {
        $producer = Producer::find($id);
        if ($producer) {
            return view('pages.admin.producer.delete', ['producer' => $producer]);
        } else {
            return abort(404);
        }
    }

    public function delete(Request $request)
    {
        $producer = Producer::find($request->id);
        if ($producer) {
            try {
                $producer->delete();
                return redirect()->route('producer-manager');
            } catch (\Illuminate\Database\QueryException $e) {
                return redirect()->back()->with([
                    'error' => 'Không thể xóa hãng này vì có sản phẩm thuộc hãng này'
                ]);
            }
        } else {
            return abort(404);
        }
    }
}
