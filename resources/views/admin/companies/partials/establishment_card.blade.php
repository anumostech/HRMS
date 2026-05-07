<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Establishment Card Number</label>
        <input type="text" class="form-control @error('establishment_card_number') is-invalid @enderror" name="establishment_card_number"
            value="{{ old('establishment_card_number', $company->establishment_card_number ?? '') }}" placeholder="Enter establishment card number">
        @error('establishment_card_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Establishment Card Expiry</label>
        <div class="position-relative">
            <input type="text" class="form-control datepicker pe-5 @error('establishment_card_expiry') is-invalid @enderror" 
                name="establishment_card_expiry"
                value="{{ old('establishment_card_expiry', isset($company->establishment_card_expiry) ? \Carbon\Carbon::parse($company->establishment_card_expiry)->format('d-m-Y') : '') }}"
                placeholder="Select expiry date">
            <span class="date-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h1V.5a.5.5 0 0 1 .5-.5zM2 5v9h12V5H2z" />
                </svg>
            </span>
        </div>
        @error('establishment_card_expiry') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-12 mb-3">
        <label class="form-label">Establishment Card Attachment (PDF/JPG)</label>
        <input type="file" class="form-control mb-1 document-upload" data-field="establishment_card_attachment" accept=".pdf,.jpg,.jpeg,.png">
        <input type="hidden" name="establishment_card_attachment" value="{{ old('establishment_card_attachment', $company->establishment_card_attachment ?? '') }}">
        @if(isset($company) && $company->establishment_card_attachment)
            <small class="text-success"><i class="fe fe-check-circle"></i> File uploaded</small>
            <div class="mt-2">
                <a href="{{ asset('storage/' . $company->establishment_card_attachment) }}" target="_blank" class="btn btn-sm btn-outline-info">
                   <i class="fe fe-eye"></i> View Current File
                </a>
            </div>
        @endif
        @error('establishment_card_attachment') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
    </div>
</div>
