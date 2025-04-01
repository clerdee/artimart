@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center" style="padding-top: 3rem;">
    <div class="col-md-6">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header text-center" style="background-color: #b3d9ff; color: #003d80; font-weight: bold; font-size: 1.5rem;">
                {{ __('Login') }}
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label text-primary">{{ __('Email Address') }}</label>
                        <input id="email" type="email" class="form-control border-primary @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label text-primary">{{ __('Password') }}</label>
                        <input id="password" type="password" class="form-control border-primary @error('password') is-invalid @enderror" name="password" required>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3 form-check">
                        <input class="form-check-input border-primary" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label text-primary" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn" style="background-color: #003d80; color: #ffffff;">{{ __('Login') }}</button>
                        @if (Route::has('password.request'))
                            <a class="btn btn-link text-decoration-none" style="color: #003d80;" href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection