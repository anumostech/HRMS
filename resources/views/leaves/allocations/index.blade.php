@extends('layouts.app')

@section('title', 'Leave Allocations')

@section('content')
<div class="page-header">
    <h1 class="page-title mb-2">Leave Allocations</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('leaves.index') }}">Leaves</a></li>
            <li class="breadcrumb-item active" aria-current="page">Allocations</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm border-0">
            <div class="card-header d-flex justify-content-between align-items-center border-bottom">
                <div>
                    <h3 class="card-title mb-1">Employee Leave Balances ({{ date('Y') }})</h3>
                    <div class="d-flex gap-3 small text-muted mt-2">
                        <div class="d-flex align-items-center"><span class="badge bg-primary-transparent text-primary me-1" style="width:12px; height:12px; padding:0;"></span> Allocated</div>
                        <div class="d-flex align-items-center"><span class="badge bg-danger-transparent text-danger me-1" style="width:12px; height:12px; padding:0;"></span> Used / Taken</div>
                        <div class="d-flex align-items-center"><span class="badge bg-success text-white me-1" style="width:12px; height:12px; padding:0;"></span> Current Balance</div>
                    </div>
                </div>
                <div>
                    <a href="{{ route('leaves.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fe fe-arrow-left me-1"></i>Back to Requests
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-modern text-nowrap" id="basic-datatable">
                        <thead>
                            <tr>
                                <th>Sl.No.</th>
                                <th>Employee</th>
                                <th>Designation</th>
                                <th>Company</th>
                                @foreach($leaveTypes as $type)
                                <th class="text-center border-start">
                                    <div class="text-primary fw-bold">{{ $type->name }}</div>
                                    <div class="d-flex justify-content-center gap-1 mt-1" style="font-size: 0.7rem;">
                                        <span class="text-muted">Alloc</span>
                                        <span class="text-muted">|</span>
                                        <span class="text-muted">Used</span>
                                        <span class="text-muted">|</span>
                                        <span class="text-muted">Bal</span>
                                    </div>
                                </th>
                                @endforeach
                                <th class="text-end border-start">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($employees as $employee)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div class="fw-semibold text-dark">{{ $employee->first_name }} {{ $employee->last_name }}</div>
                                </td>
                                <td>{{ $employee->designation->name ?? 'N/A' }}</td>
                                <td>{{ $employee->company->company_name ?? 'N/A' }}</td>
                                
                                @foreach($leaveTypes as $type)
                                @php 
                                    $allocated = $employee->leaveAllocations()
                                        ->where('leave_type_id', $type->id)
                                        ->where('year', date('Y'))
                                        ->sum('allocated_days');
                                    $taken = $employee->leaveRequests()
                                        ->where('leave_type_id', $type->id)
                                        ->where('status', 'approved')
                                        ->whereYear('start_date', date('Y'))
                                        ->sum('duration_days');
                                    $balance = $allocated - $taken;
                                @endphp
                                <td class="text-center border-start">
                                    <div class="d-flex justify-content-center align-items-center gap-1">
                                        <span class="badge bg-primary-transparent text-primary" title="Allocated" style="min-width: 25px;">@if($allocated < 0) 0 @else {{ $allocated }} @endif</span>
                                        <span class="text-muted small">|</span>
                                        <span class="badge bg-danger-transparent text-danger" title="Taken" style="min-width: 25px;">@if($taken < 0) 0 @else {{ $taken }} @endif</span>
                                        <span class="text-muted small">|</span>
                                        <span class="badge bg-success text-white fw-bold" title="Balance" style="min-width: 25px;">@if($balance < 0) 0 @else {{ $balance }} @endif</span>
                                    </div>
                                </td>
                                @endforeach

                                <td class="text-end">
                                    <a href="{{ route('leave-allocations.edit', $employee->id) }}" class="btn btn-sm btn-outline-primary" title="Manage Allocations">
                                        <i class="fe fe-edit-2"></i>
                                    </a>
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
@endsection
