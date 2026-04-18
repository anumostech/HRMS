@extends('layouts.app')

@section('title', $title)

@section('content')
<div class="row w-100">
    <div class="col-lg-12 mx-auto">
        <div class="page-header mt-4 mb-4">
            <h1 class="page-title text-primary"><i class="fe fe-user-minus"></i> {{ $title }}</h1>
            <div class="ms-auto">
                <ol class="breadcrumb">
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
                                <th>Request Date</th>
                                <th>Employee</th>
                                <th>Leave Type</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Days</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($leaves as $leave)
                            <tr>
                                <td class="fw-bold">{{ $leave->created_at->format('d M Y') }}</td>
                                <td>
                                    <div class="fw-bold">{{ $leave->employee->first_name ?? 'N/A' }} {{ $leave->employee->last_name ?? '' }}</div>
                                </td>
                                <td>{{ $leave->leaveType->name ?? 'N/A' }}</td>
                                <td>{{ \Carbon\Carbon::parse($leave->start_date)->format('d M Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($leave->end_date)->format('d M Y') }}</td>
                                <td><span class="badge bg-light text-dark border-0">{{ $leave->duration_days }}</span></td>
                                <td>
                                    @if($leave->status == 'pending')
                                        <span class="badge bg-warning text-dark px-3 rounded-pill border-0">Pending</span>
                                    @elseif($leave->status == 'approved')
                                        <span class="badge bg-success px-3 rounded-pill border-0">Approved</span>
                                    @else
                                        <span class="badge bg-danger px-3 rounded-pill border-0">Rejected</span>
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
@endsection
