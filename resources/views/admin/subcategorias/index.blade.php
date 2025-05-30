@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Subcategorías</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.subcategorias.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Nueva Subcategoría
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Categoría</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($subcategorias as $subcategoria)
                            <tr>
                                <td>{{ $subcategoria->id }}</td>
                                <td>{{ $subcategoria->nombre }}</td>
                                <td>
                                    <select class="form-control categoria-select" 
                                            data-subcategoria-id="{{ $subcategoria->id }}">
                                        @foreach($categorias as $categoria)
                                            <option value="{{ $categoria->id }}" 
                                                    {{ $subcategoria->categoria_id == $categoria->id ? 'selected' : '' }}>
                                                {{ $categoria->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <a href="{{ route('admin.subcategorias.edit', $subcategoria) }}" 
                                       class="btn btn-sm btn-info">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.subcategorias.destroy', $subcategoria) }}" 
                                          method="POST" 
                                          class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/productos.js') }}"></script>
@endpush 