@extends('layouts.app')

@section('title', 'Manage Leave Allocation')

@section('content')
<div class="page-header">
    <h1 class="page-title mb-2">Manage Leave Allocation</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('leaves.index') }}">Leaves</a></li>
            <li class="breadcrumb-item"><a href="{{ route('leave-allocations.index') }}">Allocations</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card shadow-sm border-0">
            <div class="card-header border-bottom-0 pb-0">
                <h3 class="card-title">Employee Details</h3>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-4">
                    <div class="avatar avatar-xl rounded-circle bg-primary-transparent text-primary d-flex align-items-center justify-content-center me-3">
                        <span class="fs-20 fw-bold">{{ strtoupper(substr($employee->first_name, 0, 1)) }}{{ strtoupper(substr($employee->last_name, 0, 1)) }}</span>
                    </div>
                    <div>
                        <h4 class="mb-0">{{ $employee->first_name }} {{ $employee->last_name }}</h4>
                        <p class="text-muted mb-0">{{ $employee->employee_id }} | {{ $employee->designation->name ?? 'No Designation' }}</p>
                    </div>
                </div>
                
                <div class="row g-3">
                    <div class="col-6">
                        <label class="small text-muted text-uppercase fw-bold">Department</label>
                        <p class="mb-0">{{ $employee->department->name ?? 'N/A' }}</p>
                    </div>
                    <div class="col-6">
                        <label class="small text-muted text-uppercase fw-bold">Company</label>
                        <p class="mb-0">{{ $employee->company->company_name ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <form action="{{ route('leave-allocations.update', $employee->id) }}" method="POST">
            @csrf
            <div class="card shadow-sm border-0">
                <div class="card-header border-bottom-0 pb-0 d-flex justify-content-between">
                    <h3 class="card-title">Allocate Leaves for {{ date('Y') }}</h3>
                </div>
                <div class="card-body">
                    @if(count($leaveTypes) > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Leave Type</th>
                                        <th style="width: 150px;">Allocated Days</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($leaveTypes as $type)
                                    <tr>
                                        <td>
                                            <div class="fw-semibold">{{ $type->name }}</div>
                                            <small class="text-muted">Current Balance: {{ $employee->getLeaveBalance($type->id) }} days</small>
                                        </td>
                                        <td>
                                            <input type="number" 
                                                   name="allocations[{{ $type->id }}]" 
                                                   class="form-control" 
                                                   value="{{ $allocations->has($type->id) ? $allocations[$type->id]->allocated_days : 0 }}" 
                                                   min="0" 
                                                   step="1">
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-warning">
                            No active leave types found. Please <a href="{{ route('leaves.types.index') }}">create leave types</a> first.
                        </div>
                    @endif
                </div>
                <div class="card-footer text-end border-top-0 pt-0 bg-transparent">
                    <a href="{{ route('leave-allocations.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary" {{ count($leaveTypes) == 0 ? 'disabled' : '' }}>
                        <i class="fe fe-save me-1"></i>Save Allocations
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
