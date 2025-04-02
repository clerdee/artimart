@extends('layouts.base')

@section('title', 'Login - ArtiMart')

@section('body')
<header class="py-5 bg-gradient" style="background: linear-gradient(135deg, #ffecb3 0%, #fff8e1 100%);">
    <div class="container text-center">
        <h1 class="fw-bold" style="color: #e65100;">Welcome to ArtiMart</h1>
        <p class="lead">Where Creativity Meets Quality</p>
    </div>
</header>

@include('layouts.flash-messages')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
            <div class="card border-0 shadow-sm rounded-lg overflow-hidden">
                <div class="card-header bg-orange-50 border-0 p-4 text-center">
                    <h4 class="fw-bold mb-0" style="color: #e65100;">
                        <i class="fas fa-user-circle me-2"></i>{{ __('Login') }}
                    </h4>
                </div>
                
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label fw-medium">{{ __('Email Address') }}</label>
                            <input id="email" type="email" 
                                class="form-control rounded-pill border-light bg-light @error('email') is-invalid @enderror" 
                                name="email" value="{{ old('email') }}" 
                                required autocomplete="email" autofocus>
                            
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-medium">{{ __('Password') }}</label>
                            <input id="password" type="password" 
                                class="form-control rounded-pill border-light bg-light @error('password') is-invalid @enderror" 
                                name="password" 
                                required autocomplete="current-password">
                            
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input class="form-check-input" type="checkbox" name="remember" 
                                id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>

                        <div class="d-grid gap-2 mb-3">
                            <button type="submit" class="btn btn-warning rounded-pill text-white fw-medium py-2">
                                <i class="fas fa-sign-in-alt me-2"></i>{{ __('Login') }}
                            </button>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <a class="text-decoration-none small" href="{{ route('register') }}" style="color: #e65100;">
                                <i class="fas fa-user-plus me-1"></i>{{ __("Don't have an account?") }}
                            </a>
                            
                            @if (Route::has('password.request'))
                                <a class="text-decoration-none small text-muted" href="{{ route('password.request') }}">
                                    <i class="fas fa-key me-1"></i>{{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
                
                <div class="card-footer bg-light border-0 p-4">
                    <div class="text-center">
                        <p class="small text-muted mb-0">Or continue with</p>
                        <div class="d-flex justify-content-center gap-3 mt-3">
                            <button class="btn btn-outline-secondary rounded-circle">
                                <i class="fab fa-google"></i>
                            </button>
                            <button class="btn btn-outline-secondary rounded-circle">
                                <i class="fab fa-facebook-f"></i>
                            </button>
                            <button class="btn btn-outline-secondary rounded-circle">
                                <i class="fab fa-twitter"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-warning.text-white {
        color: #fff !important;
        background-color: #e65100;
        border-color: #e65100;
    }
    
    .btn-warning.text-white:hover {
        background-color: #d84315;
        border-color: #d84315;
    }
    
    .btn-outline-secondary.rounded-circle {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }
    
    .btn-outline-secondary.rounded-circle:hover {
        background-color: #f5f5f5;
        transform: translateY(-2px);
    }
    
    .bg-orange-50 {
        background-color: #fff3e0;
    }
    
    /* Animation for card */
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
    }
</style>
@endsection