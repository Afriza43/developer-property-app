<?php

namespace App\Repositories;

use App\Models\Job;
use App\Repositories\Interfaces\JobDetailRepositoryInterface;

class JobDetailRepository implements JobDetailRepositoryInterface
{
    public function getJob($jobId)
    {
        return Job::findOrFail($jobId);
    }
    public function getJobDetail($job)
    {
        return Job::with(['materials', 'equipments', 'employees'])->find($job);
    }

    public function addMaterial($job, $materialId)
    {
        $job->materials()->attach($materialId, ['koefisien' => 0, 'total_cost' => 0]);
    }

    public function addEquipment($job, $equipmentId)
    {
        $job->equipments()->attach($equipmentId, ['koefisien' => 0, 'total_cost' => 0]);
    }

    public function addEmployee($job, $employeeId)
    {
        $job->employees()->attach($employeeId, ['koefisien' => 0, 'total_cost' => 0]);
    }

    public function updateMaterial($job, $materialId, $data)
    {
        $job->materials()->updateExistingPivot($materialId, $data);
    }

    public function updateEquipment($job, $equipmentId, $data)
    {
        $job->equipments()->updateExistingPivot($equipmentId, $data);
    }

    public function updateEmployee($job, $employeeId, $data)
    {
        $job->employees()->updateExistingPivot($employeeId, $data);
    }

    public function deleteMaterial($job, $materialId)
    {
        $job->materials()->detach($materialId);
    }
    public function deleteEquipment($job, $equipmentId)
    {
        $job->materials()->detach($equipmentId);
    }
    public function deleteEmployee($job, $employeeId)
    {
        $job->materials()->detach($employeeId);
    }
}
