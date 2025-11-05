<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FreezerTemperature;
use App\Models\RawProduct;
use App\Models\Worker;
use Carbon\Carbon;

class FreezerTempController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $dateFilter = $request->get('date');
        
        $temperatures = FreezerTemperature::with(['recordedBy'])
            ->when($search, function ($query, $search) {
                return $query->whereHas('rawProduct', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                })->orWhereHas('recordedBy', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                });
            })
            ->when($dateFilter, function ($query, $dateFilter) {
                return $query->whereDate('recorded_at', $dateFilter);
            })
            ->latest('recorded_at')
            ->paginate(15);

        $rawProducts = RawProduct::all();
        $workers = Worker::all();

        return view('Freezertemp.index', compact('temperatures', 'rawProducts', 'workers'));
    }

    public function store(Request $request)
    {
        // $request->validate([
        //     'raw_product_id' => 'required|exists:raw_products,id',
        //     'recorded_by' => 'required|exists:workers,id',
        //     'temperature' => 'required|numeric',
        //     'recorded_at' => 'required|date',
        //     'notes' => 'nullable|string|max:1000',
        // ]);
       
        Freezertemperature::create($request->all());
        
        return redirect()->route('Freezertemp.index')
            ->with('success', 'Temperature recorded successfully.');
    }

    public function update(Request $request, FreezerTemperature $freezerTemperature)
    {
        $request->validate([
            'raw_product_id' => 'required|exists:raw_products,id',
            'recorded_by' => 'required|exists:workers,id',
            'temperature' => 'required|numeric',
            'recorded_at' => 'required|date',
            'notes' => 'nullable|string|max:1000',
        ]);

        $freezerTemperature->update($request->all());
        
        return redirect()->route('freezer-temperatures.index')
            ->with('success', 'Temperature updated successfully.');
    }

    public function destroy(FreezerTemperature $Freezertemp)
    {
      //  return $freezerTemperature;
        $Freezertemp->delete();
        
        return redirect()->route('Freezertemp.index')
            ->with('success', 'Temperature record deleted successfully.');
    }
}