@extends('employee.layouts.app')

@section('title', 'My Leaves')
@section('page-title', '')

@section('content')
    <link href="{{ asset('assets/css/dashboard_modern.css') }}" rel="stylesheet">

    <div class="emp-card">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="emp-card-header">
                <span></span> My Leaves
            </div>
            <a href="{{ route('employee.leaves.create') }}" class="btn btn-primary">
                <i class="fe fe-plus"></i> Request Leave
            </a>
        </div>

        <!-- Leave Summary Cards -->
        <div class="row mb-5">
            @foreach($leaveSummary as $item)
            @if($item['allocated'] > 0 || $item['taken'] > 0)
            <div class="col-md-3 mb-3">
                <div class="card shadow-none border h-100 mb-0" style="border-radius: 12px; overflow: hidden;">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center mb-2">
                            <div class="bg-primary-transparent text-primary rounded-circle p-2 me-2" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                                <i class="fe fe-calendar fs-14"></i>
                            </div>
                            <h6 class="mb-0 fw-bold">{{ $item['type'] }}</h6>
                        </div>
                        <div class="row text-center mt-3">
                            <div class="col-4 border-end">
                                <small class="text-muted d-block">Allocated</small>
                                <span class="fw-bold">{{ $item['allocated'] }}</span>
                            </div>
                            <div class="col-4 border-end">
                                <small class="text-muted d-block">Taken</small>
                                <span class="fw-bold text-danger">{{ $item['taken'] }}</span>
                            </div>
                            <div class="col-4">
                                <small class="text-muted d-block">Balance</small>
                                <span class="fw-bold text-success">{{ $item['balance'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @endforeach
        </div>

        @if($leaveRequests->isEmpty())
            <div class="text-center py-5 text-muted">
                <div style="font-size:3rem; opacity: 0.3;"><i class="fe fe-calendar"></i></div>
                <p class="mt-3">You haven't submitted any leave requests yet.</p>
                <a href="{{ route('employee.leaves.create') }}" class="btn btn-sm btn-outline-primary mt-2">Submit Your First
                    Request</a>
            </div>
        @else
            <div class="table-responsive mt-5">
                <table class="table table-modern text-nowrap">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Type</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Days</th>
                            <th>Claim Salary</th>
                            <th>Document</th>
                            <th>Status</th>
                            <th>Remark</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($leaveRequests as $leave)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $leave->leaveType->name }}</td>
                                <td>{{ $leave->start_date->format('d M Y') }}</td>
                                <td>{{ $leave->end_date->format('d M Y') }}</td>
                                <td><span class="badge bg-light text-dark border">{{ $leave->duration_days }}</span></td>
                                <td>
                                    @if(isset($leave->claim_salary))
                                        <span class="badge bg-light text-dark border">{{ $leave->claim_salary ? 'Yes' : 'No' }}</span>
                                    @else
                                        <span class="badge bg-light text-dark border">No</span>
                                    @endif
                                </td>
                                <td>
                                    @if($leave->document)
                                        <a href="{{ asset('storage/' . $leave->document) }}" target="_blank"
                                            class="btn btn-sm btn-outline-info">
                                            <i class="fe fe-file"></i> View
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if($leave->status == 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @elseif($leave->status == 'approved')
                                        <span class="badge bg-success">Approved</span>
                                    @else
                                        <span class="badge bg-danger">Rejected</span>
                                    @endif
                                </td>
                                <td>
                                    @if($leave->admin_remark)
                                        <span class="text-muted"
                                            title="{{ $leave->admin_remark }}">{{ Str::limit($leave->admin_remark, 20) }}</span>
                                    @else
                                        <span class="text-muted small">No remark</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-4 py-3 border-top">
                {{ $leaveRequests->links() }}
            </div>
        @endif
    </div>
@endsection