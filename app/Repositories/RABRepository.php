<?php

namespace App\Repositories;

use App\Models\Job;
use App\Models\House;
use App\Models\JobCategory;
use App\Repositories\Interfaces\RABRepositoryInterface;

class RABRepository implements RABRepositoryInterface
{
    public function getHouse($houseId)
    {
        return House::find($houseId);
    }
    public function getJobCategoriesByHouseId($houseId)
    {
        return JobCategory::with('house')->where('house_id', $houseId)->get();
    }
    public function getJobsByHouseId($houseId)
    {
        return JobCategory::with('jobs')->where('house_id', $houseId)->get();
    }
    public function getRAB($houseId)
    {
        $house = $this->getHouse($houseId);

        $jobCategories = $this->getJobsByHouseId($houseId);

        return compact('house', 'jobCategories');
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
