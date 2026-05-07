@extends('layouts.app')

@section('title', $title)

@section('content')
<div class="row w-100">
    <div class="col-lg-12 mx-auto">
        <div class="page-header" style="display:inline">
            <h1 class="page-title mb-2">{{ $title }}</h1>
            <div class="ms-auto d-flex align-items-center gap-3">
                <span class="badge bg-soft-danger px-3 py-2 rounded-pill">{{ $subtitle }}</span>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('reports.index') }}">Reports</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                </ol>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 datatable-basic">
                        <thead class="bg-light">
                            <tr>
                                <th>Emp ID</th>
                                <th>Name</th>
                                <th>Passport Expiry</th>
                                <th>Visa Expiry</th>
                                <th>Labor Expiry</th>
                                <th>EID Expiry</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($employees as $employee)
                            @php
                                $threshold = \Carbon\Carbon::now()->addDays(30);
                            @endphp
                            <tr>
                                <td class="fw-bold">{{ $employee->employee_id }}</td>
                                <td>
                                    <div class="fw-bold">{{ $employee->first_name }} {{ $employee->last_name }}</div>
                                </td>
                                <td class="{{ $employee->passport_expiry_date && \Carbon\Carbon::parse($employee->passport_expiry_date)->lte($threshold) ? 'text-danger fw-bold' : '' }}">
                                    {{ $employee->passport_expiry_date }}
                                </td>
                                <td class="{{ $employee->visa_expiry_date && \Carbon\Carbon::parse($employee->visa_expiry_date)->lte($threshold) ? 'text-danger fw-bold' : '' }}">
                                    {{ $employee->visa_expiry_date }}
                                </td>
                                <td class="{{ $employee->labor_expiry_date && \Carbon\Carbon::parse($employee->labor_expiry_date)->lte($threshold) ? 'text-danger fw-bold' : '' }}">
                                    {{ $employee->labor_expiry_date }}
                                </td>
                                <td class="{{ $employee->eid_expiry_date && \Carbon\Carbon::parse($employee->eid_expiry_date)->lte($threshold) ? 'text-danger fw-bold' : '' }}">
                                    {{ $employee->eid_expiry_date }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-soft-danger { background: rgba(239, 68, 68, 0.1); color: #ef4444; }
</style>
@endsection
