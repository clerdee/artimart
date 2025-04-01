@extends('layouts.app')

@section('content')
<div class="container" style="padding-top: 3rem;">
    <div class="col-md-8 mx-auto">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header text-center" style="background-color: #b3d9ff; color: #003d80; font-weight: bold; font-size: 1.5rem;">
                {{ __('Register') }}
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" id="registrationForm">
                    @csrf

                    <!-- Step 1: Account Information -->
                    <div id="step1">
                        <h5 class="mb-4 text-primary">Account Information</h5>
                        
                        <!-- Email -->
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end text-primary">{{ __('Email') }}</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control border-primary @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end text-primary">{{ __('Password') }}</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control border-primary @error('password') is-invalid @enderror" name="password" required>
                                @error('password')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end text-primary">{{ __('Confirm Password') }}</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control border-primary" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="button" class="btn btn-primary w-100" onclick="nextStep()">
                                    Continue <i class="bi bi-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Personal Information -->
                    <div id="step2" style="display: none;">
                        <h5 class="mb-4 text-primary">Personal Information</h5>
                        
                        <!-- Profile Image -->
                        <div class="row mb-3">
                            <label for="profile_image" class="col-md-4 col-form-label text-md-end text-primary">
                                <i class="bi bi-person-circle"></i> {{ __('Profile Image') }}
                            </label>
                            <div class="col-md-6">
                                <input id="profile_image" type="file" class="form-control border-primary @error('profile_image') is-invalid @enderror" name="profile_image">
                                @error('profile_image')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        <!-- Title -->
                        <div class="row mb-3">
                            <label for="title" class="col-md-4 col-form-label text-md-end text-primary">{{ __('Title') }}</label>
                            <div class="col-md-6">
                                <select id="title" class="form-control border-primary @error('title') is-invalid @enderror" name="title" required>
                                    <option value="Mr." {{ old('title') == 'Mr.' ? 'selected' : '' }}>Mr.</option>
                                    <option value="Mrs." {{ old('title') == 'Mrs.' ? 'selected' : '' }}>Mrs.</option>
                                    <option value="Ms." {{ old('title') == 'Ms.' ? 'selected' : '' }}>Ms.</option>
                                    <option value="Mx." {{ old('title') == 'Mx.' ? 'selected' : '' }}>Mx.</option>
                                </select>
                                @error('title')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        <!-- First Name -->
                        <div class="row mb-3">
                            <label for="fname" class="col-md-4 col-form-label text-md-end text-primary">{{ __('First Name') }}</label>
                            <div class="col-md-6">
                                <input id="fname" type="text" class="form-control border-primary @error('fname') is-invalid @enderror" name="fname" value="{{ old('fname') }}" required>
                                @error('fname')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        <!-- Last Name -->
                        <div class="row mb-3">
                            <label for="lname" class="col-md-4 col-form-label text-md-end text-primary">{{ __('Last Name') }}</label>
                            <div class="col-md-6">
                                <input id="lname" type="text" class="form-control border-primary @error('lname') is-invalid @enderror" name="lname" value="{{ old('lname') }}" required>
                                @error('lname')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="row mb-3">
                            <label for="addressline" class="col-md-4 col-form-label text-md-end text-primary">{{ __('Address') }}</label>
                            <div class="col-md-6">
                                <input id="addressline" type="text" class="form-control border-primary @error('addressline') is-invalid @enderror" name="addressline" value="{{ old('addressline') }}" required>
                                @error('addressline')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        <!-- Town -->
                        <div class="row mb-3">
                            <label for="town" class="col-md-4 col-form-label text-md-end text-primary">{{ __('Town/City') }}</label>
                            <div class="col-md-6">
                                <input id="town" type="text" class="form-control border-primary @error('town') is-invalid @enderror" name="town" value="{{ old('town') }}" required>
                                @error('town')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="row mb-3">
                            <label for="phone" class="col-md-4 col-form-label text-md-end text-primary">{{ __('Phone Number') }}</label>
                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control border-primary @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required>
                                @error('phone')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4 d-flex justify-content-between">
                                <button type="button" class="btn btn-outline-primary" onclick="prevStep()">
                                    <i class="bi bi-arrow-left"></i> Back
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle"></i> {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

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