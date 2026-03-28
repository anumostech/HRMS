@extends('employee.layouts.app')

@section('title', 'My Profile')
@section('page-title', 'My Profile')

@section('content')

@if(session('success'))
<div class="alert-success-custom"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16" class="me-1">
  <path d="M13.485 1.929a.75.75 0 0 1 0 1.06l-7.07 7.071a.75.75 0 0 1-1.06 0L2.515 7.22a.75.75 0 1 1 1.06-1.06l2.22 2.22 6.54-6.54a.75.75 0 0 1 1.06 0z"/>
</svg>{{ session('success') }}</div>
@endif
@if(session('password_success'))
<div class="alert-success-custom"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16" class="me-1">
                            <path d="M8 1a3 3 0 0 0-3 3v3H4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-1V4a3 3 0 0 0-3-3zm-2 6V4a2 2 0 1 1 4 0v3H6zm-2 1h8a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1z"/>
                        </svg> {{ session('password_success') }}</div>
@endif

<div class="row g-4">

    {{-- Profile Photo & Info --}}
    <div class="col-md-4">
        <div class="emp-card text-center">
            <img src="{{ $employee->avatar_url }}" alt="Avatar"
                style="width:100px;height:100px;border-radius:50%;object-fit:cover;border:4px solid #e0e7ff;margin-bottom:1rem;">
            <h5 style="font-weight:700;color:#1a1a2e;">{{ $employee->name }}</h5>
            <p class="text-muted" style="font-size:0.875rem;">{{ $employee->designation ?? 'Employee' }}</p>
            @if($employee->department)
            <span class="badge" style="background:#eef2ff;color:#6366f1;border:1px solid #ddd6fe;">{{ $employee->department->name }}</span>
            @endif
            @if($employee->company)
            <div class="mt-2 text-muted" style="font-size:0.8rem;">{{ $employee->company->name }}</div>
            @endif

            <hr style="border-color:#f0f0f0;margin:1rem 0;">

            <div class="text-start" style="font-size:0.85rem;">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Employee ID</span>
                    <strong>{{ $employee->employee_id }}</strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Joined</span>
                    <strong>{{ $employee->joining_date ? \Carbon\Carbon::parse($employee->joining_date)->format('d M Y') : '—' }}</strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Gender</span>
                    <strong>{{ ucfirst($employee->gender ?? '—') }}</strong>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-muted">Status</span>
                    <span class="badge bg-success">{{ ucfirst($employee->status) }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Editable Info --}}
    <div class="col-md-8">

        {{-- Personal Info Form --}}
        <div class="emp-card mb-4">
            <div class="emp-card-header"><span></span> Edit Personal Info</div>
            <form method="POST" action="{{ route('employee.profile.update') }}" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Full Name</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $employee->name) }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Company Email <span class="text-muted">(read-only)</span></label>
                        <input type="email" class="form-control" value="{{ $employee->company_email }}" disabled>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Personal Email</label>
                        <input type="email" name="personal_email" class="form-control @error('personal_email') is-invalid @enderror"
                            value="{{ old('personal_email', $employee->personal_email) }}" placeholder="personal@email.com">
                        @error('personal_email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Personal Number</label>
                        <input type="text" name="personal_number" class="form-control @error('personal_number') is-invalid @enderror"
                            value="{{ old('personal_number', $employee->personal_number) }}" placeholder="+971 50 000 0000">
                        @error('personal_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Address</label>
                        <textarea name="address" class="form-control @error('address') is-invalid @enderror"
                            rows="2" placeholder="Your current address">{{ old('address', $employee->address) }}</textarea>
                        @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Profile Photo</label>
                        <input type="file" name="avatar" class="form-control @error('avatar') is-invalid @enderror"
                            accept="image/jpg,image/jpeg,image/png">
                        <small class="text-muted">JPG/PNG, max 2MB</small>
                        @error('avatar')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary px-4" style="border-radius:10px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16" class="me-1">
                            <path d="M2 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H9.5a1 1 0 0 0-1 1v7.293l2.646-2.647a.5.5 0 0 1 .708.708l-3.5 3.5a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L7.5 9.293V2a2 2 0 0 1 2-2H14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h2.5a.5.5 0 0 1 0 1H2z"/>
                        </svg>
                        Save Changes
                    </button>
                </div>
            </form>
        </div>

        {{-- Change Password --}}
        <div class="emp-card">
            <div class="emp-card-header"><span></span> Change Password</div>
            <form method="POST" action="{{ route('employee.profile.password') }}">
                @csrf
                <div class="row g-3">
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Current Password</label>
                        <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror"
                            placeholder="Enter current password">
                        @error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">New Password</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                            placeholder="Min. 8 characters">
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Confirm New Password</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Repeat new password">
                    </div>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-outline-danger px-4" style="border-radius:10px;">
                         <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16" class="me-1">
                            <path d="M8 1a3 3 0 0 0-3 3v3H4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-1V4a3 3 0 0 0-3-3zm-2 6V4a2 2 0 1 1 4 0v3H6zm-2 1h8a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1z"/>
                        </svg>
                        Update Password
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>

@endsection
