@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
        <h1 class="text-2xl font-bold text-[#1A323E] dark:text-white">Gestión de Usuarios</h1>
        <a href="{{ route('admin.users.create') }}" class="bg-[#F3C71E] bg-opacity-10 hover:bg-opacity-20 text-[#1A323E] dark:text-white font-semibold py-2 px-4 rounded-lg border border-[#F3C71E] transition-all">
            <i class="fas fa-user-plus mr-2"></i>Nuevo Usuario
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden border border-[#F3C71E] border-opacity-20">
        <table class="min-w-full">
            <thead>
                <tr class="bg-[#F3C71E] bg-opacity-10">
                    <th class="px-6 py-4 border-b border-[#F3C71E] text-left text-xs font-semibold text-[#1A323E] dark:text-white uppercase tracking-wider">ID</th>
                    <th class="px-6 py-4 border-b border-[#F3C71E] text-left text-xs font-semibold text-[#1A323E] dark:text-white uppercase tracking-wider">Nombre</th>
                    <th class="px-6 py-4 border-b border-[#F3C71E] text-left text-xs font-semibold text-[#1A323E] dark:text-white uppercase tracking-wider">Email</th>
                    <th class="px-6 py-4 border-b border-[#F3C71E] text-left text-xs font-semibold text-[#1A323E] dark:text-white uppercase tracking-wider">Rol</th>
                    <th class="px-6 py-4 border-b border-[#F3C71E] text-left text-xs font-semibold text-[#1A323E] dark:text-white uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($users as $user)
                <tr class="hover:bg-[#F3C71E] hover:bg-opacity-5 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap text-[#1A323E] dark:text-white">{{ $user->id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-[#1A323E] dark:text-white">{{ $user->nombre }} {{ $user->apellidos }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-[#1A323E] dark:text-white">{{ $user->email }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->isAdmin() ? 'bg-[#F3C71E] bg-opacity-20 text-[#1A323E] dark:text-white' : 'bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-400' }}">
                            {{ $user->isAdmin() ? 'Administrador' : 'Usuario' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex space-x-3">
                            <a href="{{ route('admin.users.edit', $user) }}" class="text-[#1A323E] dark:text-white hover:text-[#F3C71E] transition-colors">
                                <i class="fas fa-edit mr-1"></i>Editar
                            </a>
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 transition-colors" onclick="return confirm('¿Estás seguro de que deseas eliminar este usuario?')">
                                    <i class="fas fa-trash-alt mr-1"></i>Eliminar
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection 