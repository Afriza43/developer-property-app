<?php

namespace App\Repositories\Interfaces;

interface RABRepositoryInterface
{
    public function getHouse($houseId);
    public function getJobCategoriesByHouseId($houseId);
    public function getJobsByHouseId($categoryId);
    public function getRAB($houseId);
    public function getJobCategory($categoryId);
    public function createJobCategory(array $data);
    public function updateJobCategory($id, array $data);
    public function deleteJobCategory($id);
}
