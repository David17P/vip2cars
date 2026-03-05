@extends('layouts.app')
@section('title', 'Registrar Vehículo')

@section('content')
<div class="page-header">
    <div>
        <div class="page-title">Registrar <span>Vehículo</span></div>
        <div class="page-subtitle">Completa todos los campos requeridos</div>
    </div>
    <a href="{{ route('vehiculos.index') }}" class="btn-outline-vip">
        <i class="bi bi-arrow-left"></i> Volver
    </a>
</div>

<form method="POST" action="{{ route('vehiculos.store') }}" novalidate>
    @csrf
    @include('vehiculos._form')
</form>
@endsection