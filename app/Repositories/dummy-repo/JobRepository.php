<?php

namespace App\Repositories;

use App\Models\Job;
use App\Models\JobCategory;
use App\Repositories\Interfaces\JobRepositoryInterface;

class JobRepository implements JobRepositoryInterface
{
    public function getJobById($jobId)
    {
        return Job::find($jobId);
    }

    public function getCategoryId($categoryId)
    {
        return JobCategory::find($categoryId);
    }

    public function createJob(array $data)
    {
        return Job::create($data);
    }
    public function updateJob($id, array $data)
    {
        $job = $this->getJobById($id);
        $job->update($data);
        return $job;
    }
    public function deleteJob($id)
    {
        $job = $this->getJobById($id);
        $job->delete();
        return $job;
    }
}
