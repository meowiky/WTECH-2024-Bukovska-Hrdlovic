<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $products = Product::with('categories')->get();
        return view('admin.dashboard', compact('products'));
    }
}
