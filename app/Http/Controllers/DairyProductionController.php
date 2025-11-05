<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DairyProduction;
use App\Models\Product;
use App\Models\Worker;
use App\Models\ProductionHelper;
use App\Models\DairyProductionMixer;
use Illuminate\Support\Facades\DB;

class DairyProductionController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $productions = DairyProduction::with(['product', 'mixers.worker', 'supervisor', 'helpers.worker'])
            ->when($search, function ($query, $search) {
                return $query->whereHas('product', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                })->orWhere('batch_number', 'like', '%' . $search . '%');
            })
            ->latest()
            ->paginate(10);
        //    return $productions;
        return view('dairy-productions.index', compact('productions'));
    }

    public function create()
    {
        $products = Product::all();
        $mixers = Worker::where('skills', 'like', '%Mixer%')->get();
        $supervisors = Worker::where('is_supervisor', true)->get();
    //    $helpers = Worker::where('skills', 'like', '%Prep & Deposit%')->get();
        $helpers = Worker::all();
    //    $packingWorkers = Worker::where('skills', 'like', '%Packing Machine%')->get();
      //  $packingWorkers = Worker::all();

        return view('dairy-productions.create', compact('products', 'mixers', 'supervisors', 'helpers'));
    }

    public function store(Request $request)
    {
        // $request->validate([
        //     'product_id' => 'required|exists:products,id',
        //     'mixer_ids' => 'required|array|min:1',
        //     'mixer_ids.*' => 'exists:workers,id',
        //     'supervisor_id' => 'required|exists:workers,id',
        //     'number_of_trays' => 'required|integer|min:1',
        //     'total_bowls' => 'nullable|integer|min:1',
        //     'total_tables' => 'nullable|integer|min:1',
        //     'baking_temp' => 'required|numeric',
        //     'baking_time' => 'required|integer',
        //     'helper_ids' => 'nullable|array',
        //     'helper_ids.*' => 'exists:workers,id',
        //     'helper_table_numbers' => 'nullable|array',
        //     'packing_worker_ids' => 'nullable|array',
        //     'packing_worker_ids.*' => 'exists:workers,id',
        // ]);

     //   DB::beginTransaction();
       // try {
           // $batchNumber = $this->generateBatchNumber($request->number_of_trays);

            $production = DairyProduction::create([
                'product_id' => $request->product_id,
                'supervisor_id' => $request->supervisor_id,
                'number_of_trays' => $request->number_of_trays,
                'total_bowls' => $request->total_bowls,
                'total_tables' => $request->total_tables,
                'batch_number' => 1,
                'baking_temp' => $request->baking_temp,
                'baking_time' => $request->baking_time,
            ]);
//return $production;
            // Attach mixers
           // $production->mixers()->attach($request->mixer_ids);
            if ($request->has('mixer_ids')) {
                foreach ($request->mixer_ids as $index => $workerId) {
                    DairyProductionMixer::create([
                        'dairy_production_id' => $production->id,
                        'worker_id' => $workerId,
                    ]);
                }
            }

            // Attach packing workers
            // if ($request->has('packing_worker_ids')) {
            //     $production->packingWorkers()->attach($request->packing_worker_ids);
            // }

            // Attach helpers with table numbers
            if ($request->has('helper_ids')) {
                foreach ($request->helper_ids as $index => $workerId) {
                    ProductionHelper::create([
                        'dairy_production_id' => $production->id,
                        'worker_id' => $workerId,
                        'table_number' => $request->helper_table_numbers[$index] ?? null,
                    ]);
                }
            }

         //   DB::commit();
            return redirect()->route('dairy-productions.index')->with('success', 'Dairy production created successfully.');
        // } catch (\Exception $e) {
        //     DB::rollBack();
        //     return back()->withInput()->with('error', 'Failed to create production: ' . $e->getMessage());
        // }
    }

    public function edit(DairyProduction $dairyProduction)
    {
        $dairyProduction->load(['mixers', 'helpers.worker', 'packingWorkers']);
        $products = Product::all();
        $mixers = Worker::where('skills', 'like', '%Mixer%')->get();
        $supervisors = Worker::where('is_supervisor', true)->get();
        $helpers = Worker::where('skills', 'like', '%Prep & Deposit%')->get();
        $packingWorkers = Worker::where('skills', 'like', '%Packing Machine%')->get();

        return view('dairy-productions.edit', compact('dairyProduction', 'products', 'mixers', 'supervisors', 'helpers', 'packingWorkers'));
    }

    public function update(Request $request, DairyProduction $dairyProduction)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'mixer_ids' => 'required|array|min:1',
            'mixer_ids.*' => 'exists:workers,id',
            'supervisor_id' => 'required|exists:workers,id',
            'number_of_trays' => 'required|integer|min:1',
            'total_bowls' => 'nullable|integer|min:1',
            'total_tables' => 'nullable|integer|min:1',
            'baking_temp' => 'required|numeric',
            'baking_time' => 'required|integer',
            'helper_ids' => 'nullable|array',
            'helper_ids.*' => 'exists:workers,id',
            'helper_table_numbers' => 'nullable|array',
            'packing_worker_ids' => 'nullable|array',
            'packing_worker_ids.*' => 'exists:workers,id',
        ]);

        DB::beginTransaction();
        try {
            $dairyProduction->update([
                'product_id' => $request->product_id,
                'supervisor_id' => $request->supervisor_id,
                'number_of_trays' => $request->number_of_trays,
                'total_bowls' => $request->total_bowls,
                'total_tables' => $request->total_tables,
                'baking_temp' => $request->baking_temp,
                'baking_time' => $request->baking_time,
            ]);

            // Sync mixers
            $dairyProduction->mixers()->sync($request->mixer_ids);

            // Sync packing workers
            if ($request->has('packing_worker_ids')) {
                $dairyProduction->packingWorkers()->sync($request->packing_worker_ids);
            } else {
                $dairyProduction->packingWorkers()->sync([]);
            }

            // Delete and recreate helpers
            $dairyProduction->helpers()->delete();
            if ($request->has('helper_ids')) {
                foreach ($request->helper_ids as $index => $workerId) {
                    ProductionHelper::create([
                        'dairy_production_id' => $dairyProduction->id,
                        'worker_id' => $workerId,
                        'table_number' => $request->helper_table_numbers[$index] ?? null,
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