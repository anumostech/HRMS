<?php

namespace App\Http\Controllers;

use App\Models\Organisation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrganizationController extends Controller
{
    public function index()
    {
        $organisations = Organisation::latest()->get();
        return view('admin.organisations.index', compact('organisations'));
    }

    public function create()
    {
        return view('admin.organisations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'org_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'has_multiple_companies' => 'required|boolean',
            'address' => 'nullable|string',
        ]);

        $data = $request->except('logo');
        
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('logos/organisations', 'public');
            $data['logo'] = $path;
        }

        Organisation::create($data);

        return redirect()->route('organizations.index')->with('success', 'Organisation created successfully.');
    }

    public function edit(Organisation $organization)
    {
        return view('admin.organisations.edit', compact('organization'));
    }

    public function update(Request $request, Organisation $organization)
    {
        $request->validate([
            'org_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'has_multiple_companies' => 'required|boolean',
            'address' => 'nullable|string',
        ]);

        $data = $request->except('logo');

        if ($request->hasFile('logo')) {
            // Delete old logo
            if ($organization->logo) {
                Storage::disk('public')->delete($organization->logo);
            }
            $path = $request->file('logo')->store('logos/organisations', 'public');
            $data['logo'] = $path;
        }

        $organization->update($data);

        return redirect()->route('organizations.index')->with('success', 'Organisation updated successfully.');
    }

    public function destroy(Organisation $organization)
    {
        $organization->delete();
        return redirect()->route('organizations.index')->with('success', 'Organisation deleted successfully.');
    }
}
