<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-label for="name" value="Nom complet" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-label for="email" value="Adresse Email" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4 relative">
            <x-label for="password" value="Mot de passe" />
            <input id="password" class="block mt-1 w-full pr-10" type="password" name="password" required autocomplete="new-password" oninput="updateStrength(this.value)" />
            <span onclick="const pwd=document.getElementById('password');pwd.type=pwd.type==='password'?'text':'password';this.innerHTML=pwd.type==='password'?eye:eyeOff;" style="position:absolute;top:2.5rem;right:1rem;cursor:pointer;">
                <script>
                  var eye = `<svg xmlns='http://www.w3.org/2000/svg' class='h-5 w-5' fill='none' viewBox='0 0 24 24' stroke='currentColor'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M15 12a3 3 0 11-6 0 3 3 0 016 0z' /><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z' /></svg>`;
                  var eyeOff = `<svg xmlns='http://www.w3.org/2000/svg' class='h-5 w-5' fill='none' viewBox='0 0 24 24' stroke='currentColor'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.956 9.956 0 012.293-3.95m3.36-2.676A9.956 9.956 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.965 9.965 0 01-4.293 5.032M15 12a3 3 0 11-6 0 3 3 0 016 0z' /><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M3 3l18 18' /></svg>`;
                  document.currentScript.parentElement.innerHTML = eye;
                </script>
            </span>
            <div id="password-strength-bar" class="h-2 w-full rounded mt-2 bg-gray-200">
                <div id="password-strength-fill" class="h-2 rounded transition-all duration-300 bg-gray-200" style="width:25%"></div>
            </div>
            <div id="password-strength-text" class="mt-1 text-xs font-semibold text-gray-400">Password strength</div>
            <div class="mt-1 text-xs text-gray-500">Utilisez au moins 6 caractères, une majuscule, un chiffre…</div>
            <script>
                function updateStrength(pwd) {
                    const bar = document.getElementById('password-strength-fill');
                    const text = document.getElementById('password-strength-text');
                    let level = 0;
                    if (pwd.length >= 6) level = 2;
                    else if (pwd.length >= 4) level = 1;
                    // Couleurs et labels pour 3 niveaux
                    let widths = ["33%", "66%", "100%"];
                    let colors = ["bg-red-500", "bg-yellow-400", "bg-green-500"];
                    let textColors = ["#dc2626", "#ca8a04", "#16a34a"];
                    let labels = ["Faible", "Moyen", "Fort"];
                    bar.className = `h-2 rounded transition-all duration-300 ${colors[level]}`;
                    bar.style.width = widths[level];
                    text.textContent = pwd ? labels[level] : 'Password strength';
                    text.className = `mt-1 text-xs font-semibold`;
                    text.style.color = pwd ? textColors[level] : '#9ca3af';
                }
            </script>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4 relative">
            <x-label for="password_confirmation" value="Confirmer le mot de passe" />
            <input id="password_confirmation" class="block mt-1 w-full pr-10" type="password" name="password_confirmation" required autocomplete="new-password" />
            <span onclick="const pwd=document.getElementById('password_confirmation');pwd.type=pwd.type==='password'?'text':'password';this.innerHTML=pwd.type==='password'?eye:eyeOff;" style="position:absolute;top:2.5rem;right:1rem;cursor:pointer;">
                <script>
                  document.currentScript.parentElement.innerHTML = eye;
                </script>
            </span>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>
            <button type="submit" style="margin-left: 1rem; padding: 0.5rem 1.5rem; background: #2563eb; color: white; border: none; border-radius: 0.375rem; font-weight: bold; font-size: 1rem;">
                Créer un compte
            </button>
        </div>
    </form>
</x-guest-layout>
