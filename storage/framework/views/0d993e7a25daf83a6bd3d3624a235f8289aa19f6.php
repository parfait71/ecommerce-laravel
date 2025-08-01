<?php $__env->startSection('title', 'Inscription - EazyStore'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen flex items-center justify-center bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-blue-600 bg-blue-100 px-6 py-3 rounded-full inline-block shadow-lg border border-blue-200">
                Créez votre compte
            </h2>
            <p class="mt-4 text-center text-sm text-gray-600">
                <a href="<?php echo e(route('login')); ?>" class="bg-blue-600 text-white px-4 py-2 rounded-full font-medium hover:bg-blue-700 transition-colors duration-200 inline-block shadow-md border border-blue-500">
                    Ou connectez-vous à votre compte existant
                </a>
            </p>
        </div>
        <form class="mt-8 space-y-6" action="<?php echo e(route('register')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="rounded-md shadow-sm -space-y-px">
                <div>
                    <label for="name" class="sr-only">Nom</label>
                    <input id="name" name="name" type="text" autocomplete="name" required 
                           class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 bg-white rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" 
                           placeholder="Nom complet" value="<?php echo e(old('name')); ?>">
                </div>
                <div>
                    <label for="email" class="sr-only">Adresse email</label>
                    <input id="email" name="email" type="email" autocomplete="email" required 
                           class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 bg-white focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" 
                           placeholder="Adresse email" value="<?php echo e(old('email')); ?>">
                </div>
                <div>
                    <label for="password" class="sr-only">Mot de passe</label>
                    <input id="password" name="password" type="password" autocomplete="new-password" required 
                           class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 bg-white focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" 
                           placeholder="Mot de passe">
                </div>
                <div>
                    <label for="password_confirmation" class="sr-only">Confirmer le mot de passe</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required 
                           class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 bg-white rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" 
                           placeholder="Confirmer le mot de passe">
                </div>
            </div>

            <!-- Indicateur de force du mot de passe -->
            <div id="password-strength" class="block">
                <div class="flex items-center space-x-2 mb-2">
                    <span class="text-sm text-gray-600">Force du mot de passe :</span>
                    <span id="strength-text" class="text-sm font-medium">Tapez votre mot de passe</span>
                </div>
                <div class="w-1/2 bg-gray-200 rounded-full h-2 border border-gray-300">
                    <div id="strength-bar" class="h-2 rounded-full transition-all duration-300 bg-gray-300" style="width: 0%; min-width: 10px;"></div>
                </div>
            </div>

            <div class="flex justify-center">
                <button type="submit" 
                        class="!bg-blue-600 !hover:bg-blue-700 !text-white !font-semibold !rounded-full !shadow-lg !px-8 !py-3 !border-0 !transition-all !duration-200 !transform hover:!scale-105 focus:!outline-none focus:!ring-2 focus:!ring-blue-500 focus:!ring-offset-2">
                    Créer un compte
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Attendre que le DOM soit chargé
document.addEventListener('DOMContentLoaded', function() {
    console.log('Script de force du mot de passe chargé');
    
    const passwordInput = document.getElementById('password');
    const passwordStrength = document.getElementById('password-strength');
    const strengthText = document.getElementById('strength-text');
    const strengthBar = document.getElementById('strength-bar');
    
    // Vérifier que les éléments existent
    if (!passwordInput || !passwordStrength || !strengthText || !strengthBar) {
        console.error('Éléments de force du mot de passe non trouvés');
        return;
    }
    
    console.log('Éléments trouvés, ajout de l\'écouteur d\'événement');
    
    // Fonction pour calculer la force
    function calculatePasswordStrength(password) {
        let strength = 0;
        
        // Longueur
        if (password.length >= 1) strength += 1;
        if (password.length >= 2) strength += 1;
        if (password.length >= 3) strength += 1;
        if (password.length >= 4) strength += 1;
        if (password.length >= 5) strength += 1;
        if (password.length >= 6) strength += 1;
        
        return strength;
    }
    
    // Fonction pour obtenir le niveau et la couleur
    function getStrengthLevel(strength) {
        if (strength <= 3) return { text: 'Faible', color: 'bg-red-500', textColor: 'text-red-600' };
        if (strength <= 5) return { text: 'Moyen', color: 'bg-yellow-500', textColor: 'text-yellow-600' };
        return { text: 'Fort', color: 'bg-green-500', textColor: 'text-green-600' };
    }
    
    // Écouteur d'événement
    passwordInput.addEventListener('input', function() {
        console.log('Tape dans le mot de passe:', this.value);
        
        const password = this.value;
        
        if (password.length === 0) {
            passwordStrength.classList.add('hidden');
            return;
        }
        
        // Afficher l'indicateur
        passwordStrength.classList.remove('hidden');
        
        // Calculer la force
        const strength = calculatePasswordStrength(password);
        const level = getStrengthLevel(strength);
        
        console.log('Force calculée:', strength, 'Niveau:', level.text);
        
        // Mettre à jour le texte
        strengthText.textContent = level.text;
        strengthText.className = `text-sm font-medium`;
        
        // Forcer la couleur du texte avec styles inline
        if (level.textColor.includes('red')) {
            strengthText.style.color = '#dc2626';
        } else if (level.textColor.includes('yellow')) {
            strengthText.style.color = '#ca8a04';
        } else if (level.textColor.includes('green')) {
            strengthText.style.color = '#16a34a';
        }
        
        // Mettre à jour la barre
        strengthBar.className = `h-2 rounded-full transition-all duration-300`;
        strengthBar.style.width = `${Math.min((strength / 6) * 100, 100)}%`;
        
        // Forcer les couleurs avec styles inline
        if (level.color === 'bg-red-500') {
            strengthBar.style.backgroundColor = '#ef4444';
        } else if (level.color === 'bg-yellow-500') {
            strengthBar.style.backgroundColor = '#eab308';
        } else if (level.color === 'bg-green-500') {
            strengthBar.style.backgroundColor = '#22c55e';
        }
    });
    
    // Écouteur pour le champ de confirmation aussi
    const passwordConfirm = document.getElementById('password_confirmation');
    if (passwordConfirm) {
        passwordConfirm.addEventListener('input', function() {
            const password = passwordInput.value;
            if (password.length > 0) {
                // Déclencher la mise à jour de la force
                passwordInput.dispatchEvent(new Event('input'));
            }
        });
    }
});
</script>

<style>
/* Améliorations subtiles */
input:focus {
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
}

button:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

/* Style forcé pour le bouton de création de compte */
button[type="submit"] {
    background-color: #2563eb !important;
    color: white !important;
    font-weight: 600 !important;
    border-radius: 9999px !important;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05) !important;
    padding: 12px 32px !important;
    border: none !important;
    transition: all 0.2s ease-in-out !important;
}

