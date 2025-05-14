<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\SubJob;
use App\Models\Material;
use Illuminate\Http\Request;
use App\Repositories\SubJobDetailRepository;

class JobMaterialController extends Controller
{
    protected $repo;

    public function __construct(SubJobDetailRepository $repo)
    {
        $this->repo = $repo;
    }

    // Halaman untuk memilih material yang akan ditambahkan
    public function select(Request $request, $subJobId)
    {
        $subJob = $this->repo->getJob($subJobId);

        $query = Material::query();

        if ($request->filled('search')) {
            $query->where('material_name', 'LIKE', '%' . $request->search . '%');
        }

        $materials = $query->get();
        session(['redirect_after_material' => request()->fullUrl()]);

        return view('unit-prices.job-materials', compact('subJob', 'materials'));
    }


    // Menyimpan banyak material terpilih ke pivot
    public function storeSelected(Request $request, $subJobId)
    {
        $request->validate([
            'materials' => 'required|array',
            'materials.*' => 'exists:materials,material_id'
        ]);

        $subJob = $this->repo->getJob($subJobId);

        foreach ($request->materials as $materialId) {
            $this->repo->addMaterial($subJob, $materialId);
        }

        return redirect()->route('jobs.priceAnalysis', $subJobId)
            ->with('success', 'Material berhasil ditambahkan.');
    }

    public function updateSingle(Request $request, $subJobId, $materialId)
    {
        $subJob = SubJob::findOrFail($subJobId);
        $material = Material::findOrFail($materialId);

        $koefisien = floatval($request->input('koefisien'));
        $materialCost = floatval($request->input('material_cost'));
        $totalCost = $koefisien * $materialCost;

        $subJob->materials()->updateExistingPivot($materialId, [
            'koefisien' => $koefisien,
            'material_cost' => $materialCost,
            'total_cost' => $totalCost,
        ]);

        return redirect()->back()->with('success', 'Data material berhasil diperbarui.');
    }

    public function destroy($subJobId, $materialId)
    {
        $subJob = SubJob::findOrFail($subJobId);
        $subJob->materials()->detach($materialId);

        return redirect()->back()->with('success', 'Material berhasil dihapus.');
    }
}
