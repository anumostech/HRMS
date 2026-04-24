@extends('layouts.app')

@section('title', 'Edit Company')

@section('styles')
    <style>
        #wizardTabs .nav-link {
            cursor: pointer;
        }

        .wizard-step {
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateX(10px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
    </style>
@endsection

@section('content')
    <div class="page-header" style="display: inline;">
        <h1 class="page-title mb-2">Edit Company</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('companies.index') }}">Companies</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Company</li>
            </ol>
        </div>
    </div>

    <form action="{{ route('companies.update', $company->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card">
            <div class="card-body">

                <!-- Step Tabs -->
                <ul class="nav nav-pills mb-4" id="wizardTabs">
                    <li class="nav-item"><a class="nav-link active" data-step="1">Basic Details</a></li>
                    <li class="nav-item"><a class="nav-link" data-step="2">Trade License</a></li>
                    <li class="nav-item"><a class="nav-link" data-step="3">Establishment Card</a></li>
                </ul>

                <!-- Step Content -->
                <div class="wizard-step" id="step-1">
                    <h5 class="mb-4">Company Basic Information</h5>
                    @include('admin.companies.partials.basic')
                </div>

                <div class="wizard-step d-none" id="step-2">
                    <h5 class="mb-4">Trade License Details</h5>
                    @include('admin.companies.partials.trade_license')
                </div>

                <div class="wizard-step d-none" id="step-3">
                    <h5 class="mb-4">Establishment Card Details</h5>
                    @include('admin.companies.partials.establishment_card')
                </div>

            </div>

            <!-- Buttons -->
            <div class="card-footer d-flex justify-content-between">
                <button type="button" class="btn btn-light" id="prevBtn">
                    << Previous</button>
                        <button type="button" class="btn btn-primary" id="nextBtn">Next >></button>
                        <button type="submit" class="btn btn-success d-none" id="submitBtn">Update Company</button>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
    <script>
        let currentStep = 1;
        const totalSteps = 3;

        function showStep(step) {
            document.querySelectorAll('.wizard-step').forEach(el => el.classList.add('d-none'));
            document.getElementById('step-' + step).classList.remove('d-none');

            document.querySelectorAll('#wizardTabs .nav-link').forEach(el => el.classList.remove('active'));
            document.querySelector(`[data-step="${step}"]`).classList.add('active');

            // Buttons
            document.getElementById('prevBtn').style.display = step === 1 ? 'none' : 'inline-block';
            document.getElementById('nextBtn').style.display = step === totalSteps ? 'none' : 'inline-block';
            document.getElementById('submitBtn').classList.toggle('d-none', step !== totalSteps);
        }

        function validateCurrentStep() {
            let stepEl = document.getElementById('step-' + currentStep);
            if (!stepEl) return true;
            
            let inputs = stepEl.querySelectorAll('input, select, textarea');
            for (let i = 0; i < inputs.length; i++) {
                if (!inputs[i].checkValidity()) {
                    inputs[i].reportValidity();
                    return false;
                }
            }
            return true;
        }

        document.getElementById('nextBtn').addEventListener('click', () => {
            if (!validateCurrentStep()) return;
            if (currentStep < totalSteps) {
                currentStep++;
                showStep(currentStep);
            }
        });

        document.getElementById('prevBtn').addEventListener('click', () => {
            if (currentStep > 1) {
                currentStep--;
                showStep(currentStep);
            }
        });

        // Click on tabs
        document.querySelectorAll('#wizardTabs .nav-link').forEach(tab => {
            tab.addEventListener('click', function () {
                let targetStep = parseInt(this.dataset.step);
                if (targetStep !== currentStep) {
                    if (!validateCurrentStep()) return;
                    currentStep = targetStep;
                    showStep(currentStep);
                }
            });
        });

        // AJAX File Upload
        $(document).on('change', '.document-upload', function () {
            let file = this.files[0];
            let field = $(this).data('field');
            let formData = new FormData();
            formData.append('file', file);
            formData.append('field', field);
            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

            axios.post('{{ route("documents.uploadTempDocument") }}', formData)
                .then(function (response) {
                    if (response.data.success == true) {
                        $("input[name='" + field + "']").val(response.data.path);
                    }
                })
                .catch(function () {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'error',
                        title: field + " uploading failed",
                        showConfirmButton: false,
                        timer: 1500
                    });
                });
        });

        // Init
        showStep(currentStep);
    </script>
@endsection
