<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Interfaces\VolumeRepositoryInterface;

class VolumeItemController extends Controller
{
    protected VolumeRepositoryInterface $volumeRepository;

    public function __construct(VolumeRepositoryInterface $volumeRepository)
    {
        $this->volumeRepository = $volumeRepository;
    }

    public function index($job_id)
    {
        $job = $this->volumeRepository->getSubJob($job_id);
        $volumes = $this->volumeRepository->getBySubJobId($job_id);
        $totalVolume = $this->volumeRepository->calculateTotalVolume($job_id);

        return view('volume.index', compact('job', 'volumes', 'totalVolume'));
    }

    public function store(Request $request, $job_id)
    {
        $request->validate([
            'description' => 'required|string|max:50',
            'amount' => 'required|numeric',
            'length' => 'nullable|numeric',
            'width' => 'nullable|numeric',
            'height' => 'nullable|numeric',
            'wide' => 'nullable|numeric',
        ]);

        // Simpan dan update total_volume di dalam repository
        $this->volumeRepository->store($request, $job_id);

        return redirect()->back()->with('success', 'Data volume berhasil ditambahkan');
    }

    public function update(Request $request, $job_id, $volume_id)
    {
        $request->validate([
            'description' => 'required|string|max:50',
            'amount' => 'required|numeric',
            'length' => 'nullable|numeric',
            'width' => 'nullable|numeric',
            'height' => 'nullable|numeric',
            'wide' => 'nullable|numeric',
        ]);

        // Update dan kalkulasi ulang total volume melalui repository
        $this->volumeRepository->update($request, $job_id, $volume_id);

        return redirect()->back()->with('success', 'Data volume berhasil diperbarui');
    }

    public function destroy($jobId, $volumeId)
    {
        $this->volumeRepository->delete($volumeId);

        return redirect()->route('volume.index', $jobId)->with('success', 'Data volume berhasil dihapus');
    }
}
