@extends('layouts.base')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Profile</div>
                <div class="card-body">
                    @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif

                    <!-- Toggle Buttons -->
                    <div class="d-flex justify-content-between mb-3">
                        <button class="btn btn-primary" id="showProfile">Profile Info</button>
                        <button class="btn btn-secondary" id="showSecurity">Security Settings</button>
                    </div>

                    <!-- Profile Information Form -->
                    <div id="profileSection">
                        <h4>Profile Information</h4>
                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Profile Image -->
                            <div class="mb-3 text-center">
                                <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Profile Image" class="rounded-circle mb-3" width="150">
                                <input type="file" class="form-control" name="profile_image">
                            </div>

                            <!-- Title -->
                            <div class="mb-3">
                                <label class="form-label">Title</label>
                                <input type="text" class="form-control" name="title" value="{{ old('title', $customer->title) }}" required>
                            </div>

                            <!-- First Name -->
                            <div class="mb-3">
                                <label class="form-label">First Name</label>
                                <input type="text" class="form-control" name="fname" value="{{ old('fname', $customer->fname) }}" required>
                            </div>

                            <!-- Last Name -->
                            <div class="mb-3">
                                <label class="form-label">Last Name</label>
                                <input type="text" class="form-control" name="lname" value="{{ old('lname', $customer->lname) }}" required>
                            </div>

                            <!-- Address -->
                            <div class="mb-3">
                                <label class="form-label">Address</label>
                                <input type="text" class="form-control" name="address" value="{{ old('address', $customer->addressline) }}" required>
                            </div>

                            <!-- Town -->
                            <div class="mb-3">
                                <label class="form-label">Town</label>
                                <input type="text" class="form-control" name="town" value="{{ old('town', $customer->town) }}" required>
                            </div>

                            <!-- Phone -->
                            <div class="mb-3">
                                <label class="form-label">Phone</label>
                                <input type="text" class="form-control" name="phone" value="{{ old('phone', $customer->phone) }}" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Update Profile</button>
                        </form>
                    </div>

                    <!-- Security Settings Form -->
                    <div id="securitySection" style="display: none;">
                        <h4>Security Settings</h4>
                        <form action="{{ route('profile.security') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Email -->
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}" required>
                            </div>

                            <!-- Old Password (Required for updates) -->
                            <div class="mb-3">
                                <label class="form-label">Current Password</label>
                                <input type="password" class="form-control" name="current_password" required>
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label class="form-label">New Password</label>
                                <input type="password" class="form-control" name="password">
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-3">
                                <label class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" name="password_confirmation">
                            </div>

                            <button type="submit" class="btn btn-danger">Update Security</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById("showProfile").addEventListener("click", function() {
        document.getElementById("profileSection").style.display = "block";
        document.getElementById("securitySection").style.display = "none";
    });

    document.getElementById("showSecurity").addEventListener("click", function() {
        document.getElementById("securitySection").style.display = "block";
        document.getElementById("profileSection").style.display = "none";
    });
</script>
@endsection