@extends('employee.layouts.app')

@section('title', 'Request Leave')
@section('page-title', '')

@section('content')
    <link href="{{ asset('assets/css/dashboard_modern.css') }}" rel="stylesheet">

    <div class="row g-3">
        <div class="col-md-8">
            <div class="emp-card">
                <div class="emp-card-header">
                    <span></span> Leave Application Form
                </div>

                @if($errors->has('error'))
                    <div class="alert alert-danger mx-3 mt-3">
                        <i class="fe fe-alert-circle me-1"></i> {{ $errors->first('error') }}
                    </div>
                @endif

                <form action="{{ route('employee.leaves.store') }}" method="POST" enctype="multipart/form-data" id="leaveForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="start_date">From Date <span class="text-danger">*</span></label>
                            <div class="position-relative">
                                <input type="text"
                                    class="form-control @error('start_date') is-invalid @enderror datepicker p-2"
                                    id="start_date" name="start_date" value="{{ old('start_date') }}"
                                    placeholder="Select from date" required min="{{ date('Y-m-d') }}">
                                <span class="date-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h1V.5a.5.5 0 0 1 .5-.5zM2 5v9h12V5H2z" />
                                    </svg>
                                </span>
                            </div>
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="end_date">To Date <span class="text-danger">*</span></label>
                            <div class="position-relative">
                                <input type="text"
                                    class="form-control @error('end_date') is-invalid @enderror datepicker p-2"
                                    id="end_date" name="end_date" value="{{ old('end_date') }}" placeholder="Select to date"
                                    required min="{{ date('Y-m-d') }}">
                                <span class="date-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h1V.5a.5.5 0 0 1 .5-.5zM2 5v9h12V5H2z" />
                                    </svg>
                                </span>
                            </div>
                            @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="leave_type_id">Leave Type <span
                                    class="text-danger">*</span></label>
                            <div class="select-wrapper">
                                <select class="form-control @error('leave_type_id') is-invalid @enderror" id="leave_type_id"
                                    name="leave_type_id" required>
                                    <option value="">Select Leave Type</option>
                                    @foreach($leaveTypes as $type)
                                        <option value="{{ $type->id }}" {{ old('leave_type_id') == $type->id ? 'selected' : '' }}>
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('leave_type_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6 mb-3" id="duration-section">
                            <label class="form-label" for="duration_days">Total Days</label>
                            <input type="text" class="form-control" id="duration_days" name="duration_days"
                                value="{{ old('duration_days', 0) }}" readonly>
                        </div>
                    </div>


                    <div id="sick-leave-extra" style="display: none;">
                        <div class="mb-3">
                            <label class="form-label" for="document">Upload Medical Certificate/Documents <span
                                    class="text-danger">*</span></label>
                            <input type="file" class="form-control @error('document') is-invalid @enderror" id="document"
                                name="document">
                            <small class="text-muted">Required for Sick Leave</small>
                            @error('document')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div id="claim-salary-section" style="display: none;">
                        <div class="mb-3">
                            <label class="form-label">Claim for Salary? <span class="text-danger">*</span></label>
                            <div class="d-flex gap-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="claim_salary" id="claim_yes"
                                        value="1" {{ old('claim_salary') == '1' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="claim_yes">Yes</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="claim_salary" id="claim_no" value="0"
                                        {{ old('claim_salary') == '0' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="claim_no">No</label>
                                </div>
                            </div>
                            @error('claim_salary')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="reason">Reason for Leave <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('reason') is-invalid @enderror" id="reason" name="reason"
                            rows="4" required
                            placeholder="Please describe your reason for requesting leave (min 10 characters)...">{{ old('reason') }}</textarea>
                        @error('reason')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mt-4 text-right">
                        <button type="submit" class="btn btn-primary px-5">Submit Request</button>
                        <a href="{{ route('employee.leaves.index') }}" class="btn btn-outline-secondary px-5">Cancel</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-4 h-100" style="border-top: 5px solid #6366f1 !important;">
                <div class="d-flex align-items-center mb-4">
                    <div class="bg-soft-indigo p-2 rounded-3 me-3">
                        <i class="fe fe-pocket text-indigo fs-4"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">Leave Balance</h5>
                        <p class="text-muted small mb-0">Current allocation</p>
                    </div>
                </div>

                <div class="text-center py-4 bg-light rounded-4 mb-4">
                    <h1 class="display-4 fw-bold text-indigo mb-0">{{ (int)$remainingBalance }}</h1>
                    <p class="text-muted text-uppercase small fw-bold mt-1">Days Remaining</p>
                </div>

                <div id="balance-warning" class="alert alert-soft-danger py-2 border-0 small" style="display:none;">
                    <i class="fe fe-alert-triangle me-1"></i> Requested days exceed your remaining balance.
                </div>

                <div class="mt-auto">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Allocated</span>
                        <span class="fw-bold text-dark">{{ auth('employee')->user()->total_leaves_allocated }} Days</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Taken / Pending</span>
                        <span class="fw-bold text-dark">{{ auth('employee')->user()->total_leaves_allocated - $remainingBalance }} Days</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .alert-soft-danger { background-color: rgba(239, 68, 68, 0.1); color: #b91c1c; }
        .bg-soft-indigo { background-color: rgba(99, 102, 241, 0.1); color: #6366f1; }
        .text-indigo { color: #6366f1; }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const leaveTypeSelect = document.getElementById('leave_type_id');
            const sickLeaveExtra = document.getElementById('sick-leave-extra');
            const claimSalarySection = document.getElementById('claim-salary-section');
            const documentInput = document.getElementById('document');

            const startDate = document.getElementById('start_date');
            const endDate = document.getElementById('end_date');
            const durationDays = document.getElementById('duration_days');

            function toggleFields() {
                const selectedValue = leaveTypeSelect.value;
                // Find selected option text
                const selectedOption = leaveTypeSelect.options[leaveTypeSelect.selectedIndex];
                const leaveTypeName = selectedOption ? selectedOption.text.trim().toLowerCase() : '';

                if (leaveTypeName.includes('sick')) {
                    sickLeaveExtra.style.display = 'block';
                    claimSalarySection.style.display = 'block';
                    documentInput.required = true;
                } else if (leaveTypeName.includes('annual')) {
                    sickLeaveExtra.style.display = 'none';
                    claimSalarySection.style.display = 'block';
                    documentInput.required = false;
                } else {
                    sickLeaveExtra.style.display = 'none';
                    claimSalarySection.style.display = 'none';
                    documentInput.required = false;
                }
            }

            const currentBalance = {{ (int)$remainingBalance }};
            const balanceWarning = document.getElementById('balance-warning');
            const submitBtn = document.querySelector('button[type="submit"]');

            function calculateDays() {
                if (startDate.value && endDate.value) {
                    const start = new Date(startDate.value);
                    const end = new Date(endDate.value);

                    if (end >= start) {
                        const diffTime = Math.abs(end - start);
                        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
                        durationDays.value = diffDays;
                        
                        if (currentBalance < diffDays) {
                            balanceWarning.style.display = 'block';
                            submitBtn.disabled = true;
                        } else {
                            balanceWarning.style.display = 'none';
                            submitBtn.disabled = false;
                        }
                    } else {
                        durationDays.value = 0;
                        balanceWarning.style.display = 'none';
                        submitBtn.disabled = true;
                    }
                }
            }

            leaveTypeSelect.addEventListener('change', toggleFields);
            startDate.addEventListener('change', calculateDays);
            endDate.addEventListener('change', calculateDays);

            // Initial trigger
            if (leaveTypeSelect.value) {
                toggleFields();
            }
            calculateDays();
        });
    </script>
    </div>
    </div>
    </div>
@endsection