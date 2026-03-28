<?php
$content = file_get_contents('c:/Mostech/attendanceapp/resources/views/employees/create.blade.php');

// We will insert CSS at the very top of @section('content')
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

$content = str_replace('@section(\'content\')', "@section('content')\n" . $css, $content);

// Add stepper HTML after <form>
$stepper = <<<HTML
    <div class="wizard-steps" id="wizardSteps">
        <div class="wizard-step-indicator active" data-step="1">
            <div class="step-number">1</div>
            <div class="step-label">Basic Details</div>
        </div>
        <div class="wizard-step-indicator" data-step="2">
            <div class="step-number">2</div>
            <div class="step-label">Passport</div>
        </div>
        <div class="wizard-step-indicator" data-step="3">
            <div class="step-number">3</div>
            <div class="step-label">Visa & Labor</div>
        </div>
        <div class="wizard-step-indicator" data-step="4">
            <div class="step-number">4</div>
            <div class="step-label">EID Details</div>
        </div>
        <div class="wizard-step-indicator" data-step="5">
            <div class="step-number">5</div>
            <div class="step-label">Other Details</div>
        </div>
    </div>
HTML;
$content = str_replace('<div class="row">', $stepper . "\n    <div class=\"row wizard-content\">", $content);

// Reordering Basic Details.
$oldBasicDetails = substr($content, strpos($content, '<div class="card-body">', strpos($content, 'Basic Details')), strpos($content, '</div>', strpos($content, '<!-- Passport Details -->')) - strpos($content, '<div class="card-body">', strpos($content, 'Basic Details')));

$basicDetailsHTML = <<<HTML
<div class="card-body">
    <div class="row">
        <!-- Reordered Fields -->
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
                        <input type="text" name="special_days_name[]" class="form-control mb-2" placeholder="Special Day Name (Birthday, Anniversary)">
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
    </div>
</div>
HTML;

$content = preg_replace('/<div class="card-body">.*?<div id="specialDaysWrapper">.*?<\/div>\s*<\/div>\s*<\/div>\s*<\/div>\s*<\/div>/s', $basicDetailsHTML, $content, 1);

// Wrap panels
$content = str_replace('<div class="col-md-12">'."\n".'            <div class="card">'."\n".'                <div class="card-header">'."\n".'                    <h3 class="card-title">Basic Details</h3>', '<div class="wizard-pane active" id="pane-1"><div class="col-md-12"><div class="card"><div class="card-header"><h3 class="card-title">Basic Details</h3>', $content);

$content = preg_replace('/(<!-- Passport Details -->\s*)<div class="col-md-12">/', "$1</div><!-- end pane 1 -->\n<div class=\"wizard-pane\" id=\"pane-2\">\n<div class=\"col-md-12\">", $content);

$content = preg_replace('/(<!-- Visa Details -->\s*)<div class="col-md-6">/', "$1</div><!-- end pane 2 -->\n<div class=\"wizard-pane\" id=\"pane-3\">\n<div class=\"row\">\n<div class=\"col-md-6\">", $content);

$content = preg_replace('/(<!-- EID Details -->\s*)<div class="col-md-12">/', "$1</div><!-- end row for visa labor -->\n</div><!-- end pane 3 -->\n<div class=\"wizard-pane\" id=\"pane-4\">\n<div class=\"col-md-12\">", $content);

$content = preg_replace('/(<!-- Other Details -->\s*)<div class="col-md-12">/', "$1</div><!-- end pane 4 -->\n<div class=\"wizard-pane\" id=\"pane-5\">\n<div class=\"col-md-12\">", $content);

// Ensure proper closing and buttons
// The last pane ends where the old card-footer was
$content = preg_replace('/<div class="card-footer text-end">.*?<\/div>\s*<\/div>\s*<\/div>\s*<\/div>\s*<\/form>/s', '</div></div></div><!-- end pane 5 --></div><!-- end row wizard-content --></form>', $content);

// Add bottom nav
$nav = <<<HTML
<div class="wizard-footer mt-4">
    <a href="{{ route('employees.index') }}" class="btn btn-light" id="btnCancel">Cancel</a>
    <button type="button" class="btn btn-secondary" id="btnPrev" style="display:none;">Previous</button>
    <button type="button" class="btn btn-primary" id="btnNext">Next</button>
    <button type="submit" class="btn btn-success" id="btnSubmit" style="display:none;background:#0D9C1E;border-color:#0D9C1E;">Save Employee</button>
</div>
HTML;
$content = str_replace('</form>', $nav . "\n</form>", $content);

// Append JS
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
        // Basic HTML5 validation for current pane
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
JS;

$content = str_replace('</script>', "</script>\n" . $js, $content);

file_put_contents('c:/Mostech/attendanceapp/resources/views/employees/create.blade.php', $content);
echo "Modification complete.\n";
