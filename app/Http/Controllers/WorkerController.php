<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Worker;
use App\Models\Department;

class WorkerController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $workers = Worker::with('department')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', '%' . $search . '%');
            })
            ->paginate(10);

        $departments = Department::all();

        return view('workers.index', compact('workers', 'departments'));
    }

    public function create()
    {
        $departments = Department::all();
        return view('workers.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'skills' => 'nullable|string',
            'is_supervisor' => 'boolean',
        ]);

        Worker::create($request->all());
        return redirect()->route('workers.index')->with('success', 'Worker created successfully.');
    }

    public function edit(Worker $worker)
    {
        $departments = Department::all();
        return view('workers.edit', compact('worker', 'departments'));
    }

    public function update(Request $request, Worker $worker)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'skills' => 'nullable|string',
            'is_supervisor' => 'boolean',
        ]);

        $worker->update($request->all());
        return redirect()->route('workers.index')->with('success', 'Worker updated successfully.');
    }

    public function destroy(Worker $worker)
    {
        $worker->delete();
        return redirect()->route('workers.index')->with('success', 'Worker deleted successfully.');
    }
}
