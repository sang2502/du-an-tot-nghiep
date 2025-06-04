<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductImage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $categories = Category::all();
        $query = Product::query();

        if ($request->filled('keyword')) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }
        $products = $query->orderBy('id', 'desc')->paginate(10);
        return view('admin.product.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $categories = Category::all();
        return view('admin.product.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        // upload image
        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/products/'), $imageName);
            $imagePath = 'uploads/products/' . $imageName;
        }
        // Thêm mới sản phẩm
        $product = Product::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'slug' => $request->slug,
            'price' => $request->price,
            'description' => $request->description,
            'status' => $request->status,
            'thumbnail' => $imagePath, // Lưu đường dẫn hình ảnh


        ]);
        // Thêm vào bảng product_images
        if ($imagePath) {
            ProductImage::create([
                'product_id' => $product->id,
                'url' => $imagePath, // Lưu đường dẫn hình ảnh
            ]);
        }
        return redirect()->route('product.index')->with('success', 'Thêm sản phẩm thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $product = Product::find($id);
        return view('admin.product.detail', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $product = Product::find($id);
        $categories = Category::all();
        return view('admin.product.update', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */

public function update(Request $request, string $id)
{
    $product = Product::findOrFail($id);
    $imagePath = $product->thumbnail; // Giữ nguyên đường dẫn hình ảnh cũ

    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $image->move(public_path('uploads/products/'), $imageName);
        $imagePath = 'uploads/products/' . $imageName; // Cập nhật đường dẫn hình ảnh mới

        // Thêm ảnh mới vào bảng product_images
        ProductImage::create([
            'product_id' => $product->id,
            'url' => $imagePath,
        ]);
    }

    $product->update([
        'name' => $request->name,
        'category_id' => $request->category_id,
        'slug' => $request->slug,
        'price' => $request->price,
        'description' => $request->description,
        'status' => $request->status,
        'thumbnail' => $imagePath, // Cập nhật đường dẫn hình ảnh
    ]);

    return redirect()->route('product.index')->with('success', 'Cập nhật sản phẩm thành công');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $product = Product::find($id);
        if ($product) {
            // Xóa hình ảnh nếu có

            // Xóa ảnh đại diện
            if ($product->thumbnail && file_exists(public_path($product->thumbnail))) {
                unlink(public_path($product->thumbnail));
            }
            // Xóa ảnh phụ
            foreach ($product->images as $img) {
                if ($img->image && file_exists(public_path($img->image))) {
                    unlink(public_path($img->image));
                }
                $img->delete();
            }
            // Xóa sản phẩm
            $product->delete();
            return redirect()->route('product.index')->with('success', 'Xóa sản phẩm thành công');
        }
        return redirect()->route('product.index')->with('error', 'Sản phẩm không tồn tại');
    }
}
