@extends('employee.layouts.app')

@section('title', 'New WFH Request')
@section('page-title', 'New WFH Request')

@section('content')
<div class="card border-0 shadow-sm mt-3" style="max-width: 600px; margin: auto;">
    <div class="card-header bg-primary text-white border-0 py-3">
        <h5 class="mb-0 fw-bold text-white"><i class="fe fe-home me-2"></i> Submit WFH Request</h5>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('employee.wfh.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-bold">Date <span class="text-danger">*</span></label>
                <div class="position-relative">
                    <input type="text" name="date" class="form-control datepicker" required placeholder="DD-MM-YYYY">
                    <span class="date-icon" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; pointer-events: none;">
                        <i class="fe fe-calendar"></i>
                    </span>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Reason <span class="text-danger">*</span></label>
                <textarea name="reason" class="form-control" rows="3" required placeholder="Why do you need to work from home?"></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Additional Notes (Optional)</label>
                <textarea name="notes" class="form-control" rows="2" placeholder="Any extra information?"></textarea>
            </div>
            <div class="d-flex justify-content-end mt-4">
                <a href="{{ route('employee.wfh.index') }}" class="btn btn-light me-2">Cancel</a>
                <button type="submit" class="btn btn-primary"><i class="fe fe-send me-1"></i> Submit Request</button>
            </div>
        </form>
    </div>
</div>
@endsection
