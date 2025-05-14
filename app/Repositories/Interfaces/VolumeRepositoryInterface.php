<?php

namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;

interface VolumeRepositoryInterface
{
    public function getSubJob($subJobId);
    public function getBySubJobId($subJobId);
    public function calculateTotalVolume($jobId);
    public function store(Request $request, $jobId);
    public function update(Request $request, $jobId, $volumeId);
    public function delete($volumeId);
}
