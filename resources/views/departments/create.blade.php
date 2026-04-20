@extends('layouts.app')

@section('title', 'Add Department')

@section('content')
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="page-header mt-4 mb-4">
            <h1 class="page-title text-primary">Add Department</h1>
            <div>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('departments.index') }}">Departments</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add Department</li>
                </ol>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <form action="{{ route('departments.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label fw-bold">Department Name(s) <span class="text-danger">*</span></label>
                        <div id="departmentInputsContainer">
                            <div class="d-flex mb-2 department-input-row">
                                <input type="text" name="name[]" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Enter department name" required>
                                <button type="button" class="btn btn-success ms-2 addDepartmentInput">+</button>
                            </div>
                        </div>
                        @error('name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('departments.index') }}" class="btn btn-light">Cancel</a>
                        <button type="submit" class="btn btn-primary">Save Department</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).on('click', '.addDepartmentInput', function() {
        let html = `
        <div class="d-flex mb-2 department-input-row">
            <input type="text" name="name[]" class="form-control" placeholder="Enter department name" required>
            <button type="button" class="btn btn-danger ms-2 removeDepartmentInput">-</button>
        </div>`;
        $('#departmentInputsContainer').append(html);
    });

    $(document).on('click', '.removeDepartmentInput', function() {
        $(this).closest('.department-input-row').remove();
    });
</script>
@endsection
