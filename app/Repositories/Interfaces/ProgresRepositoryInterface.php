<?php

namespace App\Repositories\Interfaces;

interface ProgresRepositoryInterface
{
    public function getHouse($houseId);
    public function getProgres($id);
    public function getProgressByHouseId($houseId);
    public function getProgressData($id);
    public function createProgres(array $data);
}
