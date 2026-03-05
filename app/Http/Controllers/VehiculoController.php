<?php

namespace App\Http\Controllers;

use App\Models\Vehiculo;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VehiculoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $buscar = $request->input('buscar');

        $vehiculos = Vehiculo::when($buscar, function ($query, $buscar) {
            $query->where(function ($q) use ($buscar) {
                $q->where('placa',            'like', "%{$buscar}%")
                    ->orWhere('marca',           'like', "%{$buscar}%")
                    ->orWhere('modelo',          'like', "%{$buscar}%")
                    ->orWhere('nombre_cliente',  'like', "%{$buscar}%")
                    ->orWhere('apellidos_cliente', 'like', "%{$buscar}%")
                    ->orWhere('nro_documento',   'like', "%{$buscar}%")
                    ->orWhere('correo_cliente',  'like', "%{$buscar}%");
            });
        })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('vehiculos.index', compact('vehiculos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('vehiculos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate($this->reglas(), $this->mensajes());
        $validated['placa'] = strtoupper($validated['placa']);

        try {
            Vehiculo::create($validated);

            return redirect()
                ->route('vehiculos.index')
                ->with('success', 'Vehículo registrado correctamente.');
        } catch (QueryException $e) {
            Log::error('Error al crear vehículo: ' . $e->getMessage());

            if ($e->getCode() === '23000') {
                return back()->withInput()
                    ->with('error', 'Ya existe un registro con esa placa, documento o correo.');
            }

            return back()->withInput()
                ->with('error', 'No se pudo registrar el vehículo. Intenta nuevamente.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Vehiculo $vehiculo)
    {
        return view('vehiculos.show', compact('vehiculo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vehiculo $vehiculo)
    {
        return view('vehiculos.edit', compact('vehiculo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vehiculo $vehiculo)
    {
        $validated = $request->validate(
            $this->reglas($vehiculo->id),
            $this->mensajes()
        );
        $validated['placa'] = strtoupper($validated['placa']);

        try {
            $vehiculo->update($validated);

            return redirect()
                ->route('vehiculos.index')
                ->with('success', 'Vehículo actualizado correctamente.');
        } catch (QueryException $e) {
            Log::error("Error al actualizar vehículo ID {$vehiculo->id}: " . $e->getMessage());

            if ($e->getCode() === '23000') {
                return back()->withInput()
                    ->with('error', 'Ya existe un registro con esa placa, documento o correo.');
            }

            return back()->withInput()
                ->with('error', 'No se pudo actualizar el vehículo. Intenta nuevamente.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vehiculo $vehiculo)
    {
        try {
            $placa = $vehiculo->placa;
            $vehiculo->delete();

            return redirect()
                ->route('vehiculos.index')
                ->with('success', "Vehículo {$placa} eliminado correctamente.");
        } catch (QueryException $e) {
            Log::error("Error al eliminar vehículo ID {$vehiculo->id}: " . $e->getMessage());

            return redirect()
                ->route('vehiculos.index')
                ->with('error', 'No se pudo eliminar el vehículo. Intenta nuevamente.');
        }
    }

    private function mensajes(): array
    {
        return [
            'placa.required'             => 'La placa es obligatoria.',
            'placa.unique'               => 'Ya existe un vehículo con esta placa.',
            'placa.max'                  => 'La placa no puede superar 20 caracteres.',
            'marca.required'             => 'La marca es obligatoria.',
            'modelo.required'            => 'El modelo es obligatorio.',
            'anio_fabricacion.required'  => 'El año de fabricación es obligatorio.',
            'anio_fabricacion.digits'    => 'El año debe tener 4 dígitos.',
            'anio_fabricacion.min'       => 'El año mínimo es 1900.',
            'anio_fabricacion.max'       => 'El año no puede ser mayor al año actual.',
            'nombre_cliente.required'    => 'El nombre del cliente es obligatorio.',
            'apellidos_cliente.required' => 'Los apellidos del cliente son obligatorios.',
            'nro_documento.required'     => 'El nro. de documento es obligatorio.',
            'nro_documento.unique'       => 'Ya existe un cliente con este número de documento.',
            'correo_cliente.required'    => 'El correo electrónico es obligatorio.',
            'correo_cliente.email'       => 'Ingresa un correo electrónico válido.',
            'correo_cliente.unique'      => 'Ya existe un cliente con este correo.',
            'telefono_cliente.required'  => 'El teléfono es obligatorio.',
        ];
    }


    private function reglas(?int $id = null): array
    {
        $uniquePlaca  = 'unique:vehiculos,placa'          . ($id ? ",{$id}" : '');
        $uniqueDoc    = 'unique:vehiculos,nro_documento'  . ($id ? ",{$id}" : '');
        $uniqueCorreo = 'unique:vehiculos,correo_cliente' . ($id ? ",{$id}" : '');

        return [
            'placa'             => "required|string|max:20|{$uniquePlaca}",
            'marca'             => 'required|string|max:100',
            'modelo'            => 'required|string|max:100',
            'anio_fabricacion'  => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'nombre_cliente'    => 'required|string|max:100',
            'apellidos_cliente' => 'required|string|max:150',
            'nro_documento'     => "required|string|max:20|{$uniqueDoc}",
            'correo_cliente'    => "required|email|max:255|{$uniqueCorreo}",
            'telefono_cliente'  => 'required|string|max:20',
        ];
    }
}
