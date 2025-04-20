<?php

namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;

interface VolumeRepositoryInterface
{
    public function getJob($jobId);
    public function getByJobId($jobId);
    public function calculateTotalVolume($jobId);
    public function store(Request $request, $jobId);
    public function update(Request $request, $jobId, $volumeId);
    public function delete($volumeId);
}
