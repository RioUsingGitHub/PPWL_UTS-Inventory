@extends('layouts.app')

@section('content')
    <!--
    <div class="container position-sticky z-index-sticky top-0">
        <div class="row">
            <div class="col-12">
                @ include('layouts.navbars.guest.navbar')
            </div>
        </div>
    </div>
    -->
    <main class="main-content mt-0">
        <section>
            <div class="page-header min-vh-100">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
                            <div class="card card-plain">
                                <div class="card-header pb-0 text-start">
                                    <div class="text-center mb-4">
                                        <div class="icon-shape icon-shape-primary shadow text-center border-radius-md">
                                            <i class="fas fa-boxes fa-2x text-white"></i>
                                        </div>
                                        <h4 class="mt-4 font-weight-bolder">Welcome Back!</h4>
                                        <p class="mb-0 text-muted">Please sign in to your account</p>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <form role="form" method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <div class="mb-4">
                                            <label for="email" class="form-label">Email Address</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                                <input type="email" name="email" id="email" 
                                                    class="form-control form-control-lg @error('email') is-invalid @enderror" 
                                                    value="{{ old('email') }}" 
                                                    placeholder="name@company.com" required>
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
                                                    class="form-control form-control-lg @error('password') is-invalid @enderror" 
                                                    placeholder="••••••••" required>
                                            </div>
                                            @error('password') 
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                            <div class="form-check">
                                                <input class="form-check-input" name="remember" type="checkbox" id="remember">
                                                <label class="form-check-label text-muted" for="remember">
                                                    Remember me
                                                </label>
                                            </div>
                                            <a href="{{ route('password.request') }}" class="text-primary text-sm font-weight-bold">
                                                Forgot password?
                                            </a>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-lg btn-primary w-100 mb-0">
                                                <i class="fas fa-sign-in-alt me-2"></i> Sign in
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                    <p class="mb-4 text-sm text-muted">
                                        Don't have an account? 
                                        <a href="{{ route('register') }}" class="text-primary font-weight-bold">
                                            Create one now
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
                            <div class="position-relative h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden"
                                style="background-image: url('{{ asset('img/inventory-bg.jpg') }}');
                                       background-size: cover;">
                                <span class="mask bg-gradient-primary opacity-6"></span>
                                <div class="position-relative">
                                    <h3 class="mt-4 text-white font-weight-bolder">
                                        Inventory Management System
                                    </h3>
                                    <p class="text-white text-lg opacity-8">
                                        Streamline your inventory operations with our powerful and intuitive management system.
                                        Track, manage, and optimize your stock with ease.
                                    </p>
                                    <div class="d-flex justify-content-center mt-4">
                                        <div class="text-center mx-3">
                                            <h1 class="text-white"><i class="fas fa-box"></i></h1>
                                            <p class="text-white text-sm opacity-8">Item Management</p>
                                        </div>
                                        <div class="text-center mx-3">
                                            <h1 class="text-white"><i class="fas fa-chart-line"></i></h1>
                                            <p class="text-white text-sm opacity-8">Real-time Analytics</p>
                                        </div>
                                        <div class="text-center mx-3">
                                            <h1 class="text-white"><i class="fas fa-users"></i></h1>
                                            <p class="text-white text-sm opacity-8">Team Collaboration</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@push('styles')
<style>
    .card-plain {
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
    
    .text-gradient {
        background: linear-gradient(310deg, #5e72e4 0%, #825ee4 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    
    .invalid-feedback {
        font-size: 0.75rem;
        margin-top: 0.25rem;
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
    
    .page-header {
        position: relative;
        overflow: hidden;
        background: linear-gradient(310deg, #5e72e4 0%, #825ee4 100%);
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
    
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
        100% { transform: translateY(0px); }
    }
    
    .text-center h1 {
        animation: float 3s ease-in-out infinite;
    }
    
    .text-center h1:nth-child(2) {
        animation-delay: 0.2s;
    }
    
    .text-center h1:nth-child(3) {
        animation-delay: 0.4s;
    }
</style>
@endpush
