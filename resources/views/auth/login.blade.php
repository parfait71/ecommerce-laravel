<x-guest-layout>
    <div class="login-container" data-aos="fade-up">
        <div class="login-header">
            <h2 class="login-title">
                <i class="fas fa-sign-in-alt me-2"></i>Connexion
            </h2>
            <p class="login-subtitle">Accédez à votre compte EazyStore</p>
        </div>

    <!-- Session Status -->
        @if (session('status'))
            <div class="alert alert-success" role="alert" data-aos="fade-up">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" id="loginForm" class="login-form">
        @csrf

        <!-- Email Address -->
            <div class="form-group" data-aos="fade-up" data-aos-delay="100">
                <label for="email" class="form-label">
                    <i class="fas fa-envelope me-2"></i>Adresse email
                </label>
                <div class="input-group">
                    <i class="fas fa-envelope input-icon"></i>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           class="form-control input-with-icon @error('email') error @enderror"
                           value="{{ old('email') }}" 
                           placeholder="votre@email.com"
                           required 
                           autofocus 
                           autocomplete="username">
                </div>
                @error('email')
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $message }}
                    </div>
                @enderror
        </div>

        <!-- Password -->
            <div class="form-group" data-aos="fade-up" data-aos-delay="200">
                <label for="password" class="form-label">
                    <i class="fas fa-lock me-2"></i>Mot de passe
                </label>
                <div class="input-group">
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" 
                           id="password" 
                          name="password"
                           class="form-control input-with-icon @error('password') error @enderror"
                           placeholder="Votre mot de passe"
                           required 
                           autocomplete="current-password">
                    <button type="button" class="password-toggle" onclick="togglePassword('password')">
                        <i class="fas fa-eye" id="password-eye"></i>
                    </button>
                </div>
                @error('password')
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $message }}
                    </div>
                @enderror
        </div>

        <!-- Remember Me -->
            <div class="form-group" data-aos="fade-up" data-aos-delay="300">
                <div class="remember-me">
                    <input type="checkbox" id="remember_me" name="remember" class="remember-checkbox">
                    <label for="remember_me" class="remember-label">
                        <i class="fas fa-check remember-icon"></i>
                        Se souvenir de moi
            </label>
        </div>
            </div>

            <!-- Bouton de connexion -->
            <div class="form-group" data-aos="fade-up" data-aos-delay="400">
                <button type="submit" class="btn-primary login-btn" id="loginBtn">
                    <i class="fas fa-sign-in-alt me-2"></i>Se connecter
                </button>
            </div>
        </form>

        <!-- Actions supplémentaires -->
        <div class="login-actions" data-aos="fade-up" data-aos-delay="500">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="forgot-password">
                    <i class="fas fa-key me-2"></i>Mot de passe oublié ?
                </a>
            @endif
        </div>

        <!-- Footer -->
        <div class="auth-footer" data-aos="fade-up" data-aos-delay="600">
            <p class="mb-2">Vous n'avez pas encore de compte ?</p>
            <a href="{{ route('register') }}" class="btn-outline">
                <i class="fas fa-user-plus me-2"></i>Créer un compte
            </a>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Validation du formulaire
        const form = document.getElementById('loginForm');
        const submitBtn = document.getElementById('loginBtn');
        
        form.addEventListener('submit', function(e) {
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value.trim();
            
            if (!email || !password) {
                e.preventDefault();
                alert('Veuillez remplir tous les champs obligatoires.');
                return;
            }
            
            // Animation de chargement
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Connexion en cours...';
            submitBtn.disabled = true;
        });
        
        // Validation en temps réel de l'email
        const emailInput = document.getElementById('email');
        emailInput.addEventListener('blur', function() {
            const email = this.value.trim();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
            if (email && !emailRegex.test(email)) {
                this.classList.add('error');
                if (!this.nextElementSibling || !this.nextElementSibling.classList.contains('error-message')) {
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'error-message';
                    errorDiv.innerHTML = '<i class="fas fa-exclamation-circle"></i>Format d\'email invalide';
                    this.parentNode.parentNode.appendChild(errorDiv);
                }
            } else {
                this.classList.remove('error');
                const errorDiv = this.parentNode.parentNode.querySelector('.error-message');
                if (errorDiv && errorDiv.textContent.includes('Format d\'email invalide')) {
                    errorDiv.remove();
                }
            }
        });
    });
    
    // Fonction pour basculer la visibilité du mot de passe
    function togglePassword(inputId) {
        const input = document.getElementById(inputId);
        const eye = document.getElementById(inputId + '-eye');
        
        if (input.type === 'password') {
            input.type = 'text';
            eye.className = 'fas fa-eye-slash';
        } else {
            input.type = 'password';
            eye.className = 'fas fa-eye';
        }
    }
    </script>

    <style>
    .login-container {
        width: 100%;
    }
    
    .login-header {
        text-align: center;
        margin-bottom: 2rem;
    }
    
    .login-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--dark-color);
        margin-bottom: 0.5rem;
    }
    
    .login-subtitle {
        color: #6c757d;
        font-size: 0.95rem;
        margin-bottom: 0;
    }
    
    .login-form {
        margin-bottom: 1rem;
    }
    
    .login-btn {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        border: none;
        border-radius: 12px;
        padding: 1rem 2rem;
        font-weight: 700;
        font-size: 1.1rem;
        color: white;
        transition: all 0.3s ease;
        cursor: pointer;
        width: 100%;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        position: relative;
        overflow: hidden;
    }
    
    .login-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }
    
    .login-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
    }
    
    .login-btn:hover::before {
        left: 100%;
    }
    
    .login-btn:active {
        transform: translateY(-1px);
    }
    
    .login-btn:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        transform: none;
    }
    
    .remember-me {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .remember-checkbox {
        width: 20px;
        height: 20px;
        accent-color: var(--primary-color);
        cursor: pointer;
    }
    
    .remember-label {
        font-size: 0.9rem;
        color: #495057;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        user-select: none;
    }
    
    .remember-icon {
        font-size: 0.8rem;
        color: var(--primary-color);
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .remember-checkbox:checked + .remember-label .remember-icon {
        opacity: 1;
    }
    
    .login-actions {
        text-align: center;
        margin: 1.5rem 0;
    }
    
    .forgot-password {
        color: var(--primary-color);
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 500;
        transition: color 0.3s ease;
    }
    
    .forgot-password:hover {
        color: var(--secondary-color);
        text-decoration: underline;
    }
    
    .alert {
        padding: 1rem;
        border-radius: 12px;
        margin-bottom: 1.5rem;
        border: none;
        font-weight: 500;
    }
    
    .alert-success {
        background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
        color: #155724;
        border-left: 4px solid var(--success-color);
    }
    
    .alert-danger {
        background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
        color: #721c24;
        border-left: 4px solid var(--danger-color);
    }
    
    @media (max-width: 576px) {
        .login-title {
            font-size: 1.5rem;
        }
        
        .login-btn {
            padding: 0.9rem 1.5rem;
            font-size: 1rem;
        }
    }
    </style>
</x-guest-layout>
