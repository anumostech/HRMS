<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrganizationController extends Controller
{
    public function index()
    {
        $organizations = Organization::latest()->get();
        return view('admin.organizations.index', compact('organizations'));
    }

    public function create()
    {
        return view('admin.organizations.create');
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
            $path = $request->file('logo')->store('logos/organizations', 'public');
            $data['logo'] = $path;
        }

        $organization = Organization::create($data);

        if (!$organization->has_multiple_companies) {
            Company::create([
                'organization_id' => $organization->id,
                'company_name' => $organization->org_name,
                'phone' => $organization->phone,
                'email' => $organization->email,
                'logo' => $organization->logo,
                'address' => $organization->address,
            ]);
        }

        return redirect()->route('organizations.index')->with('success', 'Organization created successfully.');
    }

    public function edit(Organization $organization)
    {
        return view('admin.organizations.edit', compact('organization'));
    }

    public function update(Request $request, Organization $organization)
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
            $path = $request->file('logo')->store('logos/organizations', 'public');
            $data['logo'] = $path;
        }

        $organization->update($data);

        if (!$organization->has_multiple_companies) {
            $company = Company::where('organization_id', $organization->id)->first();
            
            $companyData = [
                'company_name' => $organization->org_name,
                'phone' => $organization->phone,
                'email' => $organization->email,
                'logo' => $organization->logo,
                'address' => $organization->address,
            ];

            if ($company) {
                $company->update($companyData);
            } else {
                Company::create(array_merge(['organization_id' => $organization->id], $companyData));
            }
        }

        return redirect()->route('organizations.index')->with('success', 'Organization updated successfully.');
    }

    public function destroy(Organization $organization)
    {
        $organization->delete();
        return redirect()->route('organizations.index')->with('success', 'Organization deleted successfully.');
    }
}
