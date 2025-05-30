<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Usuario') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="nombre" :value="__('Nombre')" class="text-sm font-semibold text-gray-700" />
                                <x-text-input id="nombre" name="nombre" type="text" class="p-2 border-2 mt-1 block w-full rounded-lg bg-white focus:border-[#F3C71E] focus:ring-[#F3C71E]" :value="old('nombre')" required autofocus />
                                <x-input-error class="mt-2" :messages="$errors->get('nombre')" />
                            </div>

                            <div>
                                <x-input-label for="apellidos" :value="__('Apellidos')" class="text-sm font-semibold text-gray-700" />
                                <x-text-input id="apellidos" name="apellidos" type="text" class="p-2 border-2 mt-1 block w-full rounded-lg bg-white focus:border-[#F3C71E] focus:ring-[#F3C71E]" :value="old('apellidos')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('apellidos')" />
                            </div>

                            <div>
                                <x-input-label for="email" :value="__('Email')" class="text-sm font-semibold text-gray-700" />
                                <x-text-input id="email" name="email" type="email" class="p-2 border-2 mt-1 block w-full rounded-lg bg-white focus:border-[#F3C71E] focus:ring-[#F3C71E]" :value="old('email')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('email')" />
                            </div>

                            <div>
                                <x-input-label for="password" :value="__('Contraseña')" class="text-sm font-semibold text-gray-700" />
                                <x-text-input id="password" name="password" type="password" class="p-2 border-2 mt-1 block w-full rounded-lg bg-white focus:border-[#F3C71E] focus:ring-[#F3C71E]" required />
                                <x-input-error class="mt-2" :messages="$errors->get('password')" />
                            </div>

                            <div>
                                <x-input-label for="telefono" :value="__('Teléfono')" class="text-sm font-semibold text-gray-700" />
                                <x-text-input id="telefono" name="telefono" type="text" class="p-2 border-2 mt-1 block w-full rounded-lg bg-white focus:border-[#F3C71E] focus:ring-[#F3C71E]" :value="old('telefono')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('telefono')" />
                            </div>

                            <div>
                                <x-input-label for="direccion" :value="__('Dirección')" class="text-sm font-semibold text-gray-700" />
                                <x-text-input id="direccion" name="direccion" type="text" class="p-2 border-2 mt-1 block w-full rounded-lg bg-white focus:border-[#F3C71E] focus:ring-[#F3C71E]" :value="old('direccion')" />
                                <x-input-error class="mt-2" :messages="$errors->get('direccion')" />
                            </div>

                            <div>
                                <x-input-label for="fecha_nacimiento" :value="__('Fecha de Nacimiento')" class="text-sm font-semibold text-gray-700" />
                                <x-text-input id="fecha_nacimiento" name="fecha_nacimiento" type="date" class="p-2 border-2 mt-1 block w-full rounded-lg bg-white focus:border-[#F3C71E] focus:ring-[#F3C71E]" :value="old('fecha_nacimiento')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('fecha_nacimiento')" />
                            </div>

                            <div>
                                <x-input-label for="role_id" :value="__('Rol')" class="text-sm font-semibold text-gray-700" />
                                <select id="role_id" name="role_id" class="p-2 border-2 mt-1 block w-full rounded-lg bg-white focus:border-[#F3C71E] focus:ring-[#F3C71E]" required>
                                    <option value="">Seleccione un rol</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                            {{ ucfirst($role->nombre) }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('role_id')" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6 space-x-3">
                            <x-secondary-button onclick="window.history.back()" type="button" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                                {{ __('Cancelar') }}
                            </x-secondary-button>
                            <x-primary-button class="px-4 py-2 bg-[#F3C71E] text-[#1A323E] rounded-lg hover:bg-[#f4cf3c] transition-colors">
                                {{ __('Crear Usuario') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 