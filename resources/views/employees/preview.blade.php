@extends('layouts.app')

@section('title', 'Employee Details')

@section('content')
<div class="page-header">
    <h1 class="page-title">Document Preview</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('employees.index') }}">Employees</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $label }}</li>
        </ol>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ $label }}</h3>
                <div class="card-options">
                    <a href="javascript:history.back()" class="btn btn-primary btn-sm">
                        <i class="fe fe-arrow-left"></i> Back
                    </a>
                </div>
            </div>
            <div class="card-body text-center bg-light">
                @php
                    $extension = pathinfo($url, PATHINFO_EXTENSION);
                @endphp

                @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                    <div class="img-preview-container p-3">
                        <img src="{{ $url }}" alt="{{ $label }}" class="img-fluid">
                    </div>
                @elseif(strtolower($extension) === 'pdf')
                    <div class="pdf-preview-container">
                        <iframe src="{{ $url }}#toolbar=0&navpanes=0&scrollbar=0" style="width:100%; height:80vh; border:none;"></iframe>
                    </div>
                @else
                    <div class="p-5">
                        <i class="fe fe-alert-circle text-warning fs-50"></i>
                        <h5 class="mt-3">Preview not available for this file type.</h5>
                        <p class="text-muted">Extension: {{ $extension }}</p>
                        <a href="{{ $url }}" class="btn btn-primary mt-3" target="_blank">
                            <i class="fe fe-external-link"></i> Open in new tab
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection