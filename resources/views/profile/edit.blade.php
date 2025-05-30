<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Burgers & Roll') }}</title>

        <link rel="shortcut icon" href="{{ asset('images/icon.png') }}" type="image/x-icon">
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('styles')

        <style>
            .profile-section {
                background-color: #1A323E;
                border-radius: 1rem;
                transition: all 0.3s ease;
            }
            .profile-section:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            }
            .profile-title {
                font-family: "JetBrainsMono", sans-serif;
                color: #F3C71E;
            }
            .profile-subtitle {
                color: #FAFAEC;
            }
            .form-input {
                background-color: rgba(255, 255, 255, 0.1);
                border: 1px solid rgba(255, 255, 255, 0.2);
                color: #FAFAEC;
                padding: 0.75rem 1rem;
                border-radius: 0.5rem;
                transition: all 0.3s ease;
            }
            .form-input:focus {
                border-color: #F3C71E;
                box-shadow: 0 0 0 2px rgba(243, 199, 30, 0.2);
                outline: none;
            }
            .form-input::placeholder {
                color: rgba(250, 250, 236, 0.5);
            }
            .btn-primary {
                background-color: #F3C71E;
                color: #1A323E;
                transition: all 0.3s ease;
            }
            .btn-primary:hover {
                background-color: #e0b71a;
                transform: translateY(-1px);
            }
            .btn-danger {
                background-color: #dc2626;
                transition: all 0.3s ease;
            }
            .btn-danger:hover {
                background-color: #b91c1c;
                transform: translateY(-1px);
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('components.header')

            <!-- Page Content -->
            <main class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                    <div class="p-4 sm:p-8 profile-section">
                        <div class="max-w-xl">
                            <section>
                                <header>
                                    <h2 class="text-2xl font-medium profile-title">
                                        {{ __('Información del Perfil') }}
                                    </h2>
                                    <p class="mt-1 text-sm profile-subtitle">
                                        {{ __('Actualiza la información de tu perfil y tu dirección de email.') }}
                                    </p>
                                </header>

                                <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
                                    @csrf
                                    @method('patch')

                                    <div>
                                        <x-input-label for="nombre" :value="__('Nombre')" class="profile-subtitle" />
                                        <x-text-input id="nombre" name="nombre" type="text" class="mt-1 block w-full form-input" :value="old('nombre', $user->nombre)" required autofocus autocomplete="nombre" />
                                        <x-input-error class="mt-2" :messages="$errors->get('nombre')" />
                                    </div>

                                    <div>
                                        <x-input-label for="apellidos" :value="__('Apellidos')" class="profile-subtitle" />
                                        <x-text-input id="apellidos" name="apellidos" type="text" class="mt-1 block w-full form-input" :value="old('apellidos', $user->apellidos)" required autocomplete="apellidos" />
                                        <x-input-error class="mt-2" :messages="$errors->get('apellidos')" />
                                    </div>

                                    <div>
                                        <x-input-label for="email" :value="__('Email')" class="profile-subtitle" />
                                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full form-input" :value="old('email', $user->email)" required autocomplete="email" />
                                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                                    </div>

                                    <div class="mt-2">
                                        <p class="text-[var(--tercero)]">
                                            <strong>Email verificado:</strong> 
                                            @if($user->hasVerifiedEmail())
                                                <span class="text-green-500">Sí</span>
                                            @else
                                                <span class="text-red-500">No</span>
                                                <form method="POST" action="{{ route('verification.send') }}" class="inline">
                                                    @csrf
                                                    <button type="submit" class="ml-2 text-blue-500 hover:text-blue-700 text-sm">
                                                        Reenviar email de verificación
                                                    </button>
                                                </form>
                                            @endif
                                        </p>
                                    </div>

                                    <div>
                                        <x-input-label for="telefono" :value="__('Teléfono')" class="profile-subtitle" />
                                        <x-text-input id="telefono" name="telefono" type="text" class="mt-1 block w-full form-input" :value="old('telefono', $user->telefono)" required autocomplete="tel" />
                                        <x-input-error class="mt-2" :messages="$errors->get('telefono')" />
                                    </div>

                                    <div>
                                        <x-input-label for="direccion" :value="__('Dirección')" class="profile-subtitle" />
                                        <x-text-input id="direccion" name="direccion" type="text" class="mt-1 block w-full form-input" :value="old('direccion', $user->direccion)" autocomplete="street-address" />
                                        <x-input-error class="mt-2" :messages="$errors->get('direccion')" />
                                    </div>

                                    <div>
                                        <x-input-label for="fecha_nacimiento" :value="__('Fecha de Nacimiento')" class="profile-subtitle" />
                                        <x-text-input id="fecha_nacimiento" name="fecha_nacimiento" type="date" class="mt-1 block w-full form-input" :value="old('fecha_nacimiento', $user->fecha_nacimiento?->format('Y-m-d'))" required />
                                        <x-input-error class="mt-2" :messages="$errors->get('fecha_nacimiento')" />
                                    </div>

                                    <div class="flex items-center gap-4">
                                        <x-primary-button class="btn-primary">{{ __('Guardar') }}</x-primary-button>

                                        @if (session('status') === 'profile-updated')
                                            <p
                                                x-data="{ show: true }"
                                                x-show="show"
                                                x-transition
                                                x-init="setTimeout(() => show = false, 2000)"
                                                class="text-sm text-green-500"
                                            >{{ __('Guardado.') }}</p>
                                        @endif
                                    </div>
                                </form>
                            </section>
                        </div>
                    </div>

                    <div class="p-4 sm:p-8 profile-section">
                        <div class="max-w-xl">
                            <section>
                                <header>
                                    <h2 class="text-2xl font-medium profile-title">
                                        {{ __('Actualizar Contraseña') }}
                                    </h2>
                                    <p class="mt-1 text-sm profile-subtitle">
                                        {{ __('Asegúrate de usar una contraseña larga y segura.') }}
                                    </p>
                                </header>

                                <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
                                    @csrf
                                    @method('put')

                                    <div>
                                        <x-input-label for="current_password" :value="__('Contraseña Actual')" class="profile-subtitle" />
                                        <x-text-input id="current_password" name="current_password" type="password" class="mt-1 block w-full form-input" autocomplete="current-password" />
                                        <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-input-label for="password" :value="__('Nueva Contraseña')" class="profile-subtitle" />
                                        <x-text-input id="password" name="password" type="password" class="mt-1 block w-full form-input" autocomplete="new-password" />
                                        <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" class="profile-subtitle" />
                                        <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full form-input" autocomplete="new-password" />
                                        <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                                    </div>

                                    <div class="flex items-center gap-4">
                                        <x-primary-button class="btn-primary">{{ __('Guardar') }}</x-primary-button>

                                        @if (session('status') === 'password-updated')
                                            <p
                                                x-data="{ show: true }"
                                                x-show="show"
                                                x-transition
                                                x-init="setTimeout(() => show = false, 2000)"
                                                class="text-sm text-green-500"
                                            >{{ __('Guardado.') }}</p>
                                        @endif
                                    </div>
                                </form>
                            </section>
                        </div>
                    </div>

                    <div class="p-4 sm:p-8 profile-section">
                        <div class="max-w-xl">
                            <section class="space-y-6">
                                <header>
                                    <h2 class="text-2xl font-medium profile-title">
                                        {{ __('Eliminar Cuenta') }}
                                    </h2>
                                    <p class="mt-1 text-sm profile-subtitle">
                                        {{ __('Una vez que tu cuenta sea eliminada, todos sus recursos y datos serán eliminados permanentemente.') }}
                                    </p>
                                </header>

                                <x-danger-button
                                    x-data=""
                                    x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                                    class="btn-danger"
                                >{{ __('Eliminar Cuenta') }}</x-danger-button>

                                <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
                                    <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
                                        @csrf
                                        @method('delete')

                                        <h2 class="text-lg font-medium profile-title">
                                            {{ __('¿Estás seguro de que quieres eliminar tu cuenta?') }}
                                        </h2>
                                        <p class="mt-1 text-sm profile-subtitle">
                                            {{ __('Una vez que tu cuenta sea eliminada, todos sus recursos y datos serán eliminados permanentemente.') }}
                                        </p>

                                        <div class="mt-6">
                                            <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />
                                            <x-text-input
                                                id="password"
                                                name="password"
                                                type="password"
                                                class="mt-1 block w-full form-input"
                                                placeholder="{{ __('Contraseña') }}"
                                            />
                                            <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                                        </div>

                                        <div class="mt-6 flex justify-end">
                                            <x-secondary-button x-on:click="$dispatch('close')" class="mr-3">
                                                {{ __('Cancelar') }}
                                            </x-secondary-button>

                                            <x-danger-button class="btn-danger">
                                                {{ __('Eliminar Cuenta') }}
                                            </x-danger-button>
                                        </div>
                                    </form>
                                </x-modal>
                            </section>
                        </div>
                    </div>
                </div>
            </main>

            @include('components.footer')
        </div>

        <!-- Theme Script -->
        <script defer>
            document.addEventListener('DOMContentLoaded', function() {
                const themeToggle = document.querySelector('.theme-controller');
                const html = document.documentElement;

                // Función para aplicar el tema
                function applyTheme(theme) {
                    if (theme === 'light') {
                        html.setAttribute('data-theme', 'light');
                        document.body.classList.add('light-mode');
                    } else {
                        html.setAttribute('data-theme', 'dark');
                        document.body.classList.remove('light-mode');
                    }
                }

                // Función para cambiar el tema
                function toggleTheme() {
                    const currentTheme = html.getAttribute('data-theme');
                    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                    
                    // Guardar preferencia en localStorage
                    localStorage.setItem('theme', newTheme);
                    
                    // Aplicar el nuevo tema
                    applyTheme(newTheme);
                }

                // Aplicar tema guardado al cargar la página
                const savedTheme = localStorage.getItem('theme');
                if (savedTheme) {
                    applyTheme(savedTheme);
                    themeToggle.checked = savedTheme === 'light';
                }

                // Añadir evento al botón
                if (themeToggle) {
                    themeToggle.addEventListener('change', toggleTheme);
                }
            });
        </script>
    </body>
</html>
