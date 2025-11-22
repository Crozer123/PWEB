<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Item;

class CustomerCatalogController extends Controller
{
public function index()
{
    $query = Item::with('category')->where('stock', '>', 0);

    if (request()->filled('search')) {
        $query->where('name', 'like', '%' . request('search') . '%');
    }

    if (request()->filled('category')) {
        $query->where('category_id', request('category'));
    }

    $items = $query->paginate(12)->withQueryString();

    $categories = \App\Models\Category::withCount('items')->get();

    return view('customer.catalog.index', compact('items', 'categories'));
}

    public function show(Item $item)
    {
        return view('customer.catalog.show', compact('item'));
    }
}
    