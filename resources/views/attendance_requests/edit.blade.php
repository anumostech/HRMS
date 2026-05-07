@extends('layouts.app')

@section('title', 'Edit Attendance Request')

@section('content')
<div class="page-header" style="display:inline;">
    <h1 class="page-title mb-2">Edit Attendance Request</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('attendance_requests.index') }}">Attendance Requests</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-md-8 col-lg-6 mx-auto">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-bottom-0 pt-4">
                <h3 class="card-title fw-bold">Modify Request Details</h3>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('attendance_requests.update', $attendanceRequest) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label text-muted small text-uppercase fw-bold">Employee</label>
                        <div class="d-flex align-items-center p-3 bg-light rounded-3">
                            @if($attendanceRequest->employee->avatar)
                                <img src="{{ asset('storage/' . $attendanceRequest->employee->avatar) }}" class="avatar avatar-md rounded-circle me-3">
                            @else
                                <div style="width:40px;height:40px;border-radius:25px;background:#d3ebd1d6;display:flex;align-items:center;justify-content:center;font-weight:600;color:#568f3f;margin-right:1rem;">
                                    {{ strtoupper(substr($attendanceRequest->employee->first_name,0,1)) }}{{ strtoupper(substr($attendanceRequest->employee->last_name ?? '',0,1)) }}
                                </div>
                            @endif
                            <span class="fw-bold text-dark">{{ $attendanceRequest->employee->first_name }} {{ $attendanceRequest->employee->last_name }}</span>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label text-muted small text-uppercase fw-bold">Request Type</label>
                        <input type="text" class="form-control bg-light border-0" value="{{ ucwords(str_replace('_', ' ', $attendanceRequest->type)) }}" readonly>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-muted small text-uppercase fw-bold">Request Date <span class="text-danger">*</span></label>
                        <div class="position-relative">
                            <input type="text" name="request_date" class="form-control datepicker" value="{{ \Carbon\Carbon::parse($attendanceRequest->request_date)->format('d-m-Y') }}" required>
                            <span class="date-icon" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; pointer-events: none;">
                                <i class="fe fe-calendar"></i>
                            </span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-muted small text-uppercase fw-bold">Request Time <span class="text-danger">*</span></label>
                        <input type="time" name="request_time" class="form-control" value="{{ \Carbon\Carbon::parse($attendanceRequest->request_time)->format('H:i') }}" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-muted small text-uppercase fw-bold">Reason <span class="text-danger">*</span></label>
                        <textarea name="reason" class="form-control" rows="4" required placeholder="Describe the reason for the exception...">{{ $attendanceRequest->reason }}</textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-5">
                        <a href="{{ route('attendance_requests.index') }}" class="btn btn-light px-4">Cancel</a>
                        <button type="submit" class="btn btn-primary px-4">Update Request</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
