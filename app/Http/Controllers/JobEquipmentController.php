<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\SubJob;
use App\Models\Equipment;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\SubJobDetailRepositoryInterface;

class JobEquipmentController extends Controller
{
    protected $repo;

    public function __construct(SubJobDetailRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    // Halaman untuk memilih Equipment yang akan ditambahkan
    public function select(Request $request, $subJobId)
    {
        $subJob = $this->repo->getJob($subJobId);

        $query = Equipment::query();

        if ($request->filled('search')) {
            $query->where('equipment_name', 'LIKE', '%' . $request->search . '%');
        }

        $equipments = $query->get();

        return view('unit-prices.job-equipments', compact('subJob', 'equipments'));
    }

    public function storeSelected(Request $request, $subJobId)
    {
        $request->validate([
            'equipments' => 'required|array',
            'equipments.*' => 'exists:equipments,equipment_id'
        ]);

        $subJob = $this->repo->getJob($subJobId);

        foreach ($request->equipments as $equipmentId) {
            $this->repo->addEquipment($subJob, $equipmentId);
        }

        return redirect()->route('jobs.priceAnalysis', $subJobId)
            ->with('success', 'Equipment berhasil ditambahkan ke sub-job.');
    }

    public function updateSingle(Request $request, $subJobId, $equipmentId)
    {
        $subJob = SubJob::findOrFail($subJobId);
        $equipment = Equipment::findOrFail($equipmentId);

        $koefisien = floatval($request->input('koefisien'));
        $equipmentCost = floatval($request->input('equipment_cost'));
        $totalCost = $koefisien * $equipmentCost;

        $subJob->equipments()->updateExistingPivot($equipmentId, [
            'koefisien' => $koefisien,
            'equipment_cost' => $equipmentCost,
            'total_cost' => $totalCost,
        ]);

        return redirect()->back()->with('success', 'Data equipment berhasil diperbarui.');
    }

    public function destroy($subJobId, $equipmentId)
    {
        $subJob = SubJob::findOrFail($subJobId);
        $subJob->equipments()->detach($equipmentId);

        return redirect()->back()->with('success', 'Data equipment berhasil dihapus.');
    }
}
