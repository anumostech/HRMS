@extends('layouts.app')

@section('title', 'Attendance Report')

@section('content')
<div class="row w-100">
    <div class="col-lg-12 mx-auto">
        <div class="page-header" style="display:inline">
            <h1 class="page-title mb-2">Attendance Report</h1>
            <div class="ms-auto">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('reports.index') }}">Reports</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Attendance</li>
                </ol>
            </div>
        </div>

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <form action="{{ route('reports.attendance') }}" method="GET" class="row align-items-end g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold small text-muted text-uppercase">Start Date</label>
                        <input type="text" name="start_date" class="form-control datepicker" value="{{ $startDate }}" placeholder="DD-MM-YYYY">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold small text-muted text-uppercase">End Date</label>
                        <input type="text" name="end_date" class="form-control datepicker" value="{{ $endDate }}" placeholder="DD-MM-YYYY">
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary w-100"><i class="fe fe-filter me-2"></i> Filter Logs</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 datatable-basic">
                        <thead class="bg-light">
                            <tr>
                                <th>Date</th>
                                <th>Employee</th>
                                <th>Punch In</th>
                                <th>Punch Out</th>
                                <th>Duration</th>
                                <th>Latecomer</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($logs as $log)
                            @php
                                $inTime = $log->punch_in ? \Carbon\Carbon::parse($log->punch_in) : null;
                                $outTime = $log->punch_out ? \Carbon\Carbon::parse($log->punch_out) : null;
                                $duration = '—';
                                if($inTime && $outTime) {
                                    $diff = $inTime->diff($outTime);
                                    $duration = $diff->format('%hh %im');
                                }
                                $isLate = $inTime && $inTime->format('H:i') > '08:10';
                            @endphp
                            <tr>
                                <td class="fw-bold">{{ \Carbon\Carbon::parse($log->log_date)->format('d M Y') }}</td>
                                <td>
                                    <div class="fw-bold">{{ $log->user->first_name ?? 'Unknown' }} {{ $log->user->last_name ?? '' }}</div>
                                </td>
                                <td>{{ $inTime ? $inTime->format('h:i A') : '—' }}</td>
                                <td>{{ $outTime ? $outTime->format('h:i A') : '—' }}</td>
                                <td><span class="badge bg-light text-dark fw-normal">{{ $duration }}</span></td>
                                <td>
                                    @if($isLate)
                                        <span class="badge bg-soft-warning text-warning px-3 rounded-pill border-0">Yes</span>
                                    @else
                                        <span class="badge bg-soft-success text-success px-3 rounded-pill border-0">No</span>
                                    @endif
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
    .bg-soft-warning { background: rgba(245, 158, 11, 0.1); color: #f59e0b; }
    .bg-soft-success { background: rgba(34, 197, 94, 0.1); color: #22c55e; }
</style>
@endsection
