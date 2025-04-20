<?php

namespace App\Repositories\Interfaces;

interface JobRepositoryInterface
{
    public function getJobById($jobId);
    public function getCategoryId($categoryId);
    public function createJob(array $data);
    public function updateJob($id, array $data);
    public function deleteJob($id);
}
