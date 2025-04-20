<?php

namespace App\Repositories;

use App\Models\Job;
use App\Models\VolumeItem;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\VolumeRepositoryInterface;

class VolumeRepository implements VolumeRepositoryInterface
{
    public function getJob($jobId)
    {
        return Job::findOrFail($jobId);
    }

    public function getByJobId($jobId)
    {
        return VolumeItem::where('job_id', $jobId)->get();
    }

    public function calculateTotalVolume($jobId)
    {
        return VolumeItem::where('job_id', $jobId)
            ->get()
            ->sum(function ($item) {
                return $item->volume_per_unit * $item->amount;
            });
    }
    public function store(Request $request, $jobId)
    {
        $length = $request->input('length', 0);
        $width = $request->input('width', 0);
        $height = $request->input('height', 0);
        $wide = $request->input('wide', 0);

        $volumePerUnit = 0;
        if ($length > 0 && $width > 0 && $height > 0) {
            $volumePerUnit = $length * $width * $height;
            $wide = $length * $width;
        } elseif ($wide > 0 && $height > 0) {
            $volumePerUnit = $wide * $height;
        }

        VolumeItem::create([
            'job_id' => $jobId,
            'description' => $request->description,
            'amount' => $request->amount,
            'length' => $length,
            'width' => $width,
            'height' => $height,
            'wide' => $wide,
            'volume_per_unit' => $volumePerUnit,
        ]);

        $totalVolume = $this->calculateTotalVolume($jobId);
        Job::where('job_id', $jobId)->update(['total_volume' => $totalVolume]);
    }

    public function update(Request $request, $jobId, $volumeId)
    {
        $length = $request->input('length', 0);
        $width = $request->input('width', 0);
        $height = $request->input('height', 0);
        $wide = $request->input('wide', 0);
        $volumePerUnit = $request->input('volume_per_unit', 0);

        if ($length > 0 && $width > 0 && $height > 0) {
            $volumePerUnit = $length * $width * $height;
            $wide = $length * $width;
        } elseif ($wide > 0 && $height > 0) {
            $volumePerUnit = $wide * $height;
        } elseif ($volumePerUnit > 0) {
            $length = 0;
            $width = 0;
            $height = 0;
            $wide = 0;
        }

        VolumeItem::where('volume_items_id', $volumeId)->update([
            'description' => $request->description,
            'amount' => $request->amount,
            'length' => $length,
            'width' => $width,
            'height' => $height,
            'wide' => $wide,
            'volume_per_unit' => $volumePerUnit,
        ]);

        // Recalculate total volume after update
        $totalVolume = $this->calculateTotalVolume($jobId);
        Job::where('job_id', $jobId)->update(['total_volume' => $totalVolume]);
    }

    public function delete($id)
    {
        $volumeItem = VolumeItem::findOrFail($id);
        $jobId = $volumeItem->job_id;
        $volumeItem->delete();

        $totalVolume = $this->calculateTotalVolume($jobId);
        Job::where('job_id', $jobId)->update(['total_volume' => $totalVolume]);
    }
}
