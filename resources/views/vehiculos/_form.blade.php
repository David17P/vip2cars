{{-- resources/views/vehiculos/_form.blade.php --}}

@php $editando = isset($vehiculo); @endphp

<div class="card-vip">
    <div class="section-label"><i class="bi bi-car-front"></i> &nbsp;Datos del Vehículo</div>
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:1.2rem;">

        {{-- PLACA --}}
        <div>
            <label class="form-label-vip">Placa *</label>
            <input
                type="text"
                name="placa"
                class="form-input-vip {{ $errors->has('placa') ? 'is-invalid' : '' }}"
                value="{{ old('placa', $editando ? $vehiculo->placa : '') }}"
                placeholder="Ej: ABC-123"
                maxlength="20"
                style="text-transform:uppercase;"
            >
            @error('placa')<div class="invalid-feedback-vip"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>@enderror
        </div>

        {{-- MARCA --}}
        <div>
            <label class="form-label-vip">Marca *</label>
            <input
                type="text"
                name="marca"
                class="form-input-vip {{ $errors->has('marca') ? 'is-invalid' : '' }}"
                value="{{ old('marca', $editando ? $vehiculo->marca : '') }}"
                placeholder="Ej: Toyota"
                maxlength="100"
            >
            @error('marca')<div class="invalid-feedback-vip"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>@enderror
        </div>

        {{-- MODELO --}}
        <div>
            <label class="form-label-vip">Modelo *</label>
            <input
                type="text"
                name="modelo"
                class="form-input-vip {{ $errors->has('modelo') ? 'is-invalid' : '' }}"
                value="{{ old('modelo', $editando ? $vehiculo->modelo : '') }}"
                placeholder="Ej: Corolla"
                maxlength="100"
            >
            @error('modelo')<div class="invalid-feedback-vip"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>@enderror
        </div>

        {{-- AÑO --}}
        <div>
            <label class="form-label-vip">Año de Fabricación *</label>
            <input
                type="number"
                name="anio_fabricacion"
                class="form-input-vip {{ $errors->has('anio_fabricacion') ? 'is-invalid' : '' }}"
                value="{{ old('anio_fabricacion', $editando ? $vehiculo->anio_fabricacion : '') }}"
                placeholder="{{ date('Y') }}"
                min="1900"
                max="{{ date('Y') }}"
            >
            @error('anio_fabricacion')<div class="invalid-feedback-vip"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>@enderror
        </div>

    </div>
</div>

<div class="card-vip">
    <div class="section-label"><i class="bi bi-person-badge"></i> &nbsp;Datos del Cliente</div>
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:1.2rem;">

        {{-- NOMBRE --}}
        <div>
            <label class="form-label-vip">Nombre *</label>
            <input
                type="text"
                name="nombre_cliente"
                class="form-input-vip {{ $errors->has('nombre_cliente') ? 'is-invalid' : '' }}"
                value="{{ old('nombre_cliente', $editando ? $vehiculo->nombre_cliente : '') }}"
                placeholder="Ej: Carlos"
                maxlength="100"
            >
            @error('nombre_cliente')<div class="invalid-feedback-vip"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>@enderror
        </div>

        {{-- APELLIDOS --}}
        <div>
            <label class="form-label-vip">Apellidos *</label>
            <input
                type="text"
                name="apellidos_cliente"
                class="form-input-vip {{ $errors->has('apellidos_cliente') ? 'is-invalid' : '' }}"
                value="{{ old('apellidos_cliente', $editando ? $vehiculo->apellidos_cliente : '') }}"
                placeholder="Ej: Ramírez Torres"
                maxlength="150"
            >
            @error('apellidos_cliente')<div class="invalid-feedback-vip"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>@enderror
        </div>

        {{-- NRO DOCUMENTO --}}
        <div>
            <label class="form-label-vip">Nro. Documento *</label>
            <input
                type="text"
                name="nro_documento"
                class="form-input-vip {{ $errors->has('nro_documento') ? 'is-invalid' : '' }}"
                value="{{ old('nro_documento', $editando ? $vehiculo->nro_documento : '') }}"
                placeholder="Ej: 12345678"
                maxlength="20"
            >
            @error('nro_documento')<div class="invalid-feedback-vip"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>@enderror
        </div>

        {{-- CORREO --}}
        <div>
            <label class="form-label-vip">Correo Electrónico *</label>
            <input
                type="email"
                name="correo_cliente"
                class="form-input-vip {{ $errors->has('correo_cliente') ? 'is-invalid' : '' }}"
                value="{{ old('correo_cliente', $editando ? $vehiculo->correo_cliente : '') }}"
                placeholder="cliente@correo.com"
            >
            @error('correo_cliente')<div class="invalid-feedback-vip"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>@enderror
        </div>

        {{-- TELÉFONO --}}
        <div>
            <label class="form-label-vip">Teléfono *</label>
            <input
                type="tel"
                name="telefono_cliente"
                class="form-input-vip {{ $errors->has('telefono_cliente') ? 'is-invalid' : '' }}"
                value="{{ old('telefono_cliente', $editando ? $vehiculo->telefono_cliente : '') }}"
                placeholder="Ej: +51 987 654 321"
                maxlength="20"
            >
            @error('telefono_cliente')<div class="invalid-feedback-vip"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>@enderror
        </div>

    </div>
</div>

{{-- BOTONES --}}
<div style="display:flex;gap:1rem;justify-content:flex-end;">
    <a href="{{ route('vehiculos.index') }}" class="btn-outline-vip">
        <i class="bi bi-x-lg"></i> Cancelar
    </a>
    <button type="submit" class="btn-vip">
        <i class="bi bi-{{ $editando ? 'floppy' : 'plus-lg' }}"></i>
        {{ $editando ? 'Guardar Cambios' : 'Registrar Vehículo' }}
    </button>
</div>