<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Designation;
use Illuminate\Http\Request;

class DesignationController extends Controller
{
    public function index()
    {
        $designations = Designation::all();
        return view('designations.index', compact('designations'));
    }

    public function create()
    {
        return view('designations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'default_punch_access' => 'boolean'
        ]);

        $designations = [];
        $defaultPunch = $request->has('default_punch_access');
        
        if (is_array($request->name)) {
            foreach ($request->name as $name) {
                if (!empty(trim($name))) {
                    $designations[] = Designation::create([
                        'name' => trim($name),
                        'default_punch_access' => $defaultPunch
                    ]);
                }
            }
        } else {
            $designations[] = Designation::create([
                'name' => trim($request->name),
                'default_punch_access' => $defaultPunch
            ]);
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'designation' => $designations[0] ?? null,
                'designations' => $designations
            ]);
        }

        return redirect()->route('designations.index')->with('success', 'Designation created successfully.');
    }

    public function edit(Designation $designation)
    {
        return view('designations.edit', compact('designation'));
    }

    public function update(Request $request, Designation $designation)
    {
        $request->validate([
            'name' => 'required',
            'default_punch_access' => 'boolean'
        ]);

        $defaultPunch = $request->has('default_punch_access');

        if (is_array($request->name)) {
            $designation->update([
                'name' => trim($request->name[0]),
                'default_punch_access' => $defaultPunch
            ]);
            
            for ($i = 1; $i < count($request->name); $i++) {
                if (!empty(trim($request->name[$i]))) {
                    Designation::create([
                        'name' => trim($request->name[$i]),
                        'default_punch_access' => $defaultPunch
                    ]);
                }
            }
        } else {
            $designation->update([
                'name' => trim($request->name),
                'default_punch_access' => $defaultPunch
            ]);
        }

        return redirect()->route('designations.index')->with('success', 'Designation updated successfully.');
    }

    public function destroy(Designation $designation)
    {
        $designation->delete();
        return redirect()->route('designations.index')->with('success', 'Designation deleted successfully.');
    }
}
