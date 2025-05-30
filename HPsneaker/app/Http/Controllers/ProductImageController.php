<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductImage; // Assuming you have a ProductImage model
use App\Models\Product; // Assuming you have a Product model

class ProductImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // Lấy danh sách sản phẩm với hình ảnh liên quan
        $products = Product::with('images')->paginate(10); // 10 sản phẩm mỗi trang
        return view('admin.product.image.image', compact('products'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        // $request->validate([
        //     'product_id' => 'required|exists:products,id',
        //     'images' => 'required',
        //     'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        // ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . uniqid() . '_' . $image->getClientOriginalName();
                $image->move(public_path('uploads/products/'), $imageName);
                $imagePath = 'uploads/products/' . $imageName;

                ProductImage::create([
                    'product_id' => $request->product_id,
                    'url' => $imagePath,
                ]);
            }
        }

        return redirect()->route('product.image.index')->with('success', 'Thêm ảnh thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $productImgDetail = Product::with('images')->findOrFail($id);
        return view('admin.product.image.detail', compact('productImgDetail'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $image = ProductImage::findOrFail($id);
        $imagePath = public_path($image->url);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
        $image->delete();
        return redirect()->back()->with('success', 'Xóa ảnh thành công');
    }
}
