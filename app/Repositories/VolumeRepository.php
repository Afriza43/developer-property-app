<?php

namespace App\Repositories;

use App\Models\Job;
use App\Models\SubJob;
use App\Models\VolumeItem;
use App\Models\JobCategory;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\VolumeRepositoryInterface;

class VolumeRepository implements VolumeRepositoryInterface
{
    public function getSubJob($subJobId)
    {
        return SubJob::with(['job', 'job_type'])->findOrFail($subJobId);
    }

    public function getBySubJobId($subJobId)
    {
        return VolumeItem::where('sub_job_id', $subJobId)->get();
    }

    public function calculateTotalVolume($subJobId)
    {
        return VolumeItem::where('sub_job_id', $subJobId)
            ->get()
            ->sum(function ($item) {
                return $item->volume_per_unit * $item->amount;
            });
    }

    public function store(Request $request, $subJobId)
    {
        $length = $request->input('length', 0);
        $width = $request->input('width', 0);
        $height = $request->input('height', 0);
        $wide = $request->input('wide', 0);

        $satuanVolume = $request->query('satuan_volume');

        if ($satuanVolume === 'm3') {
            if ($length > 0 && $width > 0 && $height > 0) {
                $volumePerUnit = $length * $width * $height;
                $wide = $length * $width;
            } elseif ($wide > 0 && $height > 0) {
                $volumePerUnit = $wide * $height;
            } elseif ($request->input('volume_per_unit', 0) > 0) {
                $volumePerUnit = $request->input('volume_per_unit', 0);
            } else {
                $volumePerUnit = 0;
            }
        } elseif ($satuanVolume === 'm2') {
            if ($length > 0 && $width > 0) {
                $wide = $length * $width;
                $volumePerUnit = $wide;
            } elseif ($request->input('wide', 0) > 0) {
                $volumePerUnit = $request->input('wide', 0);
            } else {
                $volumePerUnit = 0;
            }
        } else {
            $volumePerUnit = $request->input('volume_per_unit', 0);
        }

        VolumeItem::create([
            'sub_job_id' => $subJobId,
            'description' => $request->description,
            'amount' => $request->amount,
            'length' => $length,
            'width' => $width,
            'height' => $height,
            'wide' => $wide,
            'volume_per_unit' => $volumePerUnit,
        ]);

        $totalVolume = $this->calculateTotalVolume($subJobId);

        // Update total_volume pada tabel sub_jobs
        SubJob::where('sub_job_id', $subJobId)->update([
            'total_volume' => $totalVolume,
        ]);
    }

    public function update(Request $request, $subJobId, $volumeId)
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

        $totalVolume = $this->calculateTotalVolume($subJobId);

        SubJob::where('sub_job_id', $subJobId)->update([
            'total_volume' => $totalVolume,
        ]);
    }

    public function delete($volumeItemId)
    {
        $volumeItem = VolumeItem::findOrFail($volumeItemId);
        $subJobId = $volumeItem->sub_job_id;
        $volumeItem->delete();

        $totalVolume = $this->calculateTotalVolume($subJobId);

        SubJob::where('sub_job_id', $subJobId)->update([
            'total_volume' => $totalVolume,
        ]);
    }
}
