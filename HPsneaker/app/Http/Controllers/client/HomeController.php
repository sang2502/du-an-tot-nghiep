<?php 
namespace App\Http\Controllers\client;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;


class HomeController extends Controller
{
    public function index()
    {
        $products = Product::where('status', 1)->take(8)->get();
        $categories = Category::all();
        $newProducts = Product::orderBy('created_at', 'desc')->take(3)->get();
        $brands = Brand ::all();

        return view('client.home.index', compact('products', 'categories', 'newProducts','brands'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        if (empty($query)) {
            return redirect()->route('home.index');
        }
        
        $products = Product::where('name', 'like', "%$query%")->get();
        return view('client.home.search', compact('products'));
    }
}