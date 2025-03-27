@extends('layouts.app')

@section('content')
    <main class="main-content mt-0">
        <div class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg"
            style="background-image: url('{{ asset('img/inventory-bg.jpg') }}'); background-position: top;">
            <span class="mask bg-gradient-primary opacity-6"></span>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5 text-center mx-auto">
                        <div class="icon-shape icon-shape-primary shadow text-center border-radius-md mb-4">
                            <i class="fas fa-user-plus fa-2x text-white"></i>
                        </div>
                        <h1 class="text-white mb-2 mt-5">Join Our Platform</h1>
                        <p class="text-lead text-white">Create an account to start managing your inventory efficiently and effectively.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row mt-lg-n10 mt-md-n11 mt-n10 justify-content-center">
                <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
                    <div class="card z-index-0">
                        <div class="card-header text-center pt-4 pb-0">
                            <h5 class="font-weight-bolder mb-0">Create Your Account</h5>
                            <p class="mb-0 text-sm text-muted">Fill in your details to get started</p>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                                <div class="mb-4">
                                    <label for="name" class="form-label">Full Name</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        <input type="text" name="name" id="name" 
                                            class="form-control @error('name') is-invalid @enderror" 
                                            placeholder="John Doe" 
                                            value="{{ old('name') }}" required>
                                    </div>
                                    @error('name')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="email" class="form-label">Email Address</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        <input type="email" name="email" id="email" 
                                            class="form-control @error('email') is-invalid @enderror" 
                                            placeholder="name@company.com" 
                                            value="{{ old('email') }}" required>
                                    </div>
                                    @error('email')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        <input type="password" name="password" id="password" 
                                            class="form-control @error('password') is-invalid @enderror" 
                                            placeholder="••••••••" required>
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="password-confirm" class="form-label">Confirm Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        <input type="password" name="password_confirmation" id="password-confirm" 
                                            class="form-control @error('password_confirmation') is-invalid @enderror" 
                                            placeholder="••••••••" required>
                                    </div>
                                    @error('password_confirmation')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-check form-check-info text-start mb-4">
                                    <input class="form-check-input" type="checkbox" name="terms" id="terms" required>
                                    <label class="form-check-label text-muted" for="terms">
                                        I agree to the <a href="javascript:;" class="text-primary font-weight-bold">Terms of Service</a>
                                        and <a href="javascript:;" class="text-primary font-weight-bold">Privacy Policy</a>
                                    </label>
                                    @error('terms')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-lg btn-primary w-100">
                                        <i class="fas fa-user-plus me-2"></i> Create Account
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="card-footer text-center pt-0 px-sm-4 px-1">
                            <p class="mb-4 text-sm text-muted">
                                Already have an account? 
                                <a href="{{ route('login') }}" class="text-primary font-weight-bold">Sign in</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('styles')
<style>
    .card {
        box-shadow: 0 20px 27px 0 rgb(0 0 0 / 5%);
        border: 1px solid #e9ecef;
        backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.95);
    }
    
    .form-label {
        color: #344767;
        font-size: 0.875rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    
    .input-group-text {
        border: 1px solid #d2d6da;
        background-color: #fff;
    }
    
    .form-control {
        border: 1px solid #d2d6da;
    }
    
    .form-control:focus {
        border-color: #5e72e4;
        box-shadow: 0 0 0 2px rgb(94 114 228 / 25%);
    }
    
    .btn-primary {
        box-shadow: 0 4px 6px rgb(50 50 93 / 10%), 0 1px 3px rgb(0 0 0 / 8%);
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 7px 14px rgb(50 50 93 / 10%), 0 3px 6px rgb(0 0 0 / 8%);
    }
    
    .invalid-feedback {
        font-size: 0.75rem;
        margin-top: 0.25rem;
    }
    
    .page-header {
        position: relative;
        overflow: hidden;
    }
    
    .mask {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        transition: all .15s ease;
    }
    
    .bg-gradient-primary {
        background-image: linear-gradient(310deg, #5e72e4 0%, #825ee4 100%);
    }
    
    .icon-shape {
        width: 48px;
        height: 48px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 0.75rem;
        margin-bottom: 1rem;
    }
    
    .icon-shape-primary {
        background: linear-gradient(310deg, #5e72e4 0%, #825ee4 100%);
    }
    
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
        100% { transform: translateY(0px); }
    }
    
    .icon-shape {
        animation: float 3s ease-in-out infinite;
    }
</style>
@endpush
