<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RawProduct;
use App\Models\Department;

class RawProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $products = RawProduct::with('department')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', '%' . $search . '%');
            })
            ->paginate(10);

        $departments = Department::all();

        return view('rawproducts.index', compact('products', 'departments'));
    }

    public function create()
    {
        $departments = Department::all();
        return view('rawproducts.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
        ]);

        RawProduct::create($request->all());
        return redirect()->route('rawproducts.index')->with('success', 'Product created successfully.');
    }

    public function edit(RawProduct $product)
    {
        $departments = Department::all();
        return view('rawproducts.edit', compact('product', 'departments'));
    }

    public function update(Request $request, RawProduct $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
        ]);

        $product->update($request->all());
        return redirect()->route('rawproducts.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(RawProduct $product)
    {
        $product->delete();
        return redirect()->route('rawproducts.index')->with('success', 'Product deleted successfully.');
    }
}
