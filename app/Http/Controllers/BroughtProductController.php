<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BroughtProduct;
use App\Models\RawProduct;

class BroughtProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $broughtProducts = BroughtProduct::with('product')
            ->when($search, function ($query, $search) {
                return $query->whereHas('product', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                });
            })
            ->latest()
            ->paginate(10);

        return view('brought-products.index', compact('broughtProducts'));
    }

    public function create()
    {
        $products = RawProduct::all();
        return view('brought-products.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'comments' => 'nullable|string',
        ]);

        BroughtProduct::create($request->all());
        return redirect()->route('brought-products.index')->with('success', 'Brought product recorded successfully.');
    }

    public function edit(BroughtProduct $broughtProduct)
    {
        $products = RawProduct::all();
        return view('brought-products.edit', compact('broughtProduct', 'products'));
    }

    public function update(Request $request, BroughtProduct $broughtProduct)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'comments' => 'nullable|string',
        ]);

        $broughtProduct->update($request->all());
        return redirect()->route('brought-products.index')->with('success', 'Brought product updated successfully.');
    }

    public function destroy(BroughtProduct $broughtProduct)
    {
        $broughtProduct->delete();
        return redirect()->route('brought-products.index')->with('success', 'Brought product deleted successfully.');
    }
}
