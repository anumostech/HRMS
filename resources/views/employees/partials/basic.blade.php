<div class="row">

    <!-- Full Name -->
    <div class="col-md-3 mb-3">
        <label class="form-label">Full Name <span class="text-danger">*</span></label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
            value="{{ old('name') }}" placeholder="Enter full name" required>
        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <!-- Organization -->
    <div class="col-md-3 mb-3">
        <label class="form-label">Organization</label>
        <input type="text" class="form-control" name="organization" value="{{ old('organization') }}"
            placeholder="Enter organization name">
    </div>

    <!-- Company -->
    <div class="col-md-3 mb-3">
        <label class="form-label">Company <span class="text-danger">*</span></label>
        <div class="select-wrapper">
            <select class="form-control @error('company_id') is-invalid @enderror" name="company_id" required>
                <option value="">Select Company</option>
                @foreach($companies as $company)
                    <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
                        {{ $company->name }}
                    </option>
                @endforeach
            </select>
            @error('company_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>

    <!-- Department -->
    <div class="col-md-3 mb-3">
        <label class="form-label">Department</label>
        <div class="select-wrapper">
            <select class="form-control @error('department_id') is-invalid @enderror" name="department_id">
                <option value="">Select Department</option>
                @foreach($departments as $department)
                    <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                        {{ $department->name }}
                    </option>
                @endforeach
            </select>
            @error('department_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>

    <!-- Designation -->
    <div class="col-md-3 mb-3">
        <label class="form-label">Designation</label>
        <input type="text" class="form-control" name="designation" value="{{ old('designation') }}"
            placeholder="Enter designation">
    </div>

    <!-- Date of Joining -->
    <div class="col-md-3 mb-3">
        <label class="form-label">Date of Joining</label>
        <div class="position-relative">
            <input type="text" class="form-control datepicker" name="joining_date" value="{{ old('joining_date') }}"
                placeholder="Select joining date">
            <span class="date-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path
                        d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h1V.5a.5.5 0 0 1 .5-.5zM2 5v9h12V5H2z" />
                </svg>
            </span>
        </div>
    </div>

    <!-- Employee ID -->
    <div class="col-md-3 mb-3">
        <label class="form-label">Employee ID</label>
        <input type="text" class="form-control @error('employee_id') is-invalid @enderror" name="employee_id"
            value="{{ old('employee_id') }}" placeholder="Enter employee ID">
        @error('employee_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <!-- Date of Birth -->
    <div class="col-md-3 mb-3">
        <label class="form-label">Date of Birth</label>
        <div class="position-relative">
            <input type="text" class="form-control datepicker" name="dob" value="{{ old('dob') }}"
                placeholder="Select date of birth">
            <span class="date-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path
                        d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h1V.5a.5.5 0 0 1 .5-.5zM2 5v9h12V5H2z" />
                </svg>
            </span>
        </div>
    </div>

    <!-- Gender -->
    <div class="col-md-3 mb-3">
        <label class="form-label">Gender</label>
        <div class="select-wrapper">
            <select class="form-control" name="gender">
                <option value="">Select Gender</option>
                <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
            </select>
        </div>
    </div>

    <!-- Leave Allocation -->
    <div class="col-md-3 mb-3">
        <label class="form-label">Leave Allocation (Days)</label>
        <input type="number" class="form-control @error('total_leaves_allocated') is-invalid @enderror" 
            name="total_leaves_allocated" value="{{ old('total_leaves_allocated', $employee->total_leaves_allocated ?? 0) }}" 
            placeholder="Enter total days">
        @error('total_leaves_allocated') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <!-- Special Days -->
    <div class="col-md-12 mb-3">
        <label class="form-label">Special Days</label>

        <div id="specialDaysWrapper">
            <div class="row special-day-row mb-2">
                <div class="col-md-5">
                    <input type="text" name="special_days_name[]" class="form-control"
                        placeholder="e.g. Birthday / Anniversary">
                </div>

                <div class="col-md-5">
                    <div class="position-relative">
                        <input type="text" name="special_days_date[]" class="form-control datepicker"
                            placeholder="Select date">
                        <span class="date-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                viewBox="0 0 16 16">
                                <path
                                    d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h1V.5a.5.5 0 0 1 .5-.5zM2 5v9h12V5H2z" />
                            </svg>
                        </span>
                    </div>
                </div>

                <div class="col-md-2">
                    <button type="button" class="btn btn-success addSpecialDay">+</button>
                </div>
            </div>
        </div>
    </div>

</div>