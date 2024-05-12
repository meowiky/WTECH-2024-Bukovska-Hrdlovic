<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{
    public function showProductsPage(Request $request)
    {
        $categories = Category::all();
        $categoryIds = $request->input('categories', []);
        $careLevel = $request->input('careLevel');
        $sort = $request->input('sort', 'Latest');

        $searchText = $request->input('search');

        $productsQuery = Product::with('categories');

        if ($careLevel) {
            $productsQuery->where('care_level', $careLevel);
        }

        if (!empty($categoryIds)) {
            $productsQuery->whereHas('categories', function ($query) use ($categoryIds) {
                $query->whereIn('categories.id', $categoryIds);
            });
        }

        if ($searchText) {
            $productsQuery->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($searchText) . '%']);
        }

        switch ($sort) {
            case 'Latest':
                $productsQuery->orderBy('created_at', 'desc');
                break;
            case 'Oldest':
                $productsQuery->orderBy('created_at', 'asc');
                break;
            case 'Cheapest':
                $productsQuery->orderBy('price', 'asc');
                break;
            case 'Most expensive':
                $productsQuery->orderBy('price', 'desc');
                break;
        }

        $products = $productsQuery->paginate(9)->appends([
            'careLevel' => $careLevel,
            'categories' => $categoryIds,
            'sort' => $sort
        ]);

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

        if ($request->ajax()) {
            return response()->json([
                'html' => view('partials.product_tiles', compact('products'))->render(),
                'pagination' => $products->links()->toHtml(),
                'count' => $products->total()
            ]);
        }

        return view('products', compact('categories', 'products', 'careLevelCounts', 'careLevels'));
    }
}
