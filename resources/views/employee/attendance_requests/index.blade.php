@extends('employee.layouts.app')

@section('title', 'My Attendance Requests')
@section('page-title', 'My Attendance Requests')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between">
                            <h5 class="mb-0 fw-bold">Request History</h5>
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="fe fe-plus me-1"></i> New Request
                                </button>
                                <ul class="dropdown-menu shadow border-0">
                                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                            data-bs-target="#exceptionModal" data-type="early_check_in">Early Check-in</a>
                                    </li>
                                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                            data-bs-target="#exceptionModal" data-type="late_check_in">Late Check-in</a>
                                    </li>
                                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                            data-bs-target="#exceptionModal" data-type="missed_punch_in">Missed Punch In</a>
                                    </li>
                                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                            data-bs-target="#exceptionModal" data-type="missed_punch_out">Missed Punch
                                            Out</a></li>
                                </ul>
                            </div>
                    </div>
                    <div class="card-body">
                        @if(!$requests->isEmpty())
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0 datatable-basic">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="ps-4">Type</th>
                                            <th>Date</th>
                                            <th>Requested Time</th>
                                            <th>Reason</th>
                                            <th>Status</th>
                                            <th class="pe-4 text-end">Submitted</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($requests as $request)
                                            <tr>
                                                <td class="ps-4">
                                                    <div class="d-flex align-items-center">
                                                        @php
                                                            $iconClass = 'bg-soft-primary text-primary';
                                                            switch ($request->type) {
                                                                case 'early_check_in':
                                                                    $iconClass = 'bg-soft-success text-success';
                                                                    break;
                                                                case 'late_check_in':
                                                                    $iconClass = 'bg-soft-warning text-warning';
                                                                    break;
                                                                case 'missed_punch_in':
                                                                    $iconClass = 'bg-soft-danger text-danger';
                                                                    break;
                                                                case 'missed_punch_out':
                                                                    $iconClass = 'bg-soft-info text-info';
                                                                    break;
                                                            }
                                                        @endphp
                                                        <div class="p-2 rounded-3 {{ $iconClass }} me-3"
                                                            style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">
                                                            <i
                                                                class="fe fe-{{ $request->type == 'early_check_in' || $request->type == 'late_check_in' ? 'clock' : 'arrow-down-circle' }}"></i>
                                                        </div>
                                                        <span
                                                            class="fw-semibold">{{ ucwords(str_replace('_', ' ', $request->type)) }}</span>
                                                    </div>
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($request->request_date)->format('d M, Y') }}</td>
                                                <td>{{ \Carbon\Carbon::parse($request->request_time)->format('h:i A') }}</td>
                                                <td>
                                                    <span class="text-muted small" title="{{ $request->reason }}">
                                                        {{ Str::limit($request->reason, 30) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if($request->status == 'pending')
                                                        <span
                                                            class="badge bg-soft-warning text-warning px-3 rounded-pill">Pending</span>
                                                    @elseif($request->status == 'approved')
                                                        <span
                                                            class="badge bg-soft-success text-success px-3 rounded-pill">Approved</span>
                                                    @else
                                                        <span class="badge bg-soft-danger text-danger px-3 rounded-pill">Rejected</span>
                                                    @endif
                                                </td>
                                                <td class="pe-4 text-end small text-muted">
                                                    {{ $request->created_at->diffForHumans() }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fe fe-file-text display-4 text-muted opacity-25"></i>
                                <p class="mt-3 text-muted">No attendance requests found.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .bg-soft-primary {
            background: rgba(99, 102, 241, 0.1);
        }

        .bg-soft-success {
            background: rgba(34, 197, 94, 0.1);
        }

        .bg-soft-warning {
            background: rgba(245, 158, 11, 0.1);
        }

        .bg-soft-danger {
            background: rgba(239, 68, 68, 0.1);
        }

        .bg-soft-info {
            background: rgba(6, 182, 212, 0.1);
        }
    </style>
@endsection