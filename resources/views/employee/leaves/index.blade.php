@extends('employee.layouts.app')

@section('title', 'My Leaves')
@section('page-title', '')

@section('content')
    <link href="{{ asset('assets/css/dashboard_modern.css') }}" rel="stylesheet">

    <div class="emp-card">
        <div class="d-flex justify-content-between align-items-center">
            <div class="emp-card-header">
                <span></span> My Leaves
            </div>
            <a href="{{ route('employee.leaves.create') }}" class="btn btn-primary">
                <i class="fe fe-plus"></i> Request Leave
            </a>
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