<?php
$content = file_get_contents('c:/Mostech/attendanceapp/resources/views/employees/create.blade.php');

// 1. CSS
$css = <<<CSS
<style>
    .wizard-steps { display: flex; justify-content: space-between; margin-bottom: 2rem; position: relative; }
    .wizard-steps::before { content: ""; position: absolute; top: 18px; left: 0; right: 0; background: #e5e7eb; height: 3px; z-index: 1; }
    .wizard-step-indicator { position: relative; z-index: 2; text-align: center; flex: 1; opacity: 0.5; transition: opacity 0.3s; }
    .wizard-step-indicator.active, .wizard-step-indicator.completed { opacity: 1; }
    .step-number { width: 40px; height: 40px; background: #e5e7eb; color: #6b7280; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 0.5rem; font-weight: 700; border: 3px solid #fff; transition: all 0.3s; }
    .wizard-step-indicator.active .step-number { background: #0D9C1E; color: #fff; border-color: #0D9C1E; box-shadow: 0 0 0 3px rgba(13,156,30,0.2); }
    .wizard-step-indicator.completed .step-number { background: #0D9C1E; color: #fff; border-color: #0D9C1E; }
    .step-label { font-size: 0.85rem; color: #6b7280; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
    .wizard-step-indicator.active .step-label { color: #0D9C1E; }
    .wizard-pane { display: none; animation: fadeIn 0.4s; }
    .wizard-pane.active { display: block; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    .wizard-footer { margin-top: 2rem; padding-top: 1rem; border-top: 1px solid #e5e7eb; display: flex; justify-content: flex-end; gap: 1rem; }
</style>

CSS;
$content = str_replace('<form action="', $css . '<form action="', $content);

// 2. Stepper
$header_old = <<<HTML
    <div class="row">
        <!-- Basic Details -->
HTML;
$header_new = <<<HTML
    <div class="wizard-steps" id="wizardSteps">
        <div class="wizard-step-indicator active" data-step="1">
            <div class="step-number">1</div><div class="step-label">Basic Details</div>
        </div>
        <div class="wizard-step-indicator" data-step="2">
            <div class="step-number">2</div><div class="step-label">Passport</div>
        </div>
        <div class="wizard-step-indicator" data-step="3">
            <div class="step-number">3</div><div class="step-label">Visa & Labor</div>
        </div>
        <div class="wizard-step-indicator" data-step="4">
            <div class="step-number">4</div><div class="step-label">EID Details</div>
        </div>
        <div class="wizard-step-indicator" data-step="5">
            <div class="step-number">5</div><div class="step-label">Other Details</div>
        </div>
    </div>
    <div class="row wizard-content">
        <!-- Basic Details -->
        <div class="wizard-pane active" id="pane-1">
HTML;
$content = substr_replace($content, $header_new, strpos($content, $header_old), strlen($header_old));

// 3. Reorder basic fields
$basic_start = strpos($content, '<div class="col-md-3 mb-3">', strpos($content, 'Basic Details'));
$basic_end = strpos($content, '<!-- Passport Details -->');
$basic_end = strrpos(substr($content, 0, $basic_end), '</div>', -10); // Finding the end row div before Passport Details
// Actually, it's safer to use preg_replace from first class="col-md-3" to the end of the col-12 for special days
$basic_regex = '/<div class="col-md-3 mb-3">\s*<label class="form-label">Full Name.*?<\/svg>\s*<\/button>\s*<\/div>\s*<\/div>\s*<\/div>\s*<\/div>/s';
$basic_new = <<<HTML
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>
                            @error('name') <div class="invalid-feedback">{{ \$message }}</div> @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Company <span class="text-danger">*</span></label>
                            <div class="select-wrapper">
                                <select class="form-control @error('company_id') is-invalid @enderror" name="company_id" id="companySelect" required>
                                    <option value="">Select Company</option>
                                    @foreach(\$companies as \$company)
                                    <option value="{{ \$company->id }}" {{ old('company_id') == \$company->id ? 'selected' : '' }}>{{ \$company->name }}</option>
                                    @endforeach
                                    <option value="__new__" id="addCompanyOption" class="text-center" style="background:#0D9C1E;color:#fff;">+ Add Company</option>
                                </select>
                                @error('company_id') <div class="invalid-feedback">{{ \$message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Department</label>
                            <div class="select-wrapper">
                                <select class="form-control @error('department_id') is-invalid @enderror" name="department_id" id="departmentSelect">
                                    <option value="">Select Department</option>
                                    @foreach(\$departments as \$department)
                                    <option value="{{ \$department->id }}" {{ old('department_id') == \$department->id ? 'selected' : '' }}>{{ \$department->name }}</option>
                                    @endforeach
                                    <option value="__new_department__" id="addDepartmentOption" class="text-center" style="background:#0D9C1E;color:#fff;">+ Add Department</option>
                                </select>
                            </div>
                            @error('department_id') <div class="invalid-feedback">{{ \$message }}</div> @enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Designation</label>
                            <input type="text" class="form-control" name="designation" value="{{ old('designation') }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Date of Joining</label>
                            <input type="text" class="form-control datepicker" name="joining_date" id="joining_date" value="{{ old('joining_date') }}" placeholder="Select Date">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Employee ID</label>
                            <input type="text" class="form-control @error('employee_id') is-invalid @enderror" name="employee_id" value="{{ old('employee_id') }}">
                            @error('employee_id') <div class="invalid-feedback">{{ \$message }}</div> @enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Date of Birth</label>
                            <input type="text" class="form-control datepicker" name="dob" id="dob" value="{{ old('dob') }}" placeholder="Select Date">
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
                                        <input type="text" name="special_days_name[]" class="form-control mb-2" placeholder="Special Day Name">
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" name="special_days_date[]" class="form-control mb-2 datepicker" placeholder="Select Date">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-success addSpecialDay mb-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="white" viewBox="0 0 16 16"><path d="M8 1a.5.5 0 0 1 .5.5V7.5H14.5a.5.5 0 0 1 0 1H8.5V14.5a.5.5 0 0 1-1 0V8.5H1.5a.5.5 0 0 1 0-1H7.5V1.5A.5.5 0 0 1 8 1z" /></svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
HTML;
$content = preg_replace($basic_regex, $basic_new, $content);

// 4. Wrap Panes
$content = str_replace('<!-- Passport Details -->', "        </div><!-- pane1 end -->\n        <div class=\"wizard-pane\" id=\"pane-2\">\n        <!-- Passport Details -->", $content);
$content = str_replace('<!-- Visa Details -->', "        </div><!-- pane2 end -->\n        <div class=\"wizard-pane\" id=\"pane-3\">\n        <div class=\"row\">\n        <!-- Visa Details -->", $content);
$content = str_replace('<!-- EID Details -->', "        </div>\n        </div><!-- pane3 end -->\n        <div class=\"wizard-pane\" id=\"pane-4\">\n        <!-- EID Details -->", $content);
$content = str_replace('<!-- Other Details -->', "        </div><!-- pane4 end -->\n        <div class=\"wizard-pane\" id=\"pane-5\">\n        <!-- Other Details -->", $content);

// 5. Replace card footer with wizard footer
$footer_old = <<<HTML
                <div class="card-footer text-end">
                    <a href="{{ route('employees.index') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save Employee</button>
                </div>
            </div>
        </div>
    </div>
</form>
HTML;
$footer_new = <<<HTML
                </div>
            </div>
        </div>
        </div><!-- pane5 end -->
    </div><!-- wizard content end -->
    
    <div class="wizard-footer mt-4">
        <a href="{{ route('employees.index') }}" class="btn btn-light" id="btnCancel">Cancel</a>
        <button type="button" class="btn btn-secondary" id="btnPrev" style="display:none;">Previous</button>
        <button type="button" class="btn btn-primary" id="btnNext" style="background:#0D9C1E;border-color:#0D9C1E;">Next</button>
        <button type="submit" class="btn btn-success" id="btnSubmit" style="display:none;background:#0D9C1E;border-color:#0D9C1E;">Save Employee</button>
    </div>
</form>
HTML;
$content = str_replace($footer_old, $footer_new, $content);

// 6. JS script
$js = <<<JS
<script>
    let currentStep = 1;
    const totalSteps = 5;

    function updateWizard() {
        $('.wizard-pane').removeClass('active');
        $('#pane-' + currentStep).addClass('active');

        $('.wizard-step-indicator').removeClass('active completed');
        $('.wizard-step-indicator').each(function() {
            let step = parseInt($(this).data('step'));
            if (step < currentStep) $(this).addClass('completed');
            if (step === currentStep) $(this).addClass('active');
        });

        if (currentStep === 1) {
            $('#btnPrev').hide();
            $('#btnCancel').show();
        } else {
            $('#btnPrev').show();
            $('#btnCancel').hide();
        }

        if (currentStep === totalSteps) {
            $('#btnNext').hide();
            $('#btnSubmit').show();
        } else {
            $('#btnNext').show();
            $('#btnSubmit').hide();
        }
    }

    $('#btnNext').click(function() {
        let isValid = true;
        $('#pane-' + currentStep + ' [required]').each(function() {
            if (!this.checkValidity()) {
                isValid = false;
                this.reportValidity();
                return false;
            }
        });
        
        if (isValid && currentStep < totalSteps) {
            currentStep++;
            updateWizard();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    });

    $('#btnPrev').click(function() {
        if (currentStep > 1) {
            currentStep--;
            updateWizard();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    });
</script>
@endsection
JS;
$content = str_replace('@endsection', $js, $content);

file_put_contents('c:/Mostech/attendanceapp/resources/views/employees/create.blade.php', $content);
echo "Done.";
