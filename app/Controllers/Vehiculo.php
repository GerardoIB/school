<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Services\VehiculoService; // IMPORTANTE: Esta línea importa la clase

class Vehiculo extends BaseController
{
    public function index(){
        $service = new VehiculoService();
        $vehiculos = $service->getVehiculos();
        
        return $this->response->setJSON($vehiculos);
    }

    public function create(){
        echo 'Esta es la vista para crear vehiculos';
    }

    public function store(){
        echo 'Aqui fue procesado y creado la informacion del vehiculo';
    }

    public function edit($id){
        $service = new VehiculoService();
        
        // CORRECCIÓN: Usamos un método del servicio, no accedemos como array
        $vehiculo = $service->getVehiculoById($id);

        if ($vehiculo) {
            return $this->response->setJSON($vehiculo);
        } else {
            return $this->response->setJSON(['error' => 'Vehiculo no encontrado'])->setStatusCode(404);
        }
    }

    public function update($id){
        echo 'Aqui fue procesada y actualizada la informacion del vehiculo';
    }

    public function delete($id){
        echo 'El vehiculo con id '. $id .' ha sido eliminado'; 
    }
}