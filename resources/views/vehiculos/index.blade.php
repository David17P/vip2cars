@extends('layouts.app')
@section('title', 'Vehículos Registrados')

@section('content')
<div class="page-header">
    <div>
        <div class="page-title">Vehículos <span>Registrados</span></div>
        <div class="page-subtitle">
            {{ $vehiculos->total() }} {{ $vehiculos->total() === 1 ? 'registro encontrado' : 'registros encontrados' }}
            @if(request('buscar')) — búsqueda: "{{ request('buscar') }}" @endif
        </div>
    </div>
    <a href="{{ route('vehiculos.create') }}" class="btn-vip">
        <i class="bi bi-plus-lg"></i> Registrar Vehículo
    </a>
</div>

<!-- BUSCADOR -->
<div class="card-vip" style="padding:1.2rem 1.5rem;">
    <form method="GET" action="{{ route('vehiculos.index') }}" style="display:flex;gap:.8rem;align-items:center;flex-wrap:wrap;">
        <div class="search-wrap" style="flex:1;min-width:220px;">
            <i class="bi bi-search"></i>
            <input
                type="text"
                name="buscar"
                class="input-vip"
                placeholder="Placa, marca, modelo, cliente..."
                value="{{ request('buscar') }}"
                autocomplete="off"
            >
        </div>
        <button type="submit" class="btn-vip"><i class="bi bi-search"></i> Buscar</button>
        @if(request('buscar'))
            <a href="{{ route('vehiculos.index') }}" class="btn-outline-vip"><i class="bi bi-x-lg"></i> Limpiar</a>
        @endif
    </form>
</div>

<!-- TABLA -->
<div class="card-vip" style="padding:0;overflow:hidden;">
    @if($vehiculos->count())
        <table class="table-vip">
            <thead>
                <tr>
                    <th>Placa</th>
                    <th>Vehículo</th>
                    <th>Año</th>
                    <th>Cliente</th>
                    <th>Documento</th>
                    <th>Contacto</th>
                    <th style="text-align:right;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($vehiculos as $v)
                <tr>
                    <td><span class="badge-placa">{{ strtoupper($v->placa) }}</span></td>
                    <td>
                        <div style="font-weight:600;">{{ $v->marca }}</div>
                        <div style="color:var(--plata);font-size:.82rem;">{{ $v->modelo }}</div>
                    </td>
                    <td style="color:var(--plata);">{{ $v->anio_fabricacion }}</td>
                    <td>
                        <div style="font-weight:500;">{{ $v->nombre_cliente }} {{ $v->apellidos_cliente }}</div>
                    </td>
                    <td style="color:var(--plata);font-size:.85rem;">{{ $v->nro_documento }}</td>
                    <td>
                        <div style="font-size:.82rem;color:var(--plata);">
                            <i class="bi bi-envelope"></i> {{ $v->correo_cliente }}<br>
                            <i class="bi bi-telephone"></i> {{ $v->telefono_cliente }}
                        </div>
                    </td>
                    <td style="text-align:right;">
                        <div style="display:flex;gap:.5rem;justify-content:flex-end;flex-wrap:wrap;">
                            <a href="{{ route('vehiculos.show', $v) }}" class="btn-outline-vip" title="Ver detalle">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('vehiculos.edit', $v) }}" class="btn-outline-vip" title="Editar">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <button
                                class="btn-danger-vip"
                                title="Eliminar"
                                data-bs-toggle="modal"
                                data-bs-target="#modalEliminar"
                                data-id="{{ $v->id }}"
                                data-placa="{{ $v->placa }}"
                                data-cliente="{{ $v->nombre_cliente }} {{ $v->apellidos_cliente }}"
                            >
                                <i class="bi bi-trash3"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- PAGINACIÓN -->
        @if($vehiculos->hasPages())
        <div style="padding:1.2rem 1.5rem;">
            <div class="pagination-vip">
                
                @if($vehiculos->onFirstPage())
                    <span class="disabled"><i class="bi bi-chevron-left"></i></span>
                @else
                    <a href="{{ $vehiculos->previousPageUrl() }}&buscar={{ request('buscar') }}"><i class="bi bi-chevron-left"></i></a>
                @endif

                
                @foreach($vehiculos->getUrlRange(1, $vehiculos->lastPage()) as $page => $url)
                    @if($page == $vehiculos->currentPage())
                        <span class="active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}&buscar={{ request('buscar') }}">{{ $page }}</a>
                    @endif
                @endforeach

                
                @if($vehiculos->hasMorePages())
                    <a href="{{ $vehiculos->nextPageUrl() }}&buscar={{ request('buscar') }}"><i class="bi bi-chevron-right"></i></a>
                @else
                    <span class="disabled"><i class="bi bi-chevron-right"></i></span>
                @endif
            </div>
            <div style="text-align:center;margin-top:.8rem;color:var(--plata);font-size:.8rem;">
                Mostrando {{ $vehiculos->firstItem() }}–{{ $vehiculos->lastItem() }} de {{ $vehiculos->total() }} registros
            </div>
        </div>
        @endif

    @else
        <div class="empty-state">
            <i class="bi bi-car-front"></i>
            <p>No se encontraron vehículos
                @if(request('buscar'))
                    para "<strong>{{ request('buscar') }}</strong>"
                @endif
            </p>
            @if(!request('buscar'))
                <a href="{{ route('vehiculos.create') }}" class="btn-vip" style="margin-top:1rem;">
                    <i class="bi bi-plus-lg"></i> Registrar el primero
                </a>
            @endif
        </div>
    @endif
</div>

<!-- ACA ES PARA ELIMINAAAAAR -->
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
                <p style="margin:.5rem 0;"><span class="badge-placa" id="modalPlaca"></span></p>
                <p>del cliente <strong id="modalCliente" style="color:var(--blanco);"></strong>?</p>
                <p style="margin-top:.8rem;font-size:.83rem;color:#f87171;">Esta acción no se puede deshacer.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-outline-vip" data-bs-dismiss="modal">Cancelar</button>
                <form id="formEliminar" method="POST">
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

@section('scripts')
<script>
    document.getElementById('modalEliminar').addEventListener('show.bs.modal', function(e) {
        const btn = e.relatedTarget;
        document.getElementById('modalPlaca').textContent   = btn.dataset.placa;
        document.getElementById('modalCliente').textContent = btn.dataset.cliente;
        document.getElementById('formEliminar').action =
            '/vehiculos/' + btn.dataset.id;
    });
</script>
@endsection