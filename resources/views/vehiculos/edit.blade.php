@extends('layouts.app')
@section('title', 'Editar Vehículo')

@section('content')
<div class="page-header">
    <div>
        <div class="page-title">Editar <span>Vehículo</span></div>
        <div class="page-subtitle">Placa: {{ strtoupper($vehiculo->placa) }}</div>
    </div>
    <div style="display:flex;gap:.8rem;">
        <a href="{{ route('vehiculos.show', $vehiculo) }}" class="btn-outline-vip">
            <i class="bi bi-eye"></i> Ver detalle
        </a>
        <a href="{{ route('vehiculos.index') }}" class="btn-outline-vip">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>
</div>

<form method="POST" action="{{ route('vehiculos.update', $vehiculo) }}" novalidate>
    @csrf
    @method('PUT')
    @include('vehiculos._form')
</form>
@endsection