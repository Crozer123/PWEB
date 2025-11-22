<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category; 
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::withCount('items')->get();

        $query = Item::with('category');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        $items = $query->latest()->paginate(12);
        return view('customer.catalog.index', compact('items', 'categories'));
    }
    public function show(Item $item)
    {
        return view('customer.catalog.show', compact('item'));
    }
}
