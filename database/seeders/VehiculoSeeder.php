<?php

namespace Database\Seeders;

use App\Models\Vehiculo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehiculoSeeder extends Seeder
{
public function run(): void
    {
        $vehiculos = [
            [
                'placa'             => 'ABC-123',
                'marca'             => 'Toyota',
                'modelo'            => 'Corolla',
                'anio_fabricacion'  => 2020,
                'nombre_cliente'    => 'Carlos',
                'apellidos_cliente' => 'Ramírez Torres',
                'nro_documento'     => '12345678',
                'correo_cliente'    => 'carlos.ramirez@gmail.com',
                'telefono_cliente'  => '+51 987 654 321',
            ],
            [
                'placa'             => 'XYZ-789',
                'marca'             => 'Hyundai',
                'modelo'            => 'Tucson',
                'anio_fabricacion'  => 2022,
                'nombre_cliente'    => 'María',
                'apellidos_cliente' => 'López Gutiérrez',
                'nro_documento'     => '87654321',
                'correo_cliente'    => 'maria.lopez@outlook.com',
                'telefono_cliente'  => '+51 912 345 678',
            ],
            [
                'placa'             => 'LMN-456',
                'marca'             => 'Kia',
                'modelo'            => 'Sportage',
                'anio_fabricacion'  => 2019,
                'nombre_cliente'    => 'Jorge',
                'apellidos_cliente' => 'Mendoza Vega',
                'nro_documento'     => '45678912',
                'correo_cliente'    => 'jorge.mendoza@yahoo.com',
                'telefono_cliente'  => '+51 956 789 012',
            ],
            [
                'placa'             => 'PQR-321',
                'marca'             => 'Chevrolet',
                'modelo'            => 'Captiva',
                'anio_fabricacion'  => 2021,
                'nombre_cliente'    => 'Lucía',
                'apellidos_cliente' => 'Flores Quispe',
                'nro_documento'     => '32198765',
                'correo_cliente'    => 'lucia.flores@gmail.com',
                'telefono_cliente'  => '+51 934 567 890',
            ],
            [
                'placa'             => 'DEF-654',
                'marca'             => 'Nissan',
                'modelo'            => 'Sentra',
                'anio_fabricacion'  => 2018,
                'nombre_cliente'    => 'Roberto',
                'apellidos_cliente' => 'Castro Paredes',
                'nro_documento'     => '65432198',
                'correo_cliente'    => 'roberto.castro@gmail.com',
                'telefono_cliente'  => '+51 978 901 234',
            ],
            [
                'placa'             => 'GHI-987',
                'marca'             => 'Honda',
                'modelo'            => 'CR-V',
                'anio_fabricacion'  => 2023,
                'nombre_cliente'    => 'Ana',
                'apellidos_cliente' => 'Sánchez Morales',
                'nro_documento'     => '98765432',
                'correo_cliente'    => 'ana.sanchez@hotmail.com',
                'telefono_cliente'  => '+51 945 678 901',
            ],
            [
                'placa'             => 'JKL-111',
                'marca'             => 'Suzuki',
                'modelo'            => 'Vitara',
                'anio_fabricacion'  => 2017,
                'nombre_cliente'    => 'Pedro',
                'apellidos_cliente' => 'Vargas Huanca',
                'nro_documento'     => '11223344',
                'correo_cliente'    => 'pedro.vargas@gmail.com',
                'telefono_cliente'  => '+51 923 456 789',
            ],
            [
                'placa'             => 'STU-222',
                'marca'             => 'Volkswagen',
                'modelo'            => 'Golf',
                'anio_fabricacion'  => 2020,
                'nombre_cliente'    => 'Claudia',
                'apellidos_cliente' => 'Rojas Mamani',
                'nro_documento'     => '22334455',
                'correo_cliente'    => 'claudia.rojas@gmail.com',
                'telefono_cliente'  => '+51 967 890 123',
            ],
            [
                'placa'             => 'VWX-333',
                'marca'             => 'Ford',
                'modelo'            => 'Explorer',
                'anio_fabricacion'  => 2021,
                'nombre_cliente'    => 'Miguel',
                'apellidos_cliente' => 'Torres Ccama',
                'nro_documento'     => '33445566',
                'correo_cliente'    => 'miguel.torres@yahoo.com',
                'telefono_cliente'  => '+51 912 012 345',
            ],
            [
                'placa'             => 'YZA-444',
                'marca'             => 'Mitsubishi',
                'modelo'            => 'Outlander',
                'anio_fabricacion'  => 2016,
                'nombre_cliente'    => 'Sandra',
                'apellidos_cliente' => 'Chuquimia Apaza',
                'nro_documento'     => '44556677',
                'correo_cliente'    => 'sandra.chuquimia@gmail.com',
                'telefono_cliente'  => '+51 989 123 456',
            ],
            [
                'placa'             => 'BCD-555',
                'marca'             => 'Mazda',
                'modelo'            => 'CX-5',
                'anio_fabricacion'  => 2022,
                'nombre_cliente'    => 'Raúl',
                'apellidos_cliente' => 'Quispe Condori',
                'nro_documento'     => '55667788',
                'correo_cliente'    => 'raul.quispe@outlook.com',
                'telefono_cliente'  => '+51 934 234 567',
            ],
            [
                'placa'             => 'EFG-666',
                'marca'             => 'Renault',
                'modelo'            => 'Duster',
                'anio_fabricacion'  => 2019,
                'nombre_cliente'    => 'Vanessa',
                'apellidos_cliente' => 'Palomino Layme',
                'nro_documento'     => '66778899',
                'correo_cliente'    => 'vanessa.palomino@gmail.com',
                'telefono_cliente'  => '+51 956 345 678',
            ],
        ];

        foreach ($vehiculos as $data) {
            Vehiculo::create($data);
        }

        $this->command->info('✅ ' . count($vehiculos) . ' vehículos de prueba creados correctamente.');
    }
}