<?php

namespace App\Repositories;

use App\Models\House;
use App\Models\ProgressReport;
use App\Repositories\Interfaces\ProgresRepositoryInterface;

class ProgresRepository implements ProgresRepositoryInterface
{
    public function getProgres($id)
    {
        return ProgressReport::findOrFail($id);
    }

    public function getHouse($houseId)
    {
        return House::find($houseId);
    }

    public function getProgressByHouseId($houseId)
    {
        return ProgressReport::with('house')->where('house_id', $houseId)->get();
    }

    public function getProgressData($id)
    {
        $progress = $this->getProgressByHouseId($id);
        $house = $this->getHouse($id);
        return compact('progress', 'house');
    }

    public function createProgres(array $data)
    {
        return ProgressReport::create($data);
    }
}
