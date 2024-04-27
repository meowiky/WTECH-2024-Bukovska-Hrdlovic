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
        Log::info('Care Level Received: ' . $careLevel);
        Log::info('Categories Received: ' . implode(', ', $categories));


        $products = Product::query();

        if ($careLevel) {
            $products->where('care_level', $careLevel);
        }

        if (!empty($categories)) {
            $products->whereHas('categories', function ($query) use ($categories) {
                $query->whereIn('categories.id', $categories);
            });
        }

        $filteredProducts = $products->get();

        return response()->json([
            'html' => view('partials.product_tiles', ['products' => $filteredProducts])->render(),
            'count' => $filteredProducts->count()
        ]);
    }


}
