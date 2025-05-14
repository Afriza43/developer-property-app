<?php

namespace App\Repositories\Interfaces;

interface SubJobDetailRepositoryInterface
{
    public function getJob($subJobId);
    public function getJobDetail($subJob);
    public function addMaterial($subJob, $materialId);
    public function addEquipment($subJob, $equipmentId);
    public function addEmployee($subJob, $employeeId);
    public function updateMaterial($subJob, $materialId, $data);
    public function updateEquipment($subJob, $equipmentId, $data);
    public function updateEmployee($subJob, $employeeId, $data);
    public function deleteMaterial($subJob, $materialId);
    public function deleteEquipment($subJob, $equipmentId);
    public function deleteEmployee($subJob, $employeeId);
}
