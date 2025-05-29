<?php

namespace App\Repositories;

use App\Models\House;
use App\Models\ProgressPhoto;
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
        return ProgressReport::where('house_id', $houseId)->get();
    }

    public function getProgressData($id)
    {
        $progress = $this->getProgressByHouseId($id);
        $house = $this->getHouse($id);
        $photos = $this->showProgressPhoto($progress);

        return compact('progress', 'house', 'photos');
    }

    public function createProgres(array $data)
    {
        return ProgressReport::create($data);
    }

    public function addProgressPhoto(array $data)
    {
        return ProgressPhoto::create($data);
    }

    public function showProgressPhoto($progressCollection)
    {
        $ids = $progressCollection->pluck('progress_reports_id');
        return ProgressPhoto::whereIn('progress_reports_id', $ids)->get()->groupBy('progress_reports_id');
    }
}
