@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Listado de Actas de Compromiso</h2>
    <a href="{{ route('actas.create') }}" class="btn btn-success mb-2">Crear Nueva Acta</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="bg-light">
                        <tr>
                            <th>Número de Acta</th>
                            <th>Docente</th>
                            <th>Fecha Generación</th>
                            <th>Calificación</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($actas) > 0)
                            @foreach($actas as $acta)
                            <tr>
                                <td>{{ $acta->id_acta }}</td>
                                <td>{{ $acta->nombre_docente }}</td>
                                <td>{{ $acta->fecha_generacion }}</td>
                                <td><span class="badge bg-{{ ($acta->calificacion < 3.5) ? 'danger' : 'success' }}">{{ $acta->calificacion}}</span></td>
                                <td>
                                    <a href="{{ route('actas.show', $acta->id_acta) }}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i> Ver</a>
                                    <a href="{{ route('actas.edit', $acta->id_acta) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Editar</a>
                                    <form action="{{ route('actas.destroy', $acta->id_acta) }}" method="POST" style="display:inline-block;">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de eliminar esta acta?')"><i class="fas fa-trash"></i> Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="text-center">No hay actas de compromiso registradas</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
