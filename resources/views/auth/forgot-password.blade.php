@extends('layouts.app')

@section('title', 'Forgot Password')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-4">
        <div class="card mt-5 shadow-sm border-0">
            <div class="card-header text-center bg-white border-bottom py-3">
                <h3 class="card-title mb-0 fw-bold">Forgot Password</h3>
            </div>
            <div class="card-body p-4">
                <p class="text-muted small mb-4">
                    Enter your email address and we will send you a 6-digit verification code to reset your password.
                </p>

                @if(session('status') === 'code-sent')
                    <div class="alert alert-success">
                        A verification code has been sent to your email.
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('password.email') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">Email Address</label>
                        <input type="email" name="email" id="email" class="form-control" required value="{{ old('email') }}" placeholder="name@example.com">
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary w-100 fw-semibold py-2">Send Verification Code</button>
                    </div>
                    <div class="text-center mt-3">
                        <a href="{{ route('login') }}" class="text-decoration-none small">Back to Login</a>
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
