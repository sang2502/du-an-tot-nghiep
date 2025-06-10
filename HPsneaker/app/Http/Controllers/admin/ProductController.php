<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\Color;
use App\Models\Size;
use Illuminate\Support\Facades\Log;

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
        $categories = Category::all();
        $sizes = Size::all();
        $colors = Color::all();
        return view('admin.product.create', compact('categories', 'sizes', 'colors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
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
                'thumbnail' => $imagePath,
            ]);
            // Thêm vào bảng product_images
            if ($imagePath) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'url' => $imagePath,
                ]);
            }
            // Thêm biến thể sản phẩm
            if ($request->has('variants')) {
                Log::info($request->variants);
                foreach ($request->variants as $variant) {
                    // Bỏ qua dòng trống
                    if (empty($variant['size_id']) || empty($variant['color_id'])) continue;
                    ProductVariant::create([
                        'product_id' => $product->id,
                        'size_id' => $variant['size_id'],
                        'color_id' => $variant['color_id'],
                        'price' => $variant['price'],
                        'stock' => $variant['stock'],
                        'sku' => 'SP' . $product->id . $variant['size_id'] . $variant['color_id'],
                    ]);
                }
            }
            DB::commit();
            return redirect()->route('product.index')->with('success', 'Thêm sản phẩm thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::findOrFail($id);
        $variant = ProductVariant::findOrFail($id);
        return view('admin.product.detail', compact('product', 'variant'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::find($id);
        $categories = Category::all();
        $sizes = Size::all();
        $colors = Color::all();
        return view('admin.product.update', compact('product', 'categories', 'sizes', 'colors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);
        $imagePath = $product->thumbnail;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/products/'), $imageName);
            $imagePath = 'uploads/products/' . $imageName;
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
            'thumbnail' => $imagePath,
        ]);

        // Cập nhật biến thể (nếu cần, bạn có thể xóa hết rồi thêm lại hoặc cập nhật từng cái)
        // Ví dụ: Xóa hết và thêm lại
        if ($request->has('variants')) {
            ProductVariant::where('product_id', $product->id)->delete();
            foreach ($request->variants as $variant) {
                if (empty($variant['size_id']) || empty($variant['color_id'])) continue;
                ProductVariant::create([
                    'product_id' => $product->id,
                    'size_id' => $variant['size_id'],
                    'color_id' => $variant['color_id'],
                    'price' => $variant['price'],
                    'stock' => $variant['stock'],
                ]);
            }
        }

        return redirect()->route('product.index')->with('success', 'Cập nhật sản phẩm thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);
        if ($product) {
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
            // Xóa biến thể
            ProductVariant::where('product_id', $product->id)->delete();
            // Xóa sản phẩm
            $product->delete();
            return redirect()->route('product.index')->with('success', 'Xóa sản phẩm thành công');
        }
        return redirect()->route('product.index')->with('error', 'Sản phẩm không tồn tại');
    }
}