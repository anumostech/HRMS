<div class="row">

    <!-- Passport Photo -->
    <!-- Full Name -->
    <div class="col-md-3 mb-3">
        <label class="form-label">First Name <span class="text-danger">*</span></label>
        <input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name"
            value="{{ old('first_name', $employee->first_name ?? '') }}" placeholder="Enter first name" required>
        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-3 mb-3">
        <label class="form-label">Last Name </label>
        <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name"
            value="{{ old('last_name', $employee->last_name ?? '') }}" placeholder="Enter last name">
        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <!-- Company -->
    <div class="col-md-3 mb-3">
        <label class="form-label">Company <span class="text-danger">*</span></label>
        <div class="select-wrapper">
            <select class="form-control @error('company_id') is-invalid @enderror" name="company_id" id="companySelect"
                required>
                <option value="">Select Company</option>
                @foreach($companies as $company)
                    <option value="{{ $company->id }}" {{ old('company_id', $employee->company_id) == $company->id ? 'selected' : '' }}>{{ $company->company_name }}</option>
                @endforeach
                <option value="__new__" id="addCompanyOption" class="text-center"
                    style="background:#0D9C1E;color:#fff;">+ Add Company</option>
            </select>
            @error('company_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>

    <!-- Department -->
    <div class="col-md-3 mb-3">
        <label class="form-label">Department <span class="text-danger">*</span></label>
        <div class="select-wrapper">
            <select class="form-control @error('department_id') is-invalid @enderror" name="department_id"
                id="departmentSelect" required>
                <option value="">Select Department</option>
                @foreach($departments as $department)
                    <option value="{{ $department->id }}" {{ old('department_id', $employee->department_id) == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                @endforeach
                <option value="__new_department__" id="addDepartmentOption" class="text-center"
                    style="background:#0D9C1E;color:#fff;">+ Add Department</option>
            </select>
            @error('department_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>

    <!-- Designation -->
    <div class="col-md-3 mb-3">
        <label class="form-label">Designation <span class="text-danger">*</span></label>
        <div class="select-wrapper">
            <select class="form-control @error('designation_id') is-invalid @enderror" name="designation_id"
                id="designationSelect" required>
                <option value="">Select Designation</option>
                @foreach($designations as $designation)
                    <option value="{{ $designation->id }}" {{ old('designation_id', $employee->designation_id) == $designation->id ? 'selected' : '' }}>{{ $designation->name }}</option>
                @endforeach
                <option value="__new_designation__" id="addDesignationOption" class="text-center"
                    style="background:#0D9C1E;color:#fff;">+ Add Designation</option>
            </select>
            @error('designation_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>

    <!-- Date of Joining -->
    <div class="col-md-3 mb-3">
        <label class="form-label">Date of Joining</label>
        <div class="position-relative">
            <input type="text" class="form-control datepicker" name="joining_date"
                value="{{ old('joining_date', isset($employee->joining_date) ? \Carbon\Carbon::parse($employee->joining_date)->format('d-m-Y') : '') }}"
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
            value="{{ old('employee_id', $employee->employee_id ?? '') }}" placeholder="Enter employee ID" required>
        @error('employee_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <!-- Date of Birth -->
    <div class="col-md-3 mb-3">
        <label class="form-label">Date of Birth</label>
        <div class="position-relative">
            <input type="text" class="form-control datepicker" name="dob"
                value="{{ old('dob', isset($employee->dob) ? \Carbon\Carbon::parse($employee->dob)->format('d-m-Y') : '') }}"
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
    <div class="col-md-4 mb-3">
        <label class="form-label">Gender</label>
        <div class="select-wrapper">
            <select class="form-control" name="gender">
                <option value="">Select Gender</option>
                <option value="Male" {{ old('gender', $employee->gender ?? '') == 'Male' ? 'selected' : '' }}>Male
                </option>
                <option value="Female" {{ old('gender', $employee->gender ?? '') == 'Female' ? 'selected' : '' }}>Female
                </option>
                <option value="Other" {{ old('gender', $employee->gender ?? '') == 'Other' ? 'selected' : '' }}>Other
                </option>
            </select>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Nationality</label>
        <input type="text" class="form-control @error('nationality') is-invalid @enderror" name="nationality"
            value="{{ old('nationality', $employee->nationality ?? '') }}" placeholder="Enter nationality">
        @error('nationality') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Marital Status</label>
        <div class="select-wrapper">
            <select class="form-control" name="marital_status">
                <option value="">Select Marital Status</option>
                <option value="Single" {{ old('marital_status', $employee->marital_status ?? '') == 'Single' ? 'selected' : '' }}>Single
                </option>
                <option value="Married" {{ old('marital_status', $employee->marital_status ?? '') == 'Married' ? 'selected' : '' }}>Married
                </option>
                <option value="Divorced" {{ old('marital_status', $employee->marital_status ?? '') == 'Divorced' ? 'selected' : '' }}>Divorced
                </option>
                <option value="Widowed" {{ old('marital_status', $employee->marital_status ?? '') == 'Widowed' ? 'selected' : '' }}>Widowed
                </option>
            </select>
        </div>
    </div>
    



    <!-- Special Days -->
    <div class="col-md-12 mb-3">
        <label class="form-label">Special Days</label>

        <div id="specialDaysWrapper">
            @if(isset($employee) && !empty($employee->special_days))
                @foreach($employee->special_days as $index => $day)
                    <div class="row special-day-row mb-2">
                        <div class="col-md-5">
                            <input type="text" name="special_days_name[]" class="form-control" value="{{ $day['name'] }}"
                                placeholder="e.g. Birthday / Anniversary">
                        </div>

                        <div class="col-md-5">
                            <div class="position-relative">
                                <input type="text" name="special_days_date[]" class="form-control datepicker"
                                    value="{{ $day['date'] ? \Carbon\Carbon::parse($day['date'])->format('d-m-Y') : '' }}"
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
                            @if($loop->first)
                                <button type="button" class="btn btn-success addSpecialDay">+</button>
                            @else
                                <button type="button" class="btn btn-danger removeSpecialDay">-</button>
                            @endif
                        </div>
                    </div>
                @endforeach
            @else
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
            @endif
        </div>
    </div>
    <div class="col-md-12 mb-4">
        <label class="form-label fw-semibold">Passport Size Photo</label>
        <div class="d-flex align-items-center gap-4">
            <!-- Preview -->
            <div id="photoPreviewWrapper"
                style="width:110px;height:130px;border:2px dashed #ccc;border-radius:8px;overflow:hidden;display:flex;align-items:center;justify-content:center;background:#f8f9fa;flex-shrink:0;">
                @if(!empty($employee->avatar))
                    <img id="photoPreview" src="{{ asset('storage/' . $employee->avatar) }}"
                        style="width:100%;height:100%;object-fit:cover;" alt="Photo">
                @else
                    <img id="photoPreview" src="" style="width:100%;height:100%;object-fit:cover;display:none;" alt="Photo">
                    <span id="photoPlaceholder" style="color:#aaa;font-size:12px;text-align:center;padding:8px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#ccc" viewBox="0 0 16 16">
                            <path
                                d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.029 10 8 10c-2.029 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z" />
                        </svg>
                        <br>Photo
                    </span>
                @endif
            </div>
            <!-- Upload Controls -->
            <div>
                <label class="btn btn-outline-primary btn-sm mb-1" for="avatarUpload">
                    <i class="fe fe-upload me-1"></i> Upload Photo
                </label>
                <input type="file" id="avatarUpload" class="d-none document-upload" accept="image/*"
                    data-field="avatar">
                <input type="hidden" name="avatar" id="avatarPath" value="{{ old('avatar', $employee->avatar ?? '') }}">
                <div class="text-muted" style="font-size:12px;">
                    Accepted: JPG, PNG, GIF. Max 2MB.<br>
                    Recommended size: 35mm × 45mm (passport size).
                </div>
                @if(!empty($employee->avatar))
                    <a href="{{ asset('storage/' . $employee->avatar) }}" target="_blank"
                        class="btn btn-outline-secondary btn-sm mt-1">
                        <i class="fe fe-eye me-1"></i> View Current
                    </a>
                @endif
            </div>
        </div>
    </div>

</div>