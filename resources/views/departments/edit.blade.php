@extends('layouts.app')

@section('title', 'Edit Department')

@section('content')
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="page-header mt-4 mb-4">
            <h1 class="page-title text-primary">Edit Department</h1>
            <div>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('departments.index') }}">Departments</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Department</li>
                </ol>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <form action="{{ route('departments.update', $department->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label class="form-label fw-bold">Department Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $department->name) }}" placeholder="Enter department name" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('departments.index') }}" class="btn btn-light">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update Department</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
