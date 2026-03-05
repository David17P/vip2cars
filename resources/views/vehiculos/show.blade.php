@extends('layouts.app')
@section('title', 'Detalle — ' . strtoupper($vehiculo->placa))

@section('content')
<div class="page-header">
    <div>
        <div class="page-title">Detalle <span>del Vehículo</span></div>
        <div class="page-subtitle">Registrado el {{ $vehiculo->created_at->format('d/m/Y H:i') }}</div>
    </div>
    <div style="display:flex;gap:.8rem;">
        <a href="{{ route('vehiculos.edit', $vehiculo) }}" class="btn-vip">
            <i class="bi bi-pencil"></i> Editar
        </a>
        <a href="{{ route('vehiculos.index') }}" class="btn-outline-vip">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;">

    {{-- TARJETA VEHÍCULO --}}
    <div class="card-vip">
        <div class="section-label"><i class="bi bi-car-front"></i> &nbsp;Datos del Vehículo</div>

        <div style="margin-bottom:1.5rem;">
            <span class="badge-placa" style="font-size:1.4rem;padding:.4rem 1.2rem;">
                {{ strtoupper($vehiculo->placa) }}
            </span>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
            <div class="detail-group">
                <div class="detail-label">Marca</div>
                <div class="detail-value">{{ $vehiculo->marca }}</div>
            </div>
            <div class="detail-group">
                <div class="detail-label">Modelo</div>
                <div class="detail-value">{{ $vehiculo->modelo }}</div>
            </div>
            <div class="detail-group">
                <div class="detail-label">Año de Fabricación</div>
                <div class="detail-value">{{ $vehiculo->anio_fabricacion }}</div>
            </div>
            <div class="detail-group">
                <div class="detail-label">Antigüedad</div>
                <div class="detail-value">{{ date('Y') - $vehiculo->anio_fabricacion }} años</div>
            </div>
        </div>
    </div>

    {{-- TARJETA CLIENTE --}}
    <div class="card-vip">
        <div class="section-label"><i class="bi bi-person-badge"></i> &nbsp;Datos del Cliente</div>

        <div class="detail-group">
            <div class="detail-label">Nombre completo</div>
            <div class="detail-value" style="font-size:1.15rem;font-weight:600;">
                {{ $vehiculo->nombre_cliente }} {{ $vehiculo->apellidos_cliente }}
            </div>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-top:.5rem;">
            <div class="detail-group">
                <div class="detail-label">Nro. Documento</div>
                <div class="detail-value">{{ $vehiculo->nro_documento }}</div>
            </div>
            <div class="detail-group">
                <div class="detail-label">Teléfono</div>
                <div class="detail-value">
                    <a href="tel:{{ $vehiculo->telefono_cliente }}" style="color:var(--blanco);text-decoration:none;">
                        <i class="bi bi-telephone" style="color:var(--rojo);"></i>
                        {{ $vehiculo->telefono_cliente }}
                    </a>
                </div>
            </div>
            <div class="detail-group" style="grid-column:span 2;">
                <div class="detail-label">Correo electrónico</div>
                <div class="detail-value">
                    <a href="mailto:{{ $vehiculo->correo_cliente }}" style="color:var(--blanco);text-decoration:none;">
                        <i class="bi bi-envelope" style="color:var(--rojo);"></i>
                        {{ $vehiculo->correo_cliente }}
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- ZONA PELIGROSA --}}
<div class="card-vip" style="border-color:#7f1d1d;">
    <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;">
        <div>
            <div style="color:#f87171;font-weight:600;margin-bottom:.3rem;"><i class="bi bi-exclamation-triangle"></i> Zona peligrosa</div>
            <div style="color:var(--plata);font-size:.88rem;">Eliminar este registro es una acción permanente e irreversible.</div>
        </div>
        <button
            class="btn-danger-vip"
            data-bs-toggle="modal"
            data-bs-target="#modalEliminar"
        >
            <i class="bi bi-trash3"></i> Eliminar vehículo
        </button>
    </div>
</div>

<!-- MODAL ELIMINAR -->
<div class="modal fade modal-vip" id="modalEliminar" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="font-family:'Bebas Neue',sans-serif;font-size:1.4rem;letter-spacing:2px;">
                    <i class="bi bi-exclamation-triangle text-danger"></i> Confirmar Eliminación
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="color:var(--plata);">
                <p>¿Estás seguro de eliminar el vehículo con placa</p>
                <p style="margin:.5rem 0;"><span class="badge-placa">{{ strtoupper($vehiculo->placa) }}</span></p>
                <p>del cliente <strong style="color:var(--blanco);">{{ $vehiculo->nombre_cliente }} {{ $vehiculo->apellidos_cliente }}</strong>?</p>
                <p style="margin-top:.8rem;font-size:.83rem;color:#f87171;">Esta acción no se puede deshacer.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-outline-vip" data-bs-dismiss="modal">Cancelar</button>
                <form method="POST" action="{{ route('vehiculos.destroy', $vehiculo) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-danger-vip" style="background:#7f1d1d;">
                        <i class="bi bi-trash3"></i> Sí, eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection