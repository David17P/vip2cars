<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vehiculos', function (Blueprint $table) {
            $table->id();

            
            $table->string('placa', 20)->unique()->comment('Placa del vehículo (única)');
            $table->string('marca', 100)->comment('Marca del vehículo');
            $table->string('modelo', 100)->comment('Modelo del vehículo');
            $table->year('anio_fabricacion')->comment('Año de fabricación');
            $table->string('nombre_cliente', 100)->comment('Nombre del propietario');
            $table->string('apellidos_cliente', 150)->comment('Apellidos del propietario');
            $table->string('nro_documento', 20)->unique()->comment('DNI / RUC / Pasaporte');
            $table->string('correo_cliente')->unique()->comment('Correo electrónico del cliente');
            $table->string('telefono_cliente', 20)->comment('Teléfono / celular del cliente');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehiculos');
    }
};
