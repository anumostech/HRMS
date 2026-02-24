@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-4">
        <div class="card mt-5 shadow-sm border-0">
            <div class="card-header text-center bg-white border-bottom py-3">
                <h3 class="card-title mb-0 fw-bold">Reset Password</h3>
            </div>
            <div class="card-body p-4">
                <p class="text-muted small mb-4">
                    Please enter the 6-digit verification code sent to <strong>{{ $email }}</strong> and your new password.
                </p>

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('password.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="email" value="{{ $email }}">
                    
                    <div class="mb-3">
                        <label for="code" class="form-label fw-semibold">Verification Code</label>
                        <input type="text" name="code" id="code" class="form-control text-center fw-bold fs-4" required maxlength="6" placeholder="000000" autocomplete="one-time-code">
                        <div class="form-text">6-digit code sent to your email.</div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold">New Password</label>
                        <input type="password" name="password" id="password" class="form-control" required placeholder="Min. 8 characters">
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label fw-semibold">Confirm New Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required placeholder="Repeat new password">
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-dark w-100 fw-semibold py-2">Update Password</button>
                    </div>
                    <div class="text-center mt-3">
                        <a href="{{ route('password.request') }}" class="text-decoration-none small">Resend Code</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
     .app-header, .app-sidebar { display: none !important; }
     .main-content { margin-left: 0 !important; }
</style>
@endpush
