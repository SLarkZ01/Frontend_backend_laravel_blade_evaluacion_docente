@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h2>Editar Acta de Compromiso</h2>
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

            <form action="{{ route('actas.update', $acta->id_acta) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Docente</label>
                        <input type="text" class="form-control" value="{{ $acta->nombre_docente }}" readonly>
                        <input type="hidden" name="docente_id" value="{{ $acta->id_docente }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Calificación</label>
                        <input type="text" class="form-control" value="{{ $acta->calificacion }}" readonly>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Número de Acta</label>
                        <input type="text" name="numero_acta" class="form-control" value="{{ $acta->numero_acta ?? '' }}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Fecha de Generación</label>
                        <input type="date" name="fecha_generacion" class="form-control" value="{{ $acta->fecha_generacion }}" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-12">
                        <label class="form-label">Retroalimentación</label>
                        <textarea name="retroalimentacion" class="form-control" rows="5" required>{{ $acta->retroalimentacion }}</textarea>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Firma (opcional)</label>
                        <input type="file" name="firma" class="form-control" accept="image/*">
                        @if(isset($acta->firma) && !empty($acta->firma))
                            <div class="mt-2">
                                <img src="{{ asset($acta->firma) }}" alt="Firma actual" class="img-thumbnail" style="max-height: 100px;">
                                <input type="hidden" name="firma_actual" value="{{ $acta->firma }}">
                            </div>
                        @endif
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('actas.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Actualizar Acta de Compromiso</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection