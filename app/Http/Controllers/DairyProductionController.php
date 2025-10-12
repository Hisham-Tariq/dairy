<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DairyProduction;
use App\Models\Product;
use App\Models\Worker;
use App\Models\ProductionHelper;
use Illuminate\Support\Facades\DB;

class DairyProductionController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $productions = DairyProduction::with(['product', 'mixer', 'supervisor', 'helpers.worker'])
            ->when($search, function ($query, $search) {
                return $query->whereHas('product', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                })->orWhere('batch_number', 'like', '%' . $search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('dairy-productions.index', compact('productions'));
    }

    public function create()
    {
        $products = Product::all();
        $mixers = Worker::where('skills', 'like', '%Mixer%')->get();
        $supervisors = Worker::where('is_supervisor', true)->get();
        $helpers = Worker::where('skills', 'like', '%Prep & Deposit%')->get();

        return view('dairy-productions.create', compact('products', 'mixers', 'supervisors', 'helpers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'mixer_id' => 'required|exists:workers,id',
            'supervisor_id' => 'required|exists:workers,id',
            'number_of_trays' => 'required|integer|min:1',
            'baking_temp' => 'required|numeric',
            'baking_time' => 'required|integer',
            'helpers' => 'nullable|array',
            'helpers.*.worker_id' => 'required|exists:workers,id',
            'helpers.*.table_number' => 'nullable|integer',
        ]);

        DB::beginTransaction();
        try {
            $batchNumber = $this->generateBatchNumber($request->number_of_trays);

            $production = DairyProduction::create([
                'product_id' => $request->product_id,
                'mixer_id' => $request->mixer_id,
                'supervisor_id' => $request->supervisor_id,
                'number_of_trays' => $request->number_of_trays,
                'batch_number' => $batchNumber,
                'baking_temp' => $request->baking_temp,
                'baking_time' => $request->baking_time,
            ]);

            if ($request->has('helpers')) {
                foreach ($request->helpers as $helper) {
                    ProductionHelper::create([
                        'dairy_production_id' => $production->id,
                        'worker_id' => $helper['worker_id'],
                        'table_number' => $helper['table_number'] ?? null,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('dairy-productions.index')->with('success', 'Dairy production created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Failed to create production: ' . $e->getMessage());
        }
    }

    public function edit(DairyProduction $dairyProduction)
    {
        $dairyProduction->load('helpers.worker');
        $products = Product::all();
        $mixers = Worker::where('skills', 'like', '%Mixer%')->get();
        $supervisors = Worker::where('is_supervisor', true)->get();
        $helpers = Worker::where('skills', 'like', '%Prep & Deposit%')->get();

        return view('dairy-productions.edit', compact('dairyProduction', 'products', 'mixers', 'supervisors', 'helpers'));
    }

    public function update(Request $request, DairyProduction $dairyProduction)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'mixer_id' => 'required|exists:workers,id',
            'supervisor_id' => 'required|exists:workers,id',
            'number_of_trays' => 'required|integer|min:1',
            'baking_temp' => 'required|numeric',
            'baking_time' => 'required|integer',
            'helpers' => 'nullable|array',
            'helpers.*.worker_id' => 'required|exists:workers,id',
            'helpers.*.table_number' => 'nullable|integer',
        ]);

        DB::beginTransaction();
        try {
            $dairyProduction->update([
                'product_id' => $request->product_id,
                'mixer_id' => $request->mixer_id,
                'supervisor_id' => $request->supervisor_id,
                'number_of_trays' => $request->number_of_trays,
                'baking_temp' => $request->baking_temp,
                'baking_time' => $request->baking_time,
            ]);

            $dairyProduction->helpers()->delete();

            if ($request->has('helpers')) {
                foreach ($request->helpers as $helper) {
                    ProductionHelper::create([
                        'dairy_production_id' => $dairyProduction->id,
                        'worker_id' => $helper['worker_id'],
                        'table_number' => $helper['table_number'] ?? null,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('dairy-productions.index')->with('success', 'Dairy production updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Failed to update production: ' . $e->getMessage());
        }
    }

    public function destroy(DairyProduction $dairyProduction)
    {
        $dairyProduction->delete();
        return redirect()->route('dairy-productions.index')->with('success', 'Dairy production deleted successfully.');
    }

    private function generateBatchNumber($numberOfTrays)
    {
        return now()->format('Ymd') . str_pad($numberOfTrays, 4, '0', STR_PAD_LEFT);
    }

    public function getProductDetails($id)
    {
        $product = Product::findOrFail($id);
        return response()->json([
            'temperature' => $product->temperature,
            'time' => $product->time,
        ]);
    }
}
