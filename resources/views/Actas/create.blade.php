@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h2>Crear Nueva Acta de Compromiso</h2>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('actas.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Docente</label>
                        <select name="docente_id" class="form-select" required>
                            <option value="">Seleccione un docente</option>
                            @foreach($docentes as $docente)
                                <option value="{{ $docente->id_docente }}">{{ $docente->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Facultad</label>
                        <select name="id_facultad" class="form-select" required>
                            <option value="">Seleccione una facultad</option>
                            @foreach($facultades as $facultad)
                                <option value="{{ $facultad->id_facultad }}">{{ $facultad->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Promedio de Evaluación</label>
                        <select name="id_promedio" class="form-select" required>
                            <option value="">Seleccione un promedio</option>
                            @foreach($promedios as $promedio)
                                <option value="{{ $promedio->id_promedio }}">{{ $promedio->promedio_ev_docente }} - Docente ID: {{ $promedio->id_docente }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Fecha de Generación</label>
                        <input type="date" name="fecha_generacion" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-12">
                        <label class="form-label">Retroalimentación</label>
                        <textarea name="retroalimentacion" class="form-control" rows="5" required></textarea>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Firma (opcional)</label>
                        <input type="file" name="firma" class="form-control" accept="image/*">
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('actas.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-success">Guardar Acta de Compromiso</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
