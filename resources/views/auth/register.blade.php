<x-guest-layout>
    <div class="register-container" data-aos="fade-up">
        <div class="register-header">
            <h2 class="register-title">
                <i class="fas fa-user-plus me-2"></i>Créer votre compte
            </h2>
            <p class="register-subtitle">Rejoignez EazyStore et commencez vos achats en toute simplicité</p>
        </div>

        <form method="POST" action="{{ route('register') }}" id="registerForm" class="register-form">
            @csrf

            <!-- Nom complet -->
            <div class="form-group" data-aos="fade-up" data-aos-delay="100">
                <label for="name" class="form-label">
                    <i class="fas fa-user me-2"></i>Nom complet
                </label>
                <div class="input-group">
                    <i class="fas fa-user input-icon"></i>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           class="form-control input-with-icon @error('name') error @enderror"
                           value="{{ old('name') }}" 
                           placeholder="Votre nom complet"
                           required 
                           autofocus 
                           autocomplete="name">
                </div>
                @error('name')
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Email -->
            <div class="form-group" data-aos="fade-up" data-aos-delay="200">
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
                           autocomplete="username">
                </div>
                @error('email')
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $message }}
                    </div>
                @enderror
        </div>

            <!-- Mot de passe -->
            <div class="form-group" data-aos="fade-up" data-aos-delay="300">
                <label for="password" class="form-label">
                    <i class="fas fa-lock me-2"></i>Mot de passe
                </label>
                <div class="input-group">
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" 
                           id="password" 
                          name="password"
                           class="form-control input-with-icon @error('password') error @enderror"
                           placeholder="Créez un mot de passe sécurisé"
                           required 
                           autocomplete="new-password">
                    <button type="button" class="password-toggle" onclick="togglePassword('password')">
                        <i class="fas fa-eye" id="password-eye"></i>
                    </button>
        </div>

                <!-- Indicateur de force du mot de passe -->
                <div class="password-strength" id="password-strength" style="display: none;">
                    <div class="strength-meter">
                        <div class="strength-fill" id="strength-fill"></div>
                    </div>
                    <div class="strength-text" id="strength-text"></div>
        </div>

                @error('password')
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Confirmation du mot de passe -->
            <div class="form-group" data-aos="fade-up" data-aos-delay="400">
                <label for="password_confirmation" class="form-label">
                    <i class="fas fa-lock me-2"></i>Confirmer le mot de passe
                </label>
                <div class="input-group">
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" 
                           id="password_confirmation" 
                           name="password_confirmation" 
                           class="form-control input-with-icon"
                           placeholder="Confirmez votre mot de passe"
                           required 
                           autocomplete="new-password">
                    <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                        <i class="fas fa-eye" id="password_confirmation-eye"></i>
                    </button>
                </div>
                @error('password_confirmation')
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Conditions d'utilisation -->
            <div class="form-group" data-aos="fade-up" data-aos-delay="500">
                <div class="terms-checkbox">
                    <input type="checkbox" id="terms" name="terms" required>
                    <label for="terms" class="terms-label">
                        J'accepte les <a href="#" class="terms-link">conditions d'utilisation</a> et la 
                        <a href="#" class="terms-link">politique de confidentialité</a>
                    </label>
                </div>
            </div>

            <!-- Bouton de soumission -->
            <div class="form-group" data-aos="fade-up" data-aos-delay="600">
                <button type="submit" class="btn-primary" id="registerBtn">
                    <i class="fas fa-user-plus me-2"></i>Créer mon compte
                </button>
            </div>
        </form>

        <!-- Footer -->
        <div class="auth-footer" data-aos="fade-up" data-aos-delay="700">
            <p class="mb-2">Vous avez déjà un compte ?</p>
            <a href="{{ route('login') }}" class="btn-outline">
                <i class="fas fa-sign-in-alt me-2"></i>Se connecter
            </a>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const passwordInput = document.getElementById('password');
        const passwordStrength = document.getElementById('password-strength');
        const strengthFill = document.getElementById('strength-fill');
        const strengthText = document.getElementById('strength-text');
        
        // Validation en temps réel du mot de passe
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            
            if (password.length > 0) {
                passwordStrength.style.display = 'block';
                const strength = checkPasswordStrength(password);
                updateStrengthIndicator(strength);
            } else {
                passwordStrength.style.display = 'none';
            }
        });
        
        // Validation du formulaire
        const form = document.getElementById('registerForm');
        const submitBtn = document.getElementById('registerBtn');
        
        form.addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const passwordConfirmation = document.getElementById('password_confirmation').value;
            const terms = document.getElementById('terms').checked;
            
            if (!terms) {
                e.preventDefault();
                alert('Veuillez accepter les conditions d\'utilisation.');
                return;
            }
            
            if (password !== passwordConfirmation) {
                e.preventDefault();
                alert('Les mots de passe ne correspondent pas.');
                return;
            }
            
            // Animation de chargement
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Création en cours...';
            submitBtn.disabled = true;
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
    
    // Fonction pour vérifier la force du mot de passe
    function checkPasswordStrength(password) {
        let score = 0;
        
        if (password.length >= 8) score++;
        if (password.match(/[a-z]/)) score++;
        if (password.match(/[A-Z]/)) score++;
        if (password.match(/[0-9]/)) score++;
        if (password.match(/[^a-zA-Z0-9]/)) score++;
        
        if (score < 2) return 'weak';
        if (score < 3) return 'fair';
        if (score < 4) return 'good';
        return 'strong';
    }
    
    // Fonction pour mettre à jour l'indicateur de force
    function updateStrengthIndicator(strength) {
        const strengthFill = document.getElementById('strength-fill');
        const strengthText = document.getElementById('strength-text');
        
        strengthFill.className = 'strength-fill strength-' + strength;
        
        const messages = {
            weak: 'Faible - Ajoutez des lettres majuscules, chiffres et symboles',
            fair: 'Moyen - Ajoutez des chiffres et symboles',
            good: 'Bon - Ajoutez des symboles pour plus de sécurité',
            strong: 'Fort - Excellent mot de passe !'
        };
        
        strengthText.textContent = messages[strength];
        strengthText.className = 'strength-text text-' + (strength === 'weak' ? 'danger' : strength === 'fair' ? 'warning' : strength === 'good' ? 'info' : 'success');
    }
    </script>

    <style>
    .register-container {
        width: 100%;
    }
    
    .register-header {
        text-align: center;
        margin-bottom: 2rem;
    }
    
    .register-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--dark-color);
        margin-bottom: 0.5rem;
    }
    
    .register-subtitle {
        color: #6c757d;
        font-size: 0.95rem;
        margin-bottom: 0;
    }
    
    .register-form {
        margin-bottom: 1rem;
    }
    
    .terms-checkbox {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
    }
    
    .terms-checkbox input[type="checkbox"] {
        margin-top: 0.25rem;
        width: 18px;
        height: 18px;
        accent-color: var(--primary-color);
    }
    
    .terms-label {
        font-size: 0.9rem;
        color: #495057;
        line-height: 1.4;
        margin-bottom: 0;
    }
    
    .terms-link {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 500;
    }
    
    .terms-link:hover {
        color: var(--secondary-color);
        text-decoration: underline;
    }
    
    .password-strength {
        margin-top: 0.75rem;
    }
    
    .strength-text {
        font-size: 0.8rem;
        margin-top: 0.5rem;
        font-weight: 500;
    }
    
    .text-danger { color: var(--danger-color) !important; }
    .text-warning { color: var(--warning-color) !important; }
    .text-info { color: #17a2b8 !important; }
    .text-success { color: var(--success-color) !important; }
    </style>
</x-guest-layout>
