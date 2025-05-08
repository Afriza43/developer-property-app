<?php

namespace App\Repositories;

use App\Models\ProjectType;
use App\Models\JobCategory;
use App\Repositories\Interfaces\RABRepositoryInterface;

class RABRepository implements RABRepositoryInterface
{
    public function getType($typeId)
    {
        return ProjectType::with('project')->where('type_id', $typeId)->first();
    }
    public function getJobsByTypeId($typeId)
    {
        $projectType = ProjectType::with('job_categories.jobs')->findOrFail($typeId);
        return $projectType->job_categories;
    }

    public function getRAB($typeId)
    {
        $type = $this->getType($typeId);

        $jobCategories = $this->getJobsByTypeId($typeId);

        return compact('type', 'jobCategories');
    }
    public function getJobCategory($categoryId)
    {
        return JobCategory::find($categoryId);
    }
    public function createJobCategory(array $data)
    {
        return JobCategory::create($data);
    }
    public function updateJobCategory($id, array $data)
    {
        $category = $this->getJobCategory($id);
        $category->update($data);
        return $category;
    }
    public function deleteJobCategory($id)
    {
        $category = $this->getJobCategory($id);
        $category->delete();
        return $category;
    }
}
