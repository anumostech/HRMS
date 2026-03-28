<div class="row">

    <!-- Dependents -->
    <div class="col-md-3 mb-3">
        <label class="form-label">Dependents</label>
        <select class="form-control" name="dependents">
            <option value="">Select option</option>
            <option value="No" {{ old('dependents') == 'No' ? 'selected' : '' }}>No</option>
            <option value="Yes" {{ old('dependents') == 'Yes' ? 'selected' : '' }}>Yes</option>
        </select>
    </div>

    <!-- Company Mobile -->
    <div class="col-md-3 mb-3">
        <label class="form-label">Company Mobile</label>
        <input type="text"
               class="form-control @error('company_mobile_number') is-invalid @enderror"
               name="company_mobile_number"
               value="{{ old('company_mobile_number') }}"
               placeholder="Enter company mobile number"
               pattern="[0-9]{7,15}"
               title="Enter a valid phone number (7–15 digits)">
        @error('company_mobile_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <!-- Personal Number -->
    <div class="col-md-3 mb-3">
        <label class="form-label">Personal Number</label>
        <input type="text"
               class="form-control @error('personal_number') is-invalid @enderror"
               name="personal_number"
               value="{{ old('personal_number') }}"
               placeholder="Enter personal phone number"
               pattern="[0-9]{7,15}"
               title="Enter a valid phone number (7–15 digits)">
        @error('personal_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <!-- Other Number -->
    <div class="col-md-3 mb-3">
        <label class="form-label">Other Number</label>
        <input type="text"
               class="form-control @error('other_number') is-invalid @enderror"
               name="other_number"
               value="{{ old('other_number') }}"
               placeholder="Enter alternate number"
               pattern="[0-9]{7,15}"
               title="Enter a valid phone number (7–15 digits)">
        @error('other_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <!-- Company Email -->
    <div class="col-md-6 mb-3">
        <label class="form-label">Company Email</label>
        <input type="email"
               class="form-control @error('company_email') is-invalid @enderror"
               name="company_email"
               value="{{ old('company_email') }}"
               placeholder="Enter company email (e.g. name@company.com)">
        @error('company_email') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <!-- Personal Email -->
    <div class="col-md-6 mb-3">
        <label class="form-label">Personal Email</label>
        <input type="email"
               class="form-control @error('personal_email') is-invalid @enderror"
               name="personal_email"
               value="{{ old('personal_email') }}"
               placeholder="Enter personal email (e.g. name@gmail.com)">
        @error('personal_email') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

</div>