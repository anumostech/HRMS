@extends('layouts.app')

@section('title', 'Upload Attendance')

@section('content')
<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">Upload Attendance</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('attendance.index') }}">Attendance</a></li>
            <li class="breadcrumb-item active" aria-current="page">Upload</li>
        </ol>
    </div>
</div>
<!-- PAGE-HEADER END -->

<div class="row">
    <div class="col-lg-6 offset-lg-3">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Upload Attendance File (.dat / .csv)</h3>
            </div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('attendance.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="company_id" class="form-label">Select Company</label>
                        <select name="company_id" id="company_id" class="form-control" required>
                            <option value="">-- Select Company --</option>
                            @foreach($companies as $company)
                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-4">
                        <label for="file" class="form-label">Attendance File</label>
                        <input type="file" name="file" id="file" class="form-control" accept=".dat,.csv" required>
                        <small class="text-muted">Accepted formats: .dat (space-separated) or .csv</small>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Process File</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
