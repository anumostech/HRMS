@extends('layouts.app')

@section('title', 'Add Employee')

@section('content')
<div class="page-header">
    <h1 class="page-title">Add Employee</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('employees.index') }}">Employees</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add Employee</li>
        </ol>
    </div>
</div>
<form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <!-- Basic Details -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Basic Details</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}">
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Designation</label>
                            <input type="text" class="form-control" name="designation" value="{{ old('designation') }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Department</label>
                            <div class="select-wrapper">
                                <select class="form-control @error('department_id') is-invalid @enderror" name="department_id" id="departmentSelect">
                                    <option value="">Select Department</option>
                                    @foreach($departments as $department)
                                    <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                                    @endforeach
                                    <option value="__new_department__" id="addDepartmentOption" class="text-center" style="background:#0D9C1E;color:#fff;">+ Add Department</option>
                                </select>
                            </div>
                            @error('department_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Company <span class="text-danger">*</span></label>
                            <div class="select-wrapper">
                                <select class="form-control @error('company_id') is-invalid @enderror" name="company_id" id="companySelect">
                                    <option value="">Select Company</option>
                                    @foreach($companies as $company)
                                    <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>{{ $company->name }}</option>
                                    @endforeach
                                    <option value="__new__" id="addCompanyOption" class="text-center" style="background:#0D9C1E;color:#fff;">+ Add Company</option>
                                </select>
                                @error('company_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Employee ID</label>
                            <input type="text" class="form-control @error('employee_id') is-invalid @enderror" name="employee_id" value="{{ old('employee_id') }}">
                            @error('employee_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Date of Birth</label>
                            <input type="text" class="form-control datepicker" name="dob" id="dob" value="{{ old('dob') }}" placeholder="Select Date">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Date of Joining</label>
                            <input type="text" class="form-control datepicker" name="joining_date" id="joining_date" value="{{ old('joining_date') }}" placeholder="Select Date">
                        </div>
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
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Special Days</label>

                            <div id="specialDaysWrapper">

                                <div class="row special-day-row mb-2">
                                    <div class="col-md-5">
                                        <input type="text" name="special_days_name[]" class="form-control mb-2" placeholder="Special Day Name (Birthday, Anniversary)">
                                    </div>

                                    <div class="col-md-5">
                                        <input type="text" name="special_days_date[]" class="form-control mb-2 datepicker" placeholder="Select Date">
                                    </div>

                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-success addSpecialDay mb-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="white" viewBox="0 0 16 16">
                                                <path d="M8 1a.5.5 0 0 1 .5.5V7.5H14.5a.5.5 0 0 1 0 1H8.5V14.5a.5.5 0 0 1-1 0V8.5H1.5a.5.5 0 0 1 0-1H7.5V1.5A.5.5 0 0 1 8 1z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Passport Details -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Passport Details</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Passport Full Name</label>
                            <input type="text" class="form-control" name="passport_full_name" value="{{ old('passport_full_name') }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Passport Number</label>
                            <input type="text" class="form-control" name="passport_number" value="{{ old('passport_number') }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Issued From</label>
                            <input type="text" class="form-control" name="passport_issued_from" value="{{ old('passport_issued_from') }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Passport Issued Date</label>
                            <input type="text" class="form-control datepicker" name="passport_issued_date" id="passport_issued_date" value="{{ old('passport_issued_date') }}" placeholder="Select Date">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Passport Expiry Date</label>
                            <input type="text" class="form-control datepicker" name="passport_expiry_date" id="passport_expiry_date" value="{{ old('passport_expiry_date') }}" placeholder="Select Date">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Place of Birth</label>
                            <input type="text" class="form-control" name="place_of_birth" value="{{ old('place_of_birth') }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Father's Name</label>
                            <input type="text" class="form-control" name="father_name" value="{{ old('father_name') }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Mother's Name</label>
                            <input type="text" class="form-control" name="mother_name" value="{{ old('mother_name') }}">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Address</label>
                            <textarea class="form-control" name="address" rows="2">{{ old('address') }}</textarea>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Passport 1st Page</label>
                            <input type="file" class="form-control document-upload" data-field="passport_1st_page" accept=".pdf,.jpg,.jpeg,.png">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Passport 2nd Page</label>
                            <input type="file" class="form-control document-upload" data-field="passport_2nd_page" accept=".pdf,.jpg,.jpeg,.png">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Outer Page</label>
                            <input type="file" class="form-control document-upload" data-field="passport_outer_page" accept=".pdf,.jpg,.jpeg,.png">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">ID Page</label>
                            <input type="file" class="form-control document-upload" data-field="passport_id_page" accept=".pdf,.jpg,.jpeg,.png">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Visa Details -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Visa Details</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Visa Number</label>
                            <input type="text" class="form-control" name="visa_number" value="{{ old('visa_number') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Issued Date</label>
                            <input type="text" class="form-control datepicker" name="visa_issued_date" id="visa_issued_date" value="{{ old('visa_issued_date') }}" placeholder="Select Date">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Expiry Date</label>
                            <input type="text" class="form-control datepicker" name="visa_expiry_date" id="visa_expiry_date" value="{{ old('visa_expiry_date') }}" placeholder="Select Date">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Attach Visa Page</label>
                            <input type="file" class="form-control document-upload" data-field="visa_page" accept=".pdf,.jpg,.jpeg,.png">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Labor Details -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Labor Details</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Labor Number</label>
                            <input type="text" class="form-control" name="labor_number" value="{{ old('labor_number') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Issued Date</label>
                            <input type="text" class="form-control datepicker" name="labor_issued_date" id="labor_issued_date" value="{{ old('labor_issued_date') }}" placeholder="Select Date">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Expiry Date</label>
                            <input type="text" class="form-control datepicker" name="labor_expiry_date" id="labor_expiry_date" value="{{ old('labor_expiry_date') }}" placeholder="Select Date">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Attach Labor Card</label>
                            <input type="file" class="form-control document-upload" data-field="labor_card" accept=".pdf,.jpg,.jpeg,.png">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- EID Details -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">EID Details</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">EID Number</label>
                            <input type="text" class="form-control" name="eid_number" value="{{ old('eid_number') }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Issued Date</label>
                            <input type="text" class="form-control datepicker" name="eid_issued_date" id="eid_issued_date" value="{{ old('eid_issued_date') }}" placeholder="Select Date">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Expiry Date</label>
                            <input type="text" class="form-control datepicker" name="eid_expiry_date" id="eid_expiry_date" value="{{ old('eid_expiry_date') }}" placeholder="Select Date">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Attach 1st Page</label>
                            <input type="file" class="form-control document-upload" data-field="eid_1st_page" accept=".pdf,.jpg,.jpeg,.png">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Attach 2nd Page</label>
                            <input type="file" class="form-control document-upload" data-field="eid_2nd_page" accept=".pdf,.jpg,.jpeg,.png">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Other Details -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Other Details</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Dependents (Yes/No)</label>
                            <div class="select-wrapper">
                                <select class="form-control" name="dependents">
                                    <option value="No" {{ old('dependents') == 'No' ? 'selected' : '' }}>No</option>
                                    <option value="Yes" {{ old('dependents') == 'Yes' ? 'selected' : '' }}>Yes</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Education 1st Page</label>
                            <input type="file" class="form-control document-upload" data-field="educational_1st_page" accept=".pdf,.jpg,.jpeg,.png">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Education 2nd Page</label>
                            <input type="file" class="form-control document-upload" data-field="educational_2nd_page" accept=".pdf,.jpg,.jpeg,.png">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Home Country ID Proof</label>
                            <input type="file" class="form-control document-upload" data-field="home_country_id_proof" accept=".pdf,.jpg,.jpeg,.png">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Company Mobile Number</label>
                            <input type="text" class="form-control" name="company_mobile_number" value="{{ old('company_mobile_number') }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Personal Number</label>
                            <input type="text" class="form-control" name="personal_number" value="{{ old('personal_number') }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Other Number</label>
                            <input type="text" class="form-control" name="other_number" value="{{ old('other_number') }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Home Country Number</label>
                            <input type="text" class="form-control" name="home_country_number" value="{{ old('home_country_number') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Company Email</label>
                            <input type="email" class="form-control" name="company_email" value="{{ old('company_email') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Personal Email</label>
                            <input type="email" class="form-control" name="personal_email" value="{{ old('personal_email') }}">
                        </div>
                        <input type="hidden" name="passport_1st_page">
                        <input type="hidden" name="passport_2nd_page">
                        <input type="hidden" name="passport_outer_page">
                        <input type="hidden" name="passport_id_page">
                        <input type="hidden" name="visa_page">
                        <input type="hidden" name="labor_card">
                        <input type="hidden" name="eid_1st_page">
                        <input type="hidden" name="eid_2nd_page">
                        <input type="hidden" name="educational_1st_page">
                        <input type="hidden" name="educational_2nd_page">
                        <input type="hidden" name="home_country_id_proof">
                    </div>
                </div>
                <div class="card-footer text-end">
                    <a href="{{ route('employees.index') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save Employee</button>
                </div>
            </div>
        </div>
    </div>
</form>
<div class="modal fade" id="createCompanyModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Add Company Name</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input type="text" id="newCompanyName" class="form-control" placeholder="Enter company name">
            </div>

            <div class="modal-footer">
                <button class="btn btn-default" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary" id="saveCompanyBtn">Create</button>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="createDepartmentModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Add Department Name</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input type="text" id="newDepartmentName" class="form-control" placeholder="Enter department name">
            </div>

            <div class="modal-footer">
                <button class="btn btn-default" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary" id="saveDepartmentBtn">Create</button>
            </div>

        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    $(document).on('click', '.addSpecialDay', function() {
        let html = `
            <div class="row special-day-row mb-2">

                <div class="col-md-5">
                    <input type="text" name="special_days_name[]" class="form-control" placeholder="Special Day Name">
                </div>

                <div class="col-md-5">
                    <input type="text" name="special_days_date[]" class="form-control datepicker" placeholder="Select Date">
                </div>

                <div class="col-md-2">
                    <button type="button" class="btn btn-danger removeSpecialDay">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="white" viewBox="0 0 16 16">
                            <path d="M1.5 8a.5.5 0 0 1 .5-.5h12a.5.5 0 0 1 0 1H2a.5.5 0 0 1-.5-.5z"/>
                        </svg>
                    </button>
                </div>

            </div>`;

        $('#specialDaysWrapper').append(html);

        // Reinitialize datepicker for new fields
        $('.datepicker').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true
        });
    });


    $(document).on('click', '.removeSpecialDay', function() {

        $(this).closest('.special-day-row').remove();

    });

    $(document).on('change', '.document-upload', function() {

        let file = this.files[0];
        let field = $(this).data('field');

        let formData = new FormData();
        formData.append('file', file);
        formData.append('field', field);
        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

        axios.post('{{ route("documents.uploadTempDocument") }}', formData)
            .then(function(response) {
                if (response.data.success == true) {
                    $("input[name='" + field + "']").val(response.data.path);

                    // Swal.fire({
                    //     toast: true,
                    //     position: 'top-end',
                    //     icon: 'success',
                    //     title: "Uploaded successfully",
                    //     showConfirmButton: false,
                    //     timer: 1500
                    // });
                }

            })
            .catch(function() {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: field + "uploading failed",
                    showConfirmButton: false,
                    timer: 1500
                });
            });

    });

    $('#companySelect').on('change', function() {

        if ($(this).val() === '__new__') {

            let modal = new bootstrap.Modal(document.getElementById('createCompanyModal'));
            modal.show();

        }

    });

    $('#saveCompanyBtn').click(function() {

        let companyName = $('#newCompanyName').val();

        if (!companyName) {
            alert("Company name is required");
            return;
        }

        $.ajax({
            url: "{{ route('companies.store') }}",
            type: "POST",
            data: {
                name: companyName,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {

                let newOption = `<option value="${response.company.id}">
                                ${response.company.name}
                             </option>`;

                $('#addCompanyOption').before(newOption);

                $('#companySelect').val(response.company.id).trigger('change');

                $('#newCompanyName').val('');

                bootstrap.Modal.getInstance(document.getElementById('createCompanyModal')).hide();

            }
        });

    });

    $('#createCompanyModal').on('hidden.bs.modal', function() {

        if ($('#companySelect').val() === '__new__') {
            $('#companySelect').val('');
        }

    });

     $('#departmentSelect').on('change', function() {

        if ($(this).val() === '__new_department__') {

            let modal = new bootstrap.Modal(document.getElementById('createDepartmentModal'));
            modal.show();
        }

    });

    $('#saveDepartmentBtn').click(function() {

        let departmentName = $('#newDepartmentName').val();

        if (!departmentName) {
            alert("Department name is required");
            return;
        }

        $.ajax({
            url: "{{ route('departments.store') }}",
            type: "POST",
            data: {
                name: departmentName,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {

                let newOption = `<option value="${response.department.id}">
                                ${response.department.name}
                             </option>`;

                $('#addDepartmentOption').before(newOption);

                $('#departmentSelect').val(response.department.id).trigger('change');

                $('#newDepartmentName').val('');

                bootstrap.Modal.getInstance(document.getElementById('createDepartmentModal')).hide();

            }
        });

    });

    $('#createDepartmentModal').on('hidden.bs.modal', function() {

        if ($('#departmentSelect').val() === '__new_department__') {
            $('#departmentSelect').val('');
        }

    });
</script>
@endsection