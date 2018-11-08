<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Size;
use App\Color;

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
        $size->delete();
        return redirect('/admin/product-attribute/sizes');
    }

    public function removeColor($id) {
        $color = Color::findOrFail($id);
        $color->delete();
        return redirect('/admin/product-attribute/colors');
    }
    
}
