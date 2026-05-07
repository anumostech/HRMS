@extends('layouts.app')

@section('title', 'Designations')

@section('content')
<div class="row w-100 mt-4">
    <div class="col-lg-6 mx-auto">
        <div class="page-header" style="display: inline;">
            <h1 class="page-title mb-2">Edit Designation</h1>
            <div>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('designations.index') }}">Designations</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Designation</li>
                </ol>
            </div>
        </div>
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <form action="{{ route('designations.update', $designation->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Designation Name(s) <span class="text-danger">*</span></label>
                        <div id="designationInputsContainer">
                            <div class="d-flex mb-2 designation-input-row">
                                <input type="text" name="name[]" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $designation->name) }}" placeholder="Enter designation name" required>
                                <button type="button" class="btn btn-success ms-2 addDesignationInput">+</button>
                            </div>
                        </div>
                        @error('name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="mb-4 form-check form-switch">
                        <input class="form-check-input flexShrink" type="checkbox" id="default_punch_access" name="default_punch_access" value="1" {{ old('default_punch_access', $designation->default_punch_access) ? 'checked' : '' }}>
                        <label class="form-check-label ms-2" for="default_punch_access">
                            <strong>Default Punch Access</strong>
                            <br>
                            <span class="text-muted small">If enabled, employees with this designation can punch in/out without needing an approved WFH request. (e.g. Delivery Man, Salesperson)</span>
                        </label>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('designations.index') }}" class="btn btn-light me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update Designation</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).on('click', '.addDesignationInput', function() {
        let html = `
        <div class="d-flex mb-2 designation-input-row">
            <input type="text" name="name[]" class="form-control" placeholder="Enter additional designation name">
            <button type="button" class="btn btn-danger ms-2 removeDesignationInput">-</button>
        </div>`;
        $('#designationInputsContainer').append(html);
    });

    $(document).on('click', '.removeDesignationInput', function() {
        $(this).closest('.designation-input-row').remove();
    });
</script>
@endsection
