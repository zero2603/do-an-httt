<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Size;
use App\Color;
use App\Stock;

class AttributeController extends Controller
{
    public function listSizes() {
        $sizes = Size::all();
        return view('admin.attributes.size', ['sizes' => $sizes]);
    }

    public function listColors() {
        $colors = Color::all();
        return view('admin.attributes.color', ['colors' => $colors]);
    }

    public function addSize(Request $request) {
        $data = $request->all();
        Size::create($data);
        return redirect('/admin/product-attribute/sizes');
    }

    public function addColor(Request $request) {
        $data = $request->all();
        Color::create($data);
        return redirect('/admin/product-attribute/colors');
    }

    public function removeSize($id) {
        $size = Size::findOrFail($id);
        $temp = Stock::where('size_id', $id)->get();
        
        if(count($temp)) {
            return redirect()->back()->with(['alert' => 'Không thể xóa size do đang có sản phẩm sử dụng size này']);
        }

        $size->delete();
        return redirect('/admin/product-attribute/sizes');
    }

    public function removeColor($id) {
        $color = Color::findOrFail($id);

        $temp = Stock::where('color_id', $id)->get();
        if(count($temp)) {
            return redirect()->back()->with(['alert' => 'Không thể xóa màu sắc do đang có sản phẩm sử dụng màu sắc này']);
        }

        $color->delete();
        return redirect('/admin/product-attribute/colors');
    }
    
}
