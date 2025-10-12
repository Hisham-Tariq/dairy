<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProducedProduct;
use App\Models\Product;

class ProducedProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $producedProducts = ProducedProduct::with('product')
            ->when($search, function ($query, $search) {
                return $query->whereHas('product', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                });
            })
            ->latest()
            ->paginate(10);

        return view('produced-products.index', compact('producedProducts'));
    }

    public function create()
    {
        $products = Product::all();
        return view('produced-products.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'comments' => 'nullable|string',
        ]);

        ProducedProduct::create($request->all());
        return redirect()->route('produced-products.index')->with('success', 'Produced product recorded successfully.');
    }

    public function edit(ProducedProduct $producedProduct)
    {
        $products = Product::all();
        return view('produced-products.edit', compact('producedProduct', 'products'));
    }

    public function update(Request $request, ProducedProduct $producedProduct)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'comments' => 'nullable|string',
        ]);

        $producedProduct->update($request->all());
        return redirect()->route('produced-products.index')->with('success', 'Produced product updated successfully.');
    }

    public function destroy(ProducedProduct $producedProduct)
    {
        $producedProduct->delete();
        return redirect()->route('produced-products.index')->with('success', 'Produced product deleted successfully.');
    }
}
