<?php 
namespace App\Http\Controllers\client;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
class ShopCartController extends Controller
{
    public function index()
    {
        
        return view('client.shop.product-cart');
    }

    
}