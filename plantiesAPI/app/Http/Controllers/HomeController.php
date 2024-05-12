<?php
namespace App\Http\Controllers;

use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $recentProducts = Product::orderBy('created_at', 'desc')->take(3)->get();

        return view('home', compact('recentProducts'));
    }
}

