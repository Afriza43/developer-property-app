<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Material;
use Illuminate\Http\Request;
use App\Repositories\JobDetailRepository;

class JobMaterialController extends Controller
{
    protected $repo;

    public function __construct(JobDetailRepository $repo)
    {
        $this->repo = $repo;
    }

    // Halaman untuk memilih material yang akan ditambahkan
    public function select(Request $request, $job_id)
    {
        $job = $this->repo->getJob($job_id);

        $query = Material::query();

        if ($request->filled('search')) {
            $query->where('material_name', 'LIKE', '%' . $request->search . '%');
        }

        $materials = $query->get();

        return view('unit-prices.job-materials', compact('job', 'materials'));
    }


    // Menyimpan banyak material terpilih ke pivot
    public function storeSelected(Request $request, $job_id)
    {
        $request->validate([
            'materials' => 'required|array',
            'materials.*' => 'exists:materials,material_id'
        ]);

        $job = $this->repo->getJob($job_id);

        foreach ($request->materials as $materialId) {
            $this->repo->addMaterial($job, $materialId);
        }

        return redirect()->route('jobs.priceAnalysis', $job_id)
            ->with('success', 'Material berhasil ditambahkan.');
    }

    public function updateSingle(Request $request, $jobId, $materialId)
    {
        $job = Job::findOrFail($jobId);
        $material = Material::findOrFail($materialId);

        $koefisien = floatval($request->input('koefisien'));
        $totalCost = $koefisien * $material->material_cost;

        $job->materials()->updateExistingPivot($materialId, [
            'koefisien' => $koefisien,
            'total_cost' => $totalCost,
        ]);

        return redirect()->back()->with('success', 'Data material berhasil diperbarui.');
    }

    public function destroy($jobId, $materialId)
    {
        $job = Job::findOrFail($jobId);
        $material = Material::findOrFail($materialId);

        $job->materials()->detach($materialId);

        return redirect()->back()->with('success', 'Material berhasil dihapus.');
    }
}
