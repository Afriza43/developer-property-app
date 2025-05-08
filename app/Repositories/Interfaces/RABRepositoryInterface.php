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
}
