<div class="row">

    <div class="col-md-6 mb-3">
        <label class="form-label">Company Name <span class="text-danger">*</span></label>
        <input type="text" class="form-control @error('company_name') is-invalid @enderror" name="company_name"
            value="{{ old('company_name', $company->company_name ?? '') }}" placeholder="Enter company name" required>
        @error('company_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Phone</label>
        <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone"
            value="{{ old('phone', $company->phone ?? '') }}" placeholder="Enter phone number">
        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Email</label>
        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
            value="{{ old('email', $company->email ?? '') }}" placeholder="Enter email address">
        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-12 mb-3">
        <label class="form-label">Address</label>
        <textarea class="form-control @error('address') is-invalid @enderror" name="address" rows="3" placeholder="Enter company address">{{ old('address', $company->address ?? '') }}</textarea>
        @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-12 mb-3">
        <label class="form-label">Logo</label>
        <input type="file" class="form-control @error('logo') is-invalid @enderror" name="logo" accept="image/*">
        @if(isset($company) && $company->logo)
            <div class="mt-2 text-center">
                <img src="{{ asset('storage/' . $company->logo) }}" alt="Logo" class="img-thumbnail" style="height: 100px;">
            </div>
        @endif
        @error('logo') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
    </div>
</div>
