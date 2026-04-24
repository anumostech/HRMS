<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        $organization_id = $request->get('organization_id');
        $companies = Company::with('organization')
            ->when($organization_id, function ($query) use ($organization_id) {
                return $query->where('organization_id', $organization_id);
            })
            ->latest()
            ->get();

        return view('admin.companies.index', compact('companies', 'organization_id'));
    }

    public function getByOrganization($organization_id)
    {
        $companies = Company::where('organization_id', $organization_id)->get();
        return response()->json($companies);
    }

    public function create(Request $request)
    {
        $organization_id = $request->get('organization_id');
        $organizations = organization::where('has_multiple_companies', true)->get();
        return view('admin.companies.create', compact('organization_id', 'organizations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            // 'organization_id' => 'required|exists:organizations,id',
            'company_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'address' => 'nullable|string',
            'trade_license_name' => 'nullable|string|max:255',
            'trade_license_number' => 'nullable|string|max:255',
            'trade_license_expiry' => 'nullable|date_format:d-m-Y',
            'trade_license_attachment' => 'nullable|string',
            'establishment_card_number' => 'nullable|string|max:255',
            'establishment_card_expiry' => 'nullable|date_format:d-m-Y',
            'establishment_card_attachment' => 'nullable|string',
        ]);


        $data = $request->except(['logo', 'trade_license_attachment', 'establishment_card_attachment', 'trade_license_expiry', 'establishment_card_expiry']);

        // Handle logo (standard upload)
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('logos/companies', 'public');
            $data['logo'] = $path;
        }

        // Handle other documents (AJAX upload)
        $docFields = ['trade_license_attachment', 'establishment_card_attachment'];
        foreach ($docFields as $field) {
            $path = $request->input($field);
            if ($path && strpos($path, 'temp/') === 0) {
                $newPath = 'documents/companies/' . basename($path);
                if (Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->move($path, $newPath);
                    $data[$field] = $newPath;
                }
            } else {
                $data[$field] = $path;
            }
        }

        // Handle Dates
        if ($request->filled('trade_license_expiry')) {
            $data['trade_license_expiry'] = Carbon::createFromFormat('d-m-Y', $request->trade_license_expiry)->format('Y-m-d');
        }
        if ($request->filled('establishment_card_expiry')) {
            $data['establishment_card_expiry'] = Carbon::createFromFormat('d-m-Y', $request->establishment_card_expiry)->format('Y-m-d');
        }

        $data['organization_id'] = 1;

        $company = Company::create($data);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'company' => $company]);
        }

        return redirect()->route('companies.index', ['organization_id' => $request->organization_id])
            ->with('success', 'Company created successfully.');
    }

    public function edit(Company $company)
    {
        $organizations = Organization::where('has_multiple_companies', true)->get();
        return view('admin.companies.edit', compact('company', 'organizations'));
    }

    public function update(Request $request, Company $company)
    {
        $request->validate([
            // 'organization_id' => 'required|exists:organizations,id',
            'company_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'address' => 'nullable|string',
            'trade_license_name' => 'nullable|string|max:255',
            'trade_license_number' => 'nullable|string|max:255',
            'trade_license_expiry' => 'nullable|date_format:d-m-Y',
            'trade_license_attachment' => 'nullable|string',
            'establishment_card_number' => 'nullable|string|max:255',
            'establishment_card_expiry' => 'nullable|date_format:d-m-Y',
            'establishment_card_attachment' => 'nullable|string',
        ]);

        $data = $request->except(['logo', 'trade_license_attachment', 'establishment_card_attachment', 'trade_license_expiry', 'establishment_card_expiry']);

        if ($request->hasFile('logo')) {
            if ($company->logo) {
                Storage::disk('public')->delete($company->logo);
            }
            $path = $request->file('logo')->store('logos/companies', 'public');
            $data['logo'] = $path;
        }

        $docFields = ['trade_license_attachment', 'establishment_card_attachment'];
        foreach ($docFields as $field) {
            $path = $request->input($field);
            if ($path && strpos($path, 'temp/') === 0) {
                $newPath = 'documents/companies/' . basename($path);
                if (Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->move($path, $newPath);
                    $data[$field] = $newPath;
                }
            } else {
                $data[$field] = $path;
            }
        }

        if ($request->filled('trade_license_expiry')) {
            $data['trade_license_expiry'] = Carbon::createFromFormat('d-m-Y', $request->trade_license_expiry)->format('Y-m-d');
        }
        if ($request->filled('establishment_card_expiry')) {
            $data['establishment_card_expiry'] = Carbon::createFromFormat('d-m-Y', $request->establishment_card_expiry)->format('Y-m-d');
        }

        $data['organization_id'] = 1;

        $company->update($data);

        return redirect()->route('companies.index', ['organization_id' => $company->organization_id])
            ->with('success', 'Company updated successfully.');
    }

    public function destroy(Company $company)
    {
        $org_id = $company->organization_id;
        $company->delete();
        return redirect()->route('companies.index', ['organization_id' => $org_id])
            ->with('success', 'Company deleted successfully.');
    }
}
