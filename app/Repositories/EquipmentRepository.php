<?php

namespace App\Repositories;

use App\Models\Equipment;
use App\Repositories\Interfaces\EquipmentRepositoryInterface;

class EquipmentRepository implements EquipmentRepositoryInterface
{
    public function getEquipments()
    {
        return Equipment::all();
    }

    public function getEquipmentById($id)
    {
        return Equipment::find($id);
    }

    public function createEquipment(array $data)
    {
        return Equipment::create($data);
    }

    public function updateEquipment($id, array $data)
    {
        $equipment = Equipment::find($id);
        $equipment->update($data);
        return $equipment;
    }

    public function deleteEquipment($id)
    {
        $equipment = Equipment::find($id);
        return $equipment->delete();
    }
}
