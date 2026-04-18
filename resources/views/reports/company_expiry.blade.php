@extends('layouts.app')

@section('title', $title)

@section('content')
<div class="row w-100">
    <div class="col-lg-12 mx-auto">
        <div class="page-header mt-4 mb-4">
            <h1 class="page-title text-primary"><i class="fe fe-briefcase"></i> {{ $title }}</h1>
            <div class="ms-auto d-flex align-items-center gap-3">
                <span class="badge bg-soft-info px-3 py-2 rounded-pill">{{ $subtitle }}</span>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('reports.index') }}">Reports</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                </ol>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 datatable-basic">
                        <thead class="bg-light">
                            <tr>
                                <th>Company Name</th>
                                <th>Trade License</th>
                                <th>TL Expiry</th>
                                <th>Est. Card</th>
                                <th>EC Expiry</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($companies as $company)
                            @php
                                $threshold = \Carbon\Carbon::now()->addDays(30);
                            @endphp
                            <tr>
                                <td class="fw-bold">{{ $company->company_name }}</td>
                                <td>{{ $company->trade_license_number }}</td>
                                <td class="{{ $company->trade_license_expiry && \Carbon\Carbon::parse($company->trade_license_expiry)->lte($threshold) ? 'text-danger fw-bold' : '' }}">
                                    {{ $company->trade_license_expiry }}
                                </td>
                                <td>{{ $company->establishment_card_number }}</td>
                                <td class="{{ $company->establishment_card_expiry && \Carbon\Carbon::parse($company->establishment_card_expiry)->lte($threshold) ? 'text-danger fw-bold' : '' }}">
                                    {{ $company->establishment_card_expiry }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-soft-info { background: rgba(6, 182, 212, 0.1); color: #06b6d4; }
</style>
@endsection
