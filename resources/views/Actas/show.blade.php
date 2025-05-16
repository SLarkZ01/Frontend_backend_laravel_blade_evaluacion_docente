@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h2>Detalles del Acta de Compromiso</h2>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <h5>Información del Docente</h5>
                    <p><strong>Nombre:</strong> {{ $acta->nombre_docente ?? 'N/A' }}</p>
                    <p><strong>ID Docente:</strong> {{ $acta->id_docente ?? 'N/A' }}</p>
                </div>
                <div class="col-md-6">
                    <h5>Información del Acta</h5>
                    <p><strong>Número de Acta:</strong> {{ $acta->numero_acta ?? 'N/A' }}</p>
                    <p><strong>Fecha de Generación:</strong> {{ $acta->fecha_generacion ?? 'N/A' }}</p>
                    <p><strong>Calificación:</strong> <span class="badge bg-{{ $acta->calificacion < 3.5 ? 'danger' : 'success' }}">{{ $acta->calificacion ?? 'N/A' }}</span></p>
                </div>
            </div>

            <div class="row mb-3">{{-- yusgedfiysedfgys --}}
                <div class="col-12">
                    <h5>Retroalimentación</h5>
                    <div class="p-3 border rounded">
                        {{ $acta->retroalimentacion ?? 'No hay retroalimentación disponible' }}
                    </div>
                </div>
            </div>

            @if(isset($acta->firma) && !empty($acta->firma))
            <div class="row mb-3">
                <div class="col-12">
                    <h5>Firma</h5>
                    <img src="{{ asset($acta->firma) }}" alt="Firma" class="img-fluid" style="max-height: 100px;">
                </div>
            </div>
            @endif

            <div class="row">
                <div class="col-12">
                    <a href="{{ route('actas.index') }}" class="btn btn-secondary">Volver</a>
                    <a href="{{ route('actas.edit', $acta->id_acta) }}" class="btn btn-primary">Editar</a>
                    <form action="{{ route('actas.destroy', $acta->id_acta) }}" method="POST" style="display:inline-block;">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger" onclick="return confirm('¿Está seguro de eliminar esta acta?')">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection