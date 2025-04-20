<?php

namespace App\Repositories\Interfaces;

interface EquipmentRepositoryInterface
{
    public function getEquipments();
    public function getEquipmentById($id);
    public function createEquipment(array $data);
    public function updateEquipment($id, array $data);
    public function deleteEquipment($id);
}
