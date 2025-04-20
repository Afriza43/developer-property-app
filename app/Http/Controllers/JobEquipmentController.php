<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Equipment;
use Illuminate\Http\Request;
use App\Repositories\JobDetailRepository;

class JobEquipmentController extends Controller
{
    protected $repo;

    public function __construct(JobDetailRepository $repo)
    {
        $this->repo = $repo;
    }

    // Halaman untuk memilih Equipment yang akan ditambahkan
    public function select(Request $request, $job_id)
    {
        $job = $this->repo->getJob($job_id);

        $query = Equipment::query();

        if ($request->filled('search')) {
            $query->where('equipment_name', 'LIKE', '%' . $request->search . '%');
        }

        $equipments = $query->get();

        return view('unit-prices.job-equipments', compact('job', 'equipments'));
    }


    // Menyimpan banyak equipment terpilih ke pivot
    public function storeSelected(Request $request, $job_id)
    {
        $request->validate([
            'equipments' => 'required|array',
            'equipments.*' => 'exists:equipments,equipment_id'
        ]);

        $job = $this->repo->getJob($job_id);

        foreach ($request->equipments as $equipmentId) {
            $this->repo->addEquipment($job, $equipmentId);
        }

        return redirect()->route('jobs.priceAnalysis', $job_id)
            ->with('success', 'equipment berhasil ditambahkan.');
    }

    public function updateSingle(Request $request, $jobId, $equipmentId)
    {
        $job = Job::findOrFail($jobId);
        $equipment = Equipment::findOrFail($equipmentId);

        $koefisien = floatval($request->input('koefisien'));
        $totalCost = $koefisien * $equipment->equipment_cost;

        $job->equipments()->updateExistingPivot($equipmentId, [
            'koefisien' => $koefisien,
            'total_cost' => $totalCost,
        ]);

        return redirect()->back()->with('success', 'Data equipment berhasil diperbarui.');
    }

    public function destroy($jobId, $equipmentId)
    {
        $job = Job::findOrFail($jobId);
        $job->equipments()->detach($equipmentId);

        return redirect()->back()->with('success', 'Data equipment berhasil dihapus.');
    }
}
