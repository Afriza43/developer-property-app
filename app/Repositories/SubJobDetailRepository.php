<?php

namespace App\Repositories;

use App\Models\SubJob;
use App\Repositories\Interfaces\SubJobDetailRepositoryInterface;

class SubJobDetailRepository implements SubJobDetailRepositoryInterface
{
    public function getJob($subJobId)
    {
        return SubJob::findOrFail($subJobId);
    }
    public function getJobDetail($subJob)
    {
        return SubJob::with(['materials', 'equipments', 'employees', 'job_type', 'job'])->find($subJob);
    }

    public function addMaterial($subJob, $materialId)
    {
        $subJob->materials()->attach($materialId, ['koefisien' => 0, 'total_cost' => 0, 'material_cost' => 0]);
    }

    public function addEquipment($subJob, $equipmentId)
    {
        $subJob->equipments()->attach($equipmentId, ['koefisien' => 0, 'total_cost' => 0, 'equipment_cost' => 0]);
    }

    public function addEmployee($subJob, $employeeId)
    {
        $subJob->employees()->attach($employeeId, ['koefisien' => 0, 'total_cost' => 0, 'wage' => 0]);
    }

    public function updateMaterial($subJob, $materialId, $data)
    {
        $subJob->materials()->updateExistingPivot($materialId, $data);
    }

    public function updateEquipment($subJob, $equipmentId, $data)
    {
        $subJob->equipments()->updateExistingPivot($equipmentId, $data);
    }

    public function updateEmployee($subJob, $employeeId, $data)
    {
        $subJob->employees()->updateExistingPivot($employeeId, $data);
    }

    public function deleteMaterial($subJob, $materialId)
    {
        $subJob->materials()->detach($materialId);
    }
    public function deleteEquipment($subJob, $equipmentId)
    {
        $subJob->materials()->detach($equipmentId);
    }
    public function deleteEmployee($subJob, $employeeId)
    {
        $subJob->materials()->detach($employeeId);
    }
}
