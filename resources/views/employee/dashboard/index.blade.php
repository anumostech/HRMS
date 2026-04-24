@extends('employee.layouts.app')

@section('title', 'My Dashboard')
@section('page-title', 'My Dashboard')

@push('styles')
    <link href="{{ asset('assets/css/dashboard_modern.css') }}" rel="stylesheet">
@endpush

@section('content')

    {{-- Welcome & Quick Info --}}
    <div class="row g-3 mb-4">
        <div class="col-sm-12 col-md-8">
            <div class="dashboard-hero mb-0 h-100">
                <div class="d-flex align-items-center gap-4 position-relative" style="z-index: 2;">
                    <img src="{{ $employee->avatar_url }}" alt="Avatar"
                        style="width:80px;height:80px;border-radius:20px;border:4px solid rgba(255,255,255,0.2);object-fit:cover;box-shadow: 0 8px 16px rgba(0,0,0,0.2);">
                    <div>
                        <h2 class="mb-1 fw-bold">Welcome, {{ $employee->first_name . ' ' . $employee?->last_name}}!</h2>
                        <p class="mb-0 opacity-75 fs-6">
                            <i class="fe fe-briefcase me-1"></i> {{ $employee->designation?->name ?? 'Team Member' }}
                            <span class="mx-2">|</span>
                            <i class="fe fe-layers me-1"></i> {{ optional($employee->department)->name ?? 'General' }}
                        </p>
                    </div>
                    <div class="ms-auto d-none d-md-block text-end">
                        <div class="fs-4 fw-bold">{{ now()->format('h:i A') }}</div>
                        <div class="opacity-75 small mb-2">{{ now()->format('l, d M Y') }}</div>
                        @if($canPunch)
                            @if(!$todayLog || !$todayLog->punch_in)
                                <form action="{{ route('employee.punch.in') }}" method="POST">
                                    @csrf
                                    <button class="btn btn-success rounded-pill px-4 shadow-sm"><i class="fe fe-log-in me-1"></i>
                                        Punch In</button>
                                </form>
                            @elseif(!$todayLog->punch_out)
                                <button type="button" class="btn btn-danger rounded-pill px-4 shadow-sm" data-bs-toggle="modal"
                                    data-bs-target="#punchOutModal">
                                    <i class="fe fe-log-out me-1"></i> Punch Out
                                </button>
                            @else
                                <button class="btn btn-secondary rounded-pill px-4 shadow-sm" disabled><i
                                        class="fe fe-check-circle me-1"></i> Punched Out</button>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-sm-6">
            <div class="card stat-card h-100 border-0 shadow-sm p-4 text-center">
                <div class="stat-icon bg-soft-success mx-auto mb-3">
                    <i class="fe fe-log-in"></i>
                </div>
                <div class="text-muted small text-uppercase fw-bold mb-1" style="letter-spacing: 0.5px;">Punch In</div>
                <div class="h4 mb-0 fw-bold text-dark">
                    {{ $todayLog && $todayLog->punch_in ? \Carbon\Carbon::parse($todayLog->punch_in)->format('h:i A') : '00:00' }}
                </div>
            </div>
        </div>
        <div class="col-md-2 col-sm-6">
            <div class="card stat-card h-100 border-0 shadow-sm p-4 text-center">
                <div class="stat-icon bg-soft-danger mx-auto mb-3">
                    <i class="fe fe-log-out"></i>
                </div>
                <div class="text-muted small text-uppercase fw-bold mb-1" style="letter-spacing: 0.5px;">Punch Out</div>
                <div class="h4 mb-0 fw-bold text-dark">
                    {{ $todayLog && $todayLog->punch_out ? \Carbon\Carbon::parse($todayLog->punch_out)->format('h:i A') : '00:00' }}
                </div>
            </div>
        </div>
    </div>

    {{-- Today's Status & Leave Info --}}
    <div class="row g-4 mb-4">
        <div class="col-md-4 col-sm-12">
            <div class="card stat-card h-100 border-0 shadow-sm p-4 text-center" style="border-bottom: 4px solid var(--hr-primary) !important;">
                <div class="stat-icon bg-soft-primary mx-auto mb-3">
                    <i class="fe fe-calendar text-info"></i>
                </div>
                <div class="text-muted small text-uppercase fw-bold mb-1" style="letter-spacing: 0.5px;">Working Days</div>
                <div class="h3 mb-0 fw-bold text-dark">
                    {{ $attendanceLogs->count() }} 
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="card stat-card h-100 border-0 shadow-sm p-4 text-center" style="border-bottom: 4px solid var(--hr-primary) !important;">
                <div class="stat-icon bg-soft-warning mx-auto mb-3">
                    <i class="fe fe-user-x"></i>
                </div>
                <div class="text-muted small text-uppercase fw-bold mb-1" style="letter-spacing: 0.5px;">Leaves Taken</div>
                <div class="h3 mb-0 fw-bold text-dark">
                    {{ (int) $totalLeavesTaken }} 
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="card stat-card h-100 border-0 shadow-sm p-4 text-center"
                style="border-bottom: 4px solid var(--hr-primary) !important;">
                <div class="stat-icon bg-soft-info mx-auto mb-3">
                    <i class="fe fe-pocket"></i>
                </div>
                <div class="text-muted small text-uppercase fw-bold mb-1" style="letter-spacing: 0.5px;">Leave Balance</div>
                <div class="h3 mb-0 fw-bold text-dark">
                    {{ (int) max(0, $leaveBalance) }} 
                </div>
            </div>
        </div>
    </div>

    {{-- Attendance History --}}
    <div class="card border-0 shadow-sm mb-4 overflow-hidden" style="border-radius: 20px;">
        <div class="card-header bg-white border-0 py-4 px-4">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <div class="bg-soft-primary p-3 rounded-4 me-3">
                        <i class="fe fe-activity text-primary fs-4"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">Recent Attendance</h5>
                        <p class="text-muted small mb-0">Track your logs for the last 30 days</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if($attendanceLogs->isEmpty())
                <div class="text-center py-5 text-muted">
                    <div style="font-size:3rem;" class="opacity-25 mb-3"><i class="fe fe-calendar"></i></div>
                    <p class="mb-0 fw-medium">No attendance records found.</p>
                    <p class="small text-muted">Your logs will appear here once you punch in.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 datatable-basic">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 border-0">Date & Day</th>
                                <th class="border-0">Punch In</th>
                                <th class="border-0">Punch Out</th>
                                <th class="border-0">Duration</th>
                                <th class="pe-4 text-end border-0">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($attendanceLogs as $log)
                                @php
                                    $punchInTime = $log->punch_in ? \Carbon\Carbon::parse($log->punch_in) : null;
                                    $punchOutTime = $log->punch_out ? \Carbon\Carbon::parse($log->punch_out) : null;
                                    $isLate = $punchInTime && $punchInTime->format('H:i:s') >= '08:11:00' && $punchInTime->format('H:i:s') <= '12:00:00';

                                    $duration = '—';
                                    if ($punchInTime && $punchOutTime) {
                                        $diff = $punchInTime->diff($punchOutTime);
                                        $duration = $diff->h . 'h ' . $diff->i . 'm';
                                    }
                                    $dateObj = \Carbon\Carbon::parse($log->log_date);
                                @endphp
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold text-dark">{{ $dateObj->format('d M, Y') }}</div>
                                        <div class="text-muted small">{{ $dateObj->format('l') }}</div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="dot bg-success me-2"></div>
                                            <span class="fw-medium text-dark">{{ $punchInTime ? $punchInTime->format('h:i A') : '—' }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="dot bg-danger me-2"></div>
                                            <span class="fw-medium text-dark">{{ $punchOutTime ? $punchOutTime->format('h:i A') : '—' }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark fw-bold px-3 py-2" style="border-radius: 8px;">{{ $duration }}</span>
                                    </td>
                                    <td class="pe-4 text-end">
                                        @if($isLate)
                                            <span class="badge badge-soft-warning px-3 py-2 rounded-pill fw-bold">Latecomer</span>
                                        @elseif($punchInTime)
                                            <span class="badge badge-soft-success px-3 py-2 rounded-pill fw-bold">Present</span>
                                        @else
                                            <span class="badge badge-soft-danger px-3 py-2 rounded-pill fw-bold">Absent</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <style>
        .dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }

        .badge-soft-warning {
            background-color: rgba(245, 158, 11, 0.1);
            color: #d97706;
        }

        .badge-soft-success {
            background-color: rgba(34, 197, 94, 0.1);
            color: #15803d;
        }

        .badge-soft-danger {
            background-color: rgba(239, 68, 68, 0.1);
            color: #b91c1c;
        }

        .table-modern thead th {
            border-bottom: 1px solid #f1f5f9;
        }

        .bg-soft-info {
            background-color: rgba(6, 182, 212, 0.1);
            color: #0891b2;
        }

        .text-info {
            color: #0891b2;
        }
        
        .stat-card {
            border-radius: 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
        }
        
        .stat-icon {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 15px;
            font-size: 1.25rem;
        }
    </style>

    {{-- Punch Out Modal --}}
    <div class="modal fade" id="punchOutModal" tabindex="-1" aria-labelledby="punchOutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                <form action="{{ route('employee.punch.out') }}" method="POST">
                    @csrf
                    <div class="modal-header bg-danger text-white border-0 py-4 px-4" style="border-radius: 20px 20px 0 0;">
                        <h5 class="modal-title fw-bold" id="punchOutModalLabel"><i class="fe fe-activity me-2"></i> Daily Task Report</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-uppercase">Tasks Completed Today <span class="text-danger">*</span></label>
                            <textarea name="tasks_completed" class="form-control border-0 bg-light" rows="3" required
                                placeholder="What have you achieved today?" style="border-radius: 12px;"></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-uppercase">Plan for Tomorrow <span class="text-danger">*</span></label>
                            <textarea name="plan_tomorrow" class="form-control border-0 bg-light" rows="3" required
                                placeholder="What's on your list for next shift?" style="border-radius: 12px;"></textarea>
                        </div>
                        <div class="mb-0">
                            <label class="form-label fw-bold small text-uppercase">Final Remarks</label>
                            <textarea name="remarks" class="form-control border-0 bg-light" rows="2"
                                placeholder="Any additional notes?" style="border-radius: 12px;"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-0">
                        <button type="button" class="btn btn-light px-4 rounded-pill" data-bs-dismiss="modal">Stay Punched In</button>
                        <button type="submit" class="btn btn-danger px-4 rounded-pill shadow-sm fw-bold">Punch Out & Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
