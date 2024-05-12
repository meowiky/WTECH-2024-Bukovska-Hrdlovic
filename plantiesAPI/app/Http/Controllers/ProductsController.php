<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;



class ProductsController extends Controller
{
    public function showProductsPage()
    {
        $categories = Category::all();
        $products = Product::with('categories')->get();

        $careLevels = [
            1 => 'Low (requires minimal care)',
            2 => 'Medium (requires regular care)',
            3 => 'High (requires dedicated care)'
        ];

        $careLevelCounts = Product::select('care_level', DB::raw('count(*) as count'))
            ->groupBy('care_level')
            ->get()
            ->pluck('count', 'care_level')
            ->mapWithKeys(function ($count, $level) use ($careLevels) {
                return [$level => $count];
            });

        return view('products', compact('categories', 'products', 'careLevelCounts', 'careLevels'));

    }


    public function filterProducts(Request $request)
    {
        $categories = $request->input('categories', []);
        $careLevel = $request->input('careLevel');
        $sort = $request->input('sort', 'Latest');  // Default sort
        $searchText = $request->input('search');

        $products = Product::query();

        if ($careLevel) {
            $products->where('care_level', $careLevel);
        }

        if (!empty($categories)) {
            $products->whereHas('categories', function ($query) use ($categories) {
                $query->whereIn('categories.id', $categories);
            });
        }

        if ($searchText) {
            $products->whereRaw('LOWER(name) LIKE ?', ['%'.strtolower($searchText).'%']);
        }

        switch ($sort) {
            case 'Latest':
                $products->orderBy('created_at', 'desc');
                break;
            case 'Oldest':
                $products->orderBy('created_at', 'asc');
                break;
            case 'Cheapest':
                $products->orderBy('price', 'asc');
                break;
            case 'Most expensive':
                $products->orderBy('price', 'desc');
                break;
        }

        $products = $products->get();

        return response()->json([
            'html' => view('partials.product_tiles', compact('products'))->render(),
            'count' => $products->count()
        ]);
    }



}
