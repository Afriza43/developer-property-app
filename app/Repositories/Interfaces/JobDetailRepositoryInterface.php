<?php

namespace App\Repositories\Interfaces;

interface JobDetailRepositoryInterface
{
    public function getJob($jobId);
    public function getJobDetail($job);
    public function addMaterial($job, $materialId);
    public function addEquipment($job, $equipmentId);
    public function addEmployee($job, $employeeId);
    public function updateMaterial($job, $materialId, $data);
    public function updateEquipment($job, $equipmentId, $data);
    public function updateEmployee($job, $employeeId, $data);
    public function deleteMaterial($job, $materialId);
    public function deleteEquipment($job, $equipmentId);
    public function deleteEmployee($job, $employeeId);
}
