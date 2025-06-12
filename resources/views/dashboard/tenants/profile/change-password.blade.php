@extends('dashboard.tenants.layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Ubah Password</h3>
        <a href="{{ route('tenant.profile.index') }}" class="btn btn-outline-secondary btn-elegant">
            <i class="mdi mdi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    @if(!is_null(auth()->user()->provider_id))
        <!-- Google OAuth User Info Card -->
        <div class="card shadow-lg border-0 mb-4 google-oauth-card">
            <div class="card-header bg-transparent border-0 pb-0">
                <h5 class="card-title mb-0 fw-bold text-primary">
                    <i class="mdi mdi-google me-2"></i>
                    Akun Google OAuth
                </h5>
            </div>
            <div class="card-body pt-3">
                <div class="oauth-info-container">
                    <div class="oauth-icon-wrapper">
                        <i class="mdi mdi-google oauth-icon"></i>
                    </div>
                    <div class="oauth-content">
                        <h6 class="mb-2">Login menggunakan Google</h6>
                        <p class="text-muted mb-3">
                            Anda masuk menggunakan akun Google. Password dikelola langsung oleh Google dan tidak dapat diubah melalui sistem ini.
                        </p>
                        <div class="oauth-features">
                            <div class="feature-item">
                                <i class="mdi mdi-shield-check text-success me-2"></i>
                                <span>Keamanan tingkat tinggi</span>
                            </div>
                            <div class="feature-item">
                                <i class="mdi mdi-sync text-primary me-2"></i>
                                <span>Sinkronisasi otomatis</span>
                            </div>
                            <div class="feature-item">
                                <i class="mdi mdi-account-key text-info me-2"></i>
                                <span>Dikelola oleh Google</span>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="https://myaccount.google.com/security" target="_blank" class="btn btn-primary btn-elegant">
                                <i class="mdi mdi-open-in-new me-1"></i>
                                Kelola Password di Google
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alternative Security Settings -->
        <div class="card shadow-lg border-0 mb-4 security-card">
            <div class="card-header bg-transparent border-0 pb-0">
                <h5 class="card-title mb-0 fw-bold">
                    <i class="mdi mdi-security me-2"></i>
                    Pengaturan Keamanan Lainnya
                </h5>
            </div>
            <div class="card-body pt-3">
                <div class="security-options">
                    <div class="security-option">
                        <div class="security-option-icon">
                            <i class="mdi mdi-two-factor-authentication"></i>
                        </div>
                        <div class="security-option-content">
                            <h6>Autentikasi Dua Faktor</h6>
                            <p class="text-muted mb-0">Tingkatkan keamanan akun dengan 2FA Google</p>
                        </div>
                        <div class="security-option-action">
                            <a href="https://myaccount.google.com/signinoptions/two-step-verification" target="_blank" class="btn btn-outline-primary btn-sm">
                                Atur
                            </a>
                        </div>
                    </div>
                    <div class="security-option">
                        <div class="security-option-icon">
                            <i class="mdi mdi-account-check"></i>
                        </div>
                        <div class="security-option-content">
                            <h6>Aktivitas Akun</h6>
                            <p class="text-muted mb-0">Pantau aktivitas login dan perangkat</p>
                        </div>
                        <div class="security-option-action">
                            <a href="https://myaccount.google.com/device-activity" target="_blank" class="btn btn-outline-primary btn-sm">
                                Lihat
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Regular Password Change Card -->
        <div class="card shadow-lg border-0 mb-4 password-card">
            <div class="card-header bg-transparent border-0 pb-0">
                <h5 class="card-title mb-0 fw-bold">
                    <i class="mdi mdi-key-variant me-2"></i>
                    Ubah Password
                </h5>
                <p class="text-muted mb-0 mt-2">Pastikan password baru Anda aman dan mudah diingat</p>
            </div>
            <div class="card-body pt-3">
                <form action="{{ route('tenant.profile.change-password') }}" method="POST" id="passwordForm">
                    @csrf

                    <!-- Password Saat Ini -->
                    <div class="form-group-elegant mb-4">
                        <label for="current_password" class="form-label">
                            <i class="mdi mdi-lock-outline me-1"></i>
                            Password Saat Ini <span class="text-danger">*</span>
                        </label>
                        <div class="password-input-wrapper">
                            <input type="password" 
                                   class="form-control form-control-elegant @error('current_password') is-invalid @enderror" 
                                   id="current_password" 
                                   name="current_password" 
                                   required>
                            <button type="button" class="password-toggle" onclick="togglePassword('current_password')">
                                <i class="mdi mdi-eye-outline" id="current_password_icon"></i>
                            </button>
                        </div>
                        @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password Baru -->
                    <div class="form-group-elegant mb-4">
                        <label for="password" class="form-label">
                            <i class="mdi mdi-lock-plus-outline me-1"></i>
                            Password Baru <span class="text-danger">*</span>
                        </label>
                        <div class="password-input-wrapper">
                            <input type="password" 
                                   class="form-control form-control-elegant @error('password') is-invalid @enderror" 
                                   id="password" 
                                   name="password" 
                                   required
                                   minlength="8">
                            <button type="button" class="password-toggle" onclick="togglePassword('password')">
                                <i class="mdi mdi-eye-outline" id="password_icon"></i>
                            </button>
                        </div>
                        <small class="text-muted">Minimal 8 karakter</small>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        
                        <!-- Password Strength Indicator -->
                        <div class="password-strength mt-2" id="passwordStrength" style="display: none;">
                            <div class="strength-bar">
                                <div class="strength-fill" id="strengthFill"></div>
                            </div>
                            <small class="strength-text" id="strengthText"></small>
                        </div>
                    </div>

                    <!-- Konfirmasi Password Baru -->
                    <div class="form-group-elegant mb-4">
                        <label for="password_confirmation" class="form-label">
                            <i class="mdi mdi-lock-check-outline me-1"></i>
                            Konfirmasi Password Baru <span class="text-danger">*</span>
                        </label>
                        <div class="password-input-wrapper">
                            <input type="password" 
                                   class="form-control form-control-elegant" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   required>
                            <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                                <i class="mdi mdi-eye-outline" id="password_confirmation_icon"></i>
                            </button>
                        </div>
                        <div class="password-match mt-2" id="passwordMatch" style="display: none;">
                            <small class="match-text" id="matchText"></small>
                        </div>
                    </div>

                    <!-- Security Tips -->
                    <div class="security-tips mb-4">
                        <h6 class="fw-bold text-primary">
                            <i class="mdi mdi-shield-check-outline me-1"></i>
                            Tips Keamanan Password
                        </h6>
                        <ul class="list-unstyled security-list">
                            <li><i class="mdi mdi-check-circle-outline text-success me-2"></i>Gunakan kombinasi huruf besar dan kecil</li>
                            <li><i class="mdi mdi-check-circle-outline text-success me-2"></i>Sertakan angka dan simbol</li>
                            <li><i class="mdi mdi-check-circle-outline text-success me-2"></i>Minimal 8 karakter</li>
                            <li><i class="mdi mdi-check-circle-outline text-success me-2"></i>Hindari informasi pribadi</li>
                        </ul>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary btn-elegant btn-lg" id="submitBtn">
                            <i class="mdi mdi-key-variant me-1" id="submitIcon"></i>
                            <span id="submitText">Ubah Password</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>

<style>
.password-card, .google-oauth-card, .security-card {
    border-radius: 15px;
    border: none;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
}

/* Google OAuth Specific Styles */
.google-oauth-card {
    background: linear-gradient(135deg, #ffffff 0%, #f8f9ff 100%);
    border: 1px solid rgba(66, 133, 244, 0.1);
}

.oauth-info-container {
    display: flex;
    align-items: flex-start;
    gap: 1.5rem;
}

.oauth-icon-wrapper {
    flex-shrink: 0;
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #4285f4 0%, #34a853 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.oauth-icon {
    color: white;
    font-size: 2rem;
}

.oauth-content {
    flex: 1;
}

.oauth-features {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    margin-top: 1rem;
}

.feature-item {
    display: flex;
    align-items: center;
    font-size: 0.9rem;
}

/* Security Options */
.security-options {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.security-option {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: #f8f9ff;
    border-radius: 12px;
    border: 1px solid rgba(102, 126, 234, 0.1);
}

.security-option-icon {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
}

.security-option-content {
    flex: 1;
}

.security-option-content h6 {
    margin-bottom: 0.25rem;
    font-weight: 600;
}

.security-option-content p {
    font-size: 0.85rem;
}

/* Existing styles */
.form-group-elegant {
    margin-bottom: 1.5rem;
}

.form-label {
    font-weight: 600;
    color: #495057;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
}

.form-label i {
    color: #667eea;
}

.password-input-wrapper {
    position: relative;
}

.form-control-elegant {
    border: 2px solid #e9ecef;
    border-radius: 10px;
    padding: 0.75rem 3rem 0.75rem 1rem;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    background: #f8f9ff;
}

.form-control-elegant:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
    background: white;
    transform: translateY(-1px);
}

.password-toggle {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #6c757d;
    cursor: pointer;
    padding: 0.5rem;
    border-radius: 50%;
    transition: all 0.3s ease;
}

.password-toggle:hover {
    background: rgba(102, 126, 234, 0.1);
    color: #667eea;
}

.password-strength {
    margin-top: 0.5rem;
}

.strength-bar {
    height: 4px;
    background: #e9ecef;
    border-radius: 2px;
    overflow: hidden;
    margin-bottom: 0.25rem;
}

.strength-fill {
    height: 100%;
    transition: all 0.3s ease;
    border-radius: 2px;
}

.strength-text {
    font-size: 0.8rem;
    font-weight: 500;
}

.password-match {
    margin-top: 0.5rem;
}

.match-text {
    font-size: 0.8rem;
    font-weight: 500;
}

.security-tips {
    background: linear-gradient(135deg, #f8f9ff 0%, #e3e8ff 100%);
    border-radius: 12px;
    padding: 1.5rem;
    border: 1px solid rgba(102, 126, 234, 0.1);
}

.security-list li {
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
}

.btn-elegant {
    border-radius: 10px;
    font-weight: 600;
    padding: 0.75rem 1.5rem;
    transition: all 0.3s ease;
}

.btn-elegant:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.btn-lg.btn-elegant {
    padding: 1rem 2rem;
    font-size: 1.1rem;
}

.invalid-feedback {
    display: block;
    font-size: 0.875rem;
    color: #dc3545;
    margin-top: 0.25rem;
}

.is-invalid {
    border-color: #dc3545 !important;
}

.is-invalid:focus {
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.15) !important;
}

/* Loading Animation */
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.mdi-spin {
    animation: spin 1s linear infinite;
}

/* Responsive */
@media (max-width: 768px) {
    .btn-lg.btn-elegant {
        width: 100%;
    }
    
    .security-tips {
        padding: 1rem;
    }
    
    .oauth-info-container {
        flex-direction: column;
        text-align: center;
    }
    
    .security-option {
        flex-direction: column;
        text-align: center;
        gap: 0.75rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Only initialize password functionality for non-Google OAuth users
    if (!document.querySelector('.google-oauth-card')) {
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('password_confirmation');
        const passwordStrength = document.getElementById('passwordStrength');
        const strengthFill = document.getElementById('strengthFill');
        const strengthText = document.getElementById('strengthText');
        const passwordMatch = document.getElementById('passwordMatch');
        const matchText = document.getElementById('matchText');

        // Password strength checker
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            const strength = checkPasswordStrength(password);
            
            if (password.length > 0) {
                passwordStrength.style.display = 'block';
                updateStrengthIndicator(strength);
            } else {
                passwordStrength.style.display = 'none';
            }
            
            checkPasswordMatch();
        });

        // Password match checker
        confirmPasswordInput.addEventListener('input', checkPasswordMatch);

        function checkPasswordStrength(password) {
            let score = 0;
            
            if (password.length >= 8) score++;
            if (/[a-z]/.test(password)) score++;
            if (/[A-Z]/.test(password)) score++;
            if (/[0-9]/.test(password)) score++;
            if (/[^A-Za-z0-9]/.test(password)) score++;
            
            return score;
        }

        function updateStrengthIndicator(strength) {
            const colors = ['#dc3545', '#fd7e14', '#ffc107', '#20c997', '#28a745'];
            const texts = ['Sangat Lemah', 'Lemah', 'Sedang', 'Kuat', 'Sangat Kuat'];
            const widths = ['20%', '40%', '60%', '80%', '100%'];
            
            strengthFill.style.width = widths[strength - 1] || '0%';
            strengthFill.style.backgroundColor = colors[strength - 1] || '#e9ecef';
            strengthText.textContent = texts[strength - 1] || '';
            strengthText.style.color = colors[strength - 1] || '#6c757d';
        }

        function checkPasswordMatch() {
            const password = passwordInput.value;
            const confirmPassword = confirmPasswordInput.value;
            
            if (confirmPassword.length > 0) {
                passwordMatch.style.display = 'block';
                
                if (password === confirmPassword) {
                    matchText.textContent = 'Password cocok';
                    matchText.className = 'match-text text-success';
                    matchText.innerHTML = '<i class="mdi mdi-check-circle-outline me-1"></i>Password cocok';
                } else {
                    matchText.textContent = 'Password tidak cocok';
                    matchText.className = 'match-text text-danger';
                    matchText.innerHTML = '<i class="mdi mdi-close-circle-outline me-1"></i>Password tidak cocok';
                }
            } else {
                passwordMatch.style.display = 'none';
            }
        }

        // Loading state untuk form submit
        const form = document.getElementById('passwordForm');
        const submitBtn = document.getElementById('submitBtn');
        const submitIcon = document.getElementById('submitIcon');
        const submitText = document.getElementById('submitText');

        form.addEventListener('submit', function(e) {
            // Ubah tampilan tombol menjadi loading
            submitBtn.disabled = true;
            submitBtn.classList.add('disabled');
            
            // Ubah icon menjadi loading spinner
            submitIcon.className = 'mdi mdi-loading mdi-spin me-1';
            submitText.textContent = 'Mengubah...';
            
            // Optional: Tambahkan cursor loading pada body
            document.body.style.cursor = 'wait';
        });
    }
});

// Toggle password visibility (only for non-Google OAuth users)
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = document.getElementById(fieldId + '_icon');
    
    if (field && icon) {
        if (field.type === 'password') {
            field.type = 'text';
            icon.className = 'mdi mdi-eye-off-outline';
        } else {
            field.type = 'password';
            icon.className = 'mdi mdi-eye-outline';
        }
    }
}
</script>
@endsection