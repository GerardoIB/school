<?php
namespace App\Services;

// Si no tienes una clase BaseService personalizada, quita el "extends BaseService"
class VehiculoService 
{
    // Movemos los datos a una propiedad privada para reutilizarlos
    private $vehiculos = [
        [
            'id' => 1,
            'marca' => 'Toyota',
            'modelo' => 'Corolla',
            'anio' => 2022,
            'placa' => 'ABC-123',
            'color' => 'Blanco',
            'tipo' => 'Sedan',
            'kilometraje' => 15420
        ],
        [
            'id' => 2,
            'marca' => 'Honda',
            'modelo' => 'CR-V',
            'anio' => 2023,
            'placa' => 'XYZ-789',
            'color' => 'Negro',
            'tipo' => 'SUV',
            'kilometraje' => 8300
        ],
        [
            'id' => 3,
            'marca' => 'Nissan',
            'modelo' => 'Sentra',
            'anio' => 2021,
            'placa' => 'DEF-456',
            'color' => 'Gris',
            'tipo' => 'Sedan',
            'kilometraje' => 28900
        ],
        [
            'id' => 4,
            'marca' => 'Ford',
            'modelo' => 'Ranger',
            'anio' => 2024,
            'placa' => 'GHI-012',
            'color' => 'Azul',
            'tipo' => 'Pickup',
            'kilometraje' => 2100
        ],
        [
            'id' => 5,
            'marca' => 'Chevrolet',
            'modelo' => 'Onix',
            'anio' => 2020,
            'placa' => 'JKL-345',
            'color' => 'Rojo',
            'tipo' => 'Hatchback',
            'kilometraje' => 45200
        ]
    ];

    public function getVehiculos(){
        return $this->vehiculos;
    }

    // Método nuevo para buscar un solo vehículo
    public function getVehiculoById($id){
        // Buscamos dentro del array
        foreach($this->vehiculos as $vehiculo){
            if($vehiculo['id'] == $id){
                return $vehiculo;
            }
        }
        return null; // Si no lo encuentra
    }
}