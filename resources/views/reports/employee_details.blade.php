@extends('layouts.app')

@section('title', 'Employee Full Details Report')

@section('content')
<div class="row w-100">
    <div class="col-lg-12 mx-auto">
        <div class="page-header" style="display:inline">
            <h1 class="page-title mb-2">Employee Full Details Report</h1>
            <div class="ms-auto">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('reports.index') }}">Reports</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Employee Details</li>
                </ol>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 datatable-basic">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-bottom-0">Emp ID</th>
                                <th class="border-bottom-0">Name</th>
                                <th class="border-bottom-0">Company</th>
                                <th class="border-bottom-0">Department</th>
                                <th class="border-bottom-0">Designation</th>
                                <th class="border-bottom-0">Passport No</th>
                                <th class="border-bottom-0">Passport Expiry</th>
                                <th class="border-bottom-0">Visa No</th>
                                <th class="border-bottom-0">Visa Expiry</th>
                                <th class="border-bottom-0">Labor No</th>
                                <th class="border-bottom-0">Labor Expiry</th>
                                <th class="border-bottom-0">EID No</th>
                                <th class="border-bottom-0">EID Expiry</th>
                                <th class="border-bottom-0">Joining Date</th>
                                <th class="border-bottom-0">Email</th>
                                <th class="border-bottom-0">Phone</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($employees as $employee)
                            <tr>
                                <td class="fw-bold">{{ $employee->employee_id }}</td>
                                <td>
                                    <div class="fw-bold">{{ $employee->first_name }} {{ $employee->last_name }}</div>
                                </td>
                                <td>{{ $employee->company->company_name ?? '-' }}</td>
                                <td>{{ $employee->department->name ?? '-' }}</td>
                                <td>{{ $employee->designation->name ?? '-' }}</td>
                                <td>{{ $employee->passport_number }}</td>
                                <td>{{ $employee->passport_expiry_date }}</td>
                                <td>{{ $employee->visa_number }}</td>
                                <td>{{ $employee->visa_expiry_date }}</td>
                                <td>{{ $employee->labor_number }}</td>
                                <td>{{ $employee->labor_expiry_date }}</td>
                                <td>{{ $employee->eid_number }}</td>
                                <td>{{ $employee->eid_expiry_date }}</td>
                                <td>{{ $employee->joining_date }}</td>
                                <td>{{ $employee->company_email }}</td>
                                <td>{{ $employee->company_mobile_number }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
