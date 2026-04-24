<div class="row">
    <div class="col-md-12 mb-3">
        <label class="form-label">Trade License Name</label>
        <input type="text" class="form-control @error('trade_license_name') is-invalid @enderror" name="trade_license_name"
            value="{{ old('trade_license_name', $company->trade_license_name ?? '') }}" placeholder="Enter trade license name">
        @error('trade_license_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Trade License Number</label>
        <input type="text" class="form-control @error('trade_license_number') is-invalid @enderror" name="trade_license_number"
            value="{{ old('trade_license_number', $company->trade_license_number ?? '') }}" placeholder="Enter trade license number">
        @error('trade_license_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Trade License Expiry</label>
        <div class="position-relative">
            <input type="text" class="form-control datepicker pe-5 @error('trade_license_expiry') is-invalid @enderror" 
                name="trade_license_expiry"
                value="{{ old('trade_license_expiry', isset($company->trade_license_expiry) ? \Carbon\Carbon::parse($company->trade_license_expiry)->format('d-m-Y') : '') }}"
                placeholder="Select expiry date">
            <span class="date-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h1V.5a.5.5 0 0 1 .5-.5zM2 5v9h12V5H2z" />
                </svg>
            </span>
        </div>
        @error('trade_license_expiry') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-12 mb-3">
        <label class="form-label">Trade License Attachment (PDF)</label>
        <input type="file" class="form-control mb-1 document-upload" data-field="trade_license_attachment" accept=".pdf">
        <input type="hidden" name="trade_license_attachment" value="{{ old('trade_license_attachment', $company->trade_license_attachment ?? '') }}">
        @if(isset($company) && $company->trade_license_attachment)
            <small class="text-success"><i class="fe fe-check-circle"></i> File uploaded</small>
            <div class="mt-2">
                <a href="{{ asset('storage/' . $company->trade_license_attachment) }}" target="_blank" class="btn btn-sm btn-outline-info">
                   <i class="fe fe-eye"></i> View Current File
                </a>
            </div>
        @endif
        @error('trade_license_attachment') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
    </div>
</div>
