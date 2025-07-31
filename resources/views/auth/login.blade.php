<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-label for="email" value="Adresse Email" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4 relative">
            <x-label for="password" value="Mot de passe" />
            <input id="password" class="block mt-1 w-full pr-10" type="password" name="password" required autocomplete="current-password" />
            <span onclick="const pwd=document.getElementById('password');pwd.type=pwd.type==='password'?'text':'password';this.innerHTML=pwd.type==='password'?eye:eyeOff;" style="position:absolute;top:2.5rem;right:1rem;cursor:pointer;">
                <script>
                  var eye = `<svg xmlns='http://www.w3.org/2000/svg' class='h-5 w-5' fill='none' viewBox='0 0 24 24' stroke='currentColor'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M15 12a3 3 0 11-6 0 3 3 0 016 0z' /><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z' /></svg>`;
                  var eyeOff = `<svg xmlns='http://www.w3.org/2000/svg' class='h-5 w-5' fill='none' viewBox='0 0 24 24' stroke='currentColor'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.956 9.956 0 012.293-3.95m3.36-2.676A9.956 9.956 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.965 9.965 0 01-4.293 5.032M15 12a3 3 0 11-6 0 3 3 0 016 0z' /><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M3 3l18 18' /></svg>`;
                  document.currentScript.parentElement.innerHTML = eye;
                </script>
            </span>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex flex-col items-center justify-center mt-4 gap-2">
            <div class="w-full flex flex-col items-center">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mb-2" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
                <button type="submit" style="min-width: 160px; padding: 0.5rem 1.5rem; background: #2563eb; color: white; border: none; border-radius: 0.375rem; font-weight: bold; font-size: 1rem; box-shadow: 0 2px 8px #0001; transition: background 0.2s; margin-top: 0.5rem;">Connexion</button>
            </div>
            <a href="{{ route('register') }}" style="display:inline-block; min-width:160px; padding:0.5rem 1.5rem; background:#22c55e; color:white; border:none; border-radius:0.375rem; font-weight:bold; font-size:1rem; box-shadow:0 2px 8px #0001; text-decoration:none; transition:background 0.2s; margin-top:1.5rem;" onmouseover="this.style.background='#16a34a'" onmouseout="this.style.background='#22c55e'">Créer un compte</a>
        </div>
    </form>
</x-guest-layout>
