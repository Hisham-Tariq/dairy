<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Worker;

class DashboardController extends Controller
{
    public function index()
    {
        $departmentsCount = Department::count();
        $workersCount = Worker::count();
        $supervisorsCount = Worker::where('is_supervisor', true)->count();
        $departments = Department::orderBy('name')->get();

        return view('dashboard', compact('departmentsCount', 'workersCount', 'supervisorsCount', 'departments'));
    }
}