button[type="submit"]:hover {
    background-color: #1d4ed8 !important;
    transform: scale(1.05) !important;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04) !important;
}

/* Styles pour la barre de force du mot de passe */
#strength-bar {
    transition: all 0.3s ease-in-out !important;
}

#strength-bar[style*="background-color: #ef4444"] {
    background-color: #ef4444 !important;
}

#strength-bar[style*="background-color: #eab308"] {
    background-color: #eab308 !important;
}

#strength-bar[style*="background-color: #22c55e"] {
    background-color: #22c55e !important;
}

/* Styles pour le texte de force */
#strength-text[style*="color: #dc2626"] {
    color: #dc2626 !important;
}

#strength-text[style*="color: #ca8a04"] {
    color: #ca8a04 !important;
}

#strength-text[style*="color: #16a34a"] {
    color: #16a34a !important;
}

/* Styles pour l'indicateur de force du mot de passe */
#password-strength {
    margin-top: 1rem !important;
    padding: 1rem !important;
    background: #f8fafc !important;
    border-radius: 0.5rem !important;
    border: 1px solid #e2e8f0 !important;
}

#strength-bar {
    height: 8px !important;
    border-radius: 4px !important;
    transition: all 0.3s ease-in-out !important;
    min-width: 20px !important;
}

/* Animation d'entrée subtile */
.max-w-md {
    animation: fadeInUp 0.5s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Transitions fluides */
* {
    transition: all 0.2s ease-in-out;
}

/* Styles pour le titre et le lien */
h2 {
    background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%) !important;
    color: #2563eb !important;
    border-radius: 9999px !important;
    box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.1), 0 4px 6px -2px rgba(59, 130, 246, 0.05) !important;
    border: 2px solid #93c5fd !important;
}

a[href*="login"] {
    background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%) !important;
    color: white !important;
    border-radius: 9999px !important;
    box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.1), 0 2px 4px -1px rgba(37, 99, 235, 0.06) !important;
    border: 2px solid #1d4ed8 !important;
    transition: all 0.2s ease-in-out !important;
}

a[href*="login"]:hover {
    background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%) !important;
    transform: translateY(-1px) !important;
    box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.2), 0 4px 6px -2px rgba(37, 99, 235, 0.1) !important;
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\EazyStore\resources\views/auth/register.blade.php ENDPATH**/ ?>