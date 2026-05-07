<?php

namespace App\Http\Controllers;
use App\Models\Department;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::all();
        return view('departments.index', compact('departments'));
    }

    public function create()
    {
        return view('departments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $departments = [];
        
        if (is_array($request->name)) {
            foreach ($request->name as $name) {
                if (!empty(trim($name))) {
                    $departments[] = Department::create(['name' => trim($name)]);
                }
            }
        } else {
            $departments[] = Department::create(['name' => trim($request->name)]);
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'department' => $departments[0] ?? null,
                'departments' => $departments
            ]);
        }

        return redirect()->route('departments.index')->with('success', 'Department created successfully.');
    }

    public function edit(Department $department)
    {
        return view('departments.edit', compact('department'));
    }

    public function update(Request $request, Department $department)
    {
        $request->validate([
            'name' => 'required'
        ]);

        if (is_array($request->name)) {
            $department->update([
                'name' => trim($request->name[0])
            ]);
            
            for ($i = 1; $i < count($request->name); $i++) {
                if (!empty(trim($request->name[$i]))) {
                    Department::create(['name' => trim($request->name[$i])]);
                }
            }
        } else {
            $department->update([
                'name' => trim($request->name)
            ]);
        }

        return redirect()->route('departments.index')->with('success', 'Department updated successfully.');
    }

    public function destroy(Department $department)
    {
        $department->delete();
        return redirect()->route('departments.index')->with('success', 'Department deleted successfully.');
    }
}
