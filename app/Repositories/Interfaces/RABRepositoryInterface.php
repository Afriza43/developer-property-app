<?php

namespace App\Repositories\Interfaces;

interface RABRepositoryInterface
{
    public function getType($typeId);
    public function getJobsByTypeId($categoryId);
    public function getRAB($typeId);
    public function getJobCategory($categoryId);
    public function createJobCategory(array $data);
    public function updateJobCategory($id, array $data);
    public function deleteJobCategory($id);
    public function updateBudgetPlan($typeId, $budgetPlan);
    public function renameCategory($jobtype_id, $newName);
    public function getNewCategoryName($jobtype_id);
    public function deleteJob($subJobId);
    public function getNewJobName($sub_job_id);
    public function renameJob($sub_job_id, $newName);
}
