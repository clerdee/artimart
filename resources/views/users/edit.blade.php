@extends('layouts.base')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0 font-weight-bold">Your Profile</h3>
                </div>
                
                <div class="card-body">
                    @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <!-- Nav Tabs -->
                    <ul class="nav nav-tabs mb-4" id="profileTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-content" 
                                type="button" role="tab" aria-controls="profile-content" aria-selected="true">
                                <i class="fas fa-user me-2"></i>Profile Information
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="security-tab" data-bs-toggle="tab" data-bs-target="#security-content" 
                                type="button" role="tab" aria-controls="security-content" aria-selected="false">
                                <i class="fas fa-shield-alt me-2"></i>Security Settings
                            </button>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content" id="profileTabsContent">
                        <!-- Profile Information Tab -->
                        <div class="tab-pane fade show active" id="profile-content" role="tabpanel" aria-labelledby="profile-tab">
                            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                
                                <div class="row align-items-start">
                                    <!-- Profile Image Section -->
                                    <div class="col-md-4 text-center mb-4">
                                        <div class="profile-image-container position-relative mx-auto" style="width: 180px;">
                                            <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Profile Image" 
                                                class="img-thumbnail rounded-circle shadow mb-3" width="180" height="180">
                                            <label for="profile_image_upload" class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle p-2 shadow cursor-pointer">
                                                <i class="fas fa-camera"></i>
                                                <input type="file" id="profile_image_upload" name="profile_image" class="d-none">
                                            </label>
                                        </div>
                                        <p class="text-muted small">Click the camera icon to update your profile picture</p>
                                    </div>
                                    
                                    <!-- Profile Details Section -->
                                    <div class="col-md-8">
                                        <div class="row g-3">
                                            <!-- Title -->
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">Title</label>
                                                <select class="form-select" name="title">
                                                    <option value="Mr." {{ old('title', $customer->title) == 'Mr.' ? 'selected' : '' }}>Mr.</option>
                                                    <option value="Mrs." {{ old('title', $customer->title) == 'Mrs.' ? 'selected' : '' }}>Mrs.</option>
                                                    <option value="Ms." {{ old('title', $customer->title) == 'Ms.' ? 'selected' : '' }}>Ms.</option>
                                                    <option value="Dr." {{ old('title', $customer->title) == 'Dr.' ? 'selected' : '' }}>Dr.</option>
                                                    <option value="Prof." {{ old('title', $customer->title) == 'Prof.' ? 'selected' : '' }}>Prof.</option>
                                                </select>
                                            </div>
                                            
                                            <!-- First Name -->
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">First Name</label>
                                                <input type="text" class="form-control" name="fname" value="{{ old('fname', $customer->fname) }}" required>
                                            </div>
                                            
                                            <!-- Last Name -->
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">Last Name</label>
                                                <input type="text" class="form-control" name="lname" value="{{ old('lname', $customer->lname) }}" required>
                                            </div>
                                            
                                            <!-- Address -->
                                            <div class="col-md-12">
                                                <label class="form-label fw-bold">Address</label>
                                                <input type="text" class="form-control" name="address" value="{{ old('address', $customer->addressline) }}" required>
                                            </div>
                                            
                                            <!-- Town -->
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Town</label>
                                                <input type="text" class="form-control" name="town" value="{{ old('town', $customer->town) }}" required>
                                            </div>
                                            
                                            <!-- Phone -->
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Phone</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                                    <input type="tel" class="form-control" name="phone" value="{{ old('phone', $customer->phone) }}" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                                    <button type="button" class="btn btn-outline-secondary">Cancel</button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Save Changes
                                    </button>
                                </div>
                            </form>
                        </div>
                        
                        <!-- Security Settings Tab -->
                        <div class="tab-pane fade" id="security-content" role="tabpanel" aria-labelledby="security-tab">
                            <form action="{{ route('profile.security') }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="row g-3">
                                    <!-- Email -->
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold">Email Address</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                            <input type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}" required>
                                        </div>
                                    </div>
                                    
                                    <div class="col-12">
                                        <hr class="my-4">
                                        <h5 class="mb-3">Change Password</h5>
                                    </div>
                                    
                                    <!-- Current Password -->
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold">Current Password</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                            <input type="password" class="form-control password-field" name="current_password" required>
                                            <button class="btn btn-outline-secondary toggle-password" type="button">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <!-- New Password -->
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">New Password</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                                            <input type="password" class="form-control password-field" name="password">
                                            <button class="btn btn-outline-secondary toggle-password" type="button">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                        <div class="form-text">Leave blank to keep your current password</div>
                                    </div>
                                    
                                    <!-- Confirm New Password -->
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Confirm New Password</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-check-double"></i></span>
                                            <input type="password" class="form-control password-field" name="password_confirmation">
                                            <button class="btn btn-outline-secondary toggle-password" type="button">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                                    <button type="button" class="btn btn-outline-secondary">Cancel</button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-shield-alt me-2"></i>Update Security
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Initialize Bootstrap tabs
    document.addEventListener('DOMContentLoaded', function() {
        const triggerTabList = [].slice.call(document.querySelectorAll('#profileTabs button'));
        triggerTabList.forEach(function (triggerEl) {
            const tabTrigger = new bootstrap.Tab(triggerEl);
            triggerEl.addEventListener('click', function (event) {
                event.preventDefault();
                tabTrigger.show();
            });
        });
        
        // Show selected profile image filename
        document.getElementById('profile_image_upload').addEventListener('change', function() {
            const fileName = this.files[0]?.name;
            if (fileName) {
                const fileNameDisplay = document.createElement('div');
                fileNameDisplay.className = 'mt-2 text-success small';
                fileNameDisplay.textContent = `Selected: ${fileName}`;
                this.parentElement.parentElement.appendChild(fileNameDisplay);
            }
        });
        
        // Toggle password visibility
        const toggleButtons = document.querySelectorAll('.toggle-password');
        toggleButtons.forEach(button => {
            button.addEventListener('click', function() {
                const passwordField = this.previousElementSibling;
                const icon = this.querySelector('i');
                
                if (passwordField.type === 'password') {
                    passwordField.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    passwordField.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        });
    });
</script>
@endsection