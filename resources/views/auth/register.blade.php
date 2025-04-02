@extends('layouts.base')

@section('title', 'Register - ArtiMart')

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
        <div class="col-lg-8 col-md-10">
            <div class="card border-0 shadow-sm rounded-lg overflow-hidden">
                <div class="card-header bg-orange-50 border-0 p-4 text-center">
                    <h4 class="fw-bold mb-0" style="color: #e65100;">
                        <i class="fas fa-user-plus me-2"></i>{{ __('Create Account') }}
                    </h4>
                </div>
                
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" id="registrationForm">
                        @csrf

                        <!-- Step 1: Account Information -->
                        <div id="step1">
                            <div class="d-flex align-items-center mb-4">
                                <div class="badge bg-warning text-dark rounded-pill px-3 py-2 me-2">1</div>
                                <h5 class="fw-bold mb-0" style="color: #e65100;">Account Information</h5>
                            </div>
                            
                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label fw-medium">{{ __('Email Address') }}</label>
                                <input id="email" type="email" 
                                    class="form-control rounded-pill border-light bg-light @error('email') is-invalid @enderror" 
                                    name="email" value="{{ old('email') }}" 
                                    required autofocus>
                                
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label fw-medium">{{ __('Password') }}</label>
                                <input id="password" type="password" 
                                    class="form-control rounded-pill border-light bg-light @error('password') is-invalid @enderror" 
                                    name="password" required>
                                
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-4">
                                <label for="password-confirm" class="form-label fw-medium">{{ __('Confirm Password') }}</label>
                                <input id="password-confirm" type="password" 
                                    class="form-control rounded-pill border-light bg-light" 
                                    name="password_confirmation" required>
                            </div>

                            <div class="d-grid">
                                <button type="button" class="btn btn-warning rounded-pill text-white fw-medium py-2" onclick="nextStep()">
                                    <i class="fas fa-arrow-right me-2"></i>Continue
                                </button>
                            </div>
                        </div>

                        <!-- Step 2: Personal Information -->
                        <div id="step2" style="display: none;">
                            <div class="d-flex align-items-center mb-4">
                                <div class="badge bg-warning text-dark rounded-pill px-3 py-2 me-2">2</div>
                                <h5 class="fw-bold mb-0" style="color: #e65100;">Personal Information</h5>
                            </div>
                            
                            <!-- Profile Image -->
                            <div class="mb-4">
                                <label for="profile_image" class="form-label fw-medium">
                                    <i class="fas fa-user-circle me-1"></i> {{ __('Profile Image') }}
                                </label>
                                <input id="profile_image" type="file" 
                                    class="form-control rounded-pill border-light bg-light @error('profile_image') is-invalid @enderror" 
                                    name="profile_image">
                                
                                @error('profile_image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <div class="row g-3">
                                <!-- Title -->
                                <div class="col-md-3">
                                    <label for="title" class="form-label fw-medium">{{ __('Title') }}</label>
                                    <select id="title" 
                                        class="form-select rounded-pill border-light bg-light @error('title') is-invalid @enderror" 
                                        name="title" required>
                                        <option value="Mr." {{ old('title') == 'Mr.' ? 'selected' : '' }}>Mr.</option>
                                        <option value="Mrs." {{ old('title') == 'Mrs.' ? 'selected' : '' }}>Mrs.</option>
                                        <option value="Ms." {{ old('title') == 'Ms.' ? 'selected' : '' }}>Ms.</option>
                                        <option value="Mx." {{ old('title') == 'Mx.' ? 'selected' : '' }}>Mx.</option>
                                    </select>
                                    
                                    @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <!-- First Name -->
                                <div class="col-md-4">
                                    <label for="fname" class="form-label fw-medium">{{ __('First Name') }}</label>
                                    <input id="fname" type="text" 
                                        class="form-control rounded-pill border-light bg-light @error('fname') is-invalid @enderror" 
                                        name="fname" value="{{ old('fname') }}" required>
                                    
                                    @error('fname')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <!-- Last Name -->
                                <div class="col-md-5">
                                    <label for="lname" class="form-label fw-medium">{{ __('Last Name') }}</label>
                                    <input id="lname" type="text" 
                                        class="form-control rounded-pill border-light bg-light @error('lname') is-invalid @enderror" 
                                        name="lname" value="{{ old('lname') }}" required>
                                    
                                    @error('lname')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row g-3 mt-1">
                                <!-- Address -->
                                <div class="col-md-12">
                                    <label for="addressline" class="form-label fw-medium">{{ __('Address') }}</label>
                                    <input id="addressline" type="text" 
                                        class="form-control rounded-pill border-light bg-light @error('addressline') is-invalid @enderror" 
                                        name="addressline" value="{{ old('addressline') }}" required>
                                    
                                    @error('addressline')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row g-3 mt-1">
                                <!-- Town -->
                                <div class="col-md-6">
                                    <label for="town" class="form-label fw-medium">{{ __('Town/City') }}</label>
                                    <input id="town" type="text" 
                                        class="form-control rounded-pill border-light bg-light @error('town') is-invalid @enderror" 
                                        name="town" value="{{ old('town') }}" required>
                                    
                                    @error('town')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <!-- Phone -->
                                <div class="col-md-6">
                                    <label for="phone" class="form-label fw-medium">{{ __('Phone Number') }}</label>
                                    <input id="phone" type="text" 
                                        class="form-control rounded-pill border-light bg-light @error('phone') is-invalid @enderror" 
                                        name="phone" value="{{ old('phone') }}" required>
                                    
                                    @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <button type="button" class="btn btn-outline-secondary rounded-pill px-4" onclick="prevStep()">
                                    <i class="fas fa-arrow-left me-2"></i>Back
                                </button>
                                <button type="submit" class="btn btn-warning rounded-pill text-white fw-medium px-4">
                                    <i class="fas fa-check-circle me-2"></i>{{ __('Complete Registration') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                
                <div class="card-footer bg-light border-0 p-4 text-center">
                    <p class="mb-0">
                        Already have an account? 
                        <a href="{{ route('login') }}" class="text-decoration-none" style="color: #e65100;">
                            <i class="fas fa-sign-in-alt me-1"></i>Login here
                        </a>
                    </p>
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
    
    .bg-orange-50 {
        background-color: #fff3e0;
    }
    
    /* Progress indicator */
    .badge.bg-warning {
        background-color: #e65100 !important;
    }
    
    /* Animation for card */
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
    }
    
    /* Form focus styles */
    .form-control:focus, .form-select:focus {
        border-color: #ffb74d;
        box-shadow: 0 0 0 0.25rem rgba(255, 183, 77, 0.25);
    }
</style>

<script>
    function nextStep() {
        // Validate step 1 fields first
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const passwordConfirm = document.getElementById('password-confirm').value;

        if (!email || !password || !passwordConfirm) {
            alert('Please fill all account information fields');
            return;
        }

        if (password !== passwordConfirm) {
            alert('Passwords do not match');
            return;
        }

        document.getElementById('step1').style.display = 'none';
        document.getElementById('step2').style.display = 'block';
    }

    function prevStep() {
        document.getElementById('step2').style.display = 'none';
        document.getElementById('step1').style.display = 'block';
    }
</script>
@endsection