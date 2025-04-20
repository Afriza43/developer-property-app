<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\JobDetailRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\Job;

class JobDetailController extends Controller
{
    protected $JobDetailRepository;

    public function __construct(JobDetailRepositoryInterface $JobDetailRepository)
    {
        $this->JobDetailRepository = $JobDetailRepository;
    }
    public function priceAnalysis($jobId)
    {
        $jobData = $this->JobDetailRepository->getJobDetail($jobId);
        return view('unit-prices.ahs', compact('jobData'));
    }

    public function addMaterial(Request $request, Job $job)
    {
        $this->JobDetailRepository->addMaterial($job, $request->material_id);
        return back();
    }

    public function addEquipment(Request $request, Job $job)
    {
        $this->JobDetailRepository->addEquipment($job, $request->equipment_id);
        return back();
    }

    public function addEmployee(Request $request, Job $job)
    {
        $this->JobDetailRepository->addEmployee($job, $request->employee_id);
        return back();
    }

    public function updateMaterial(Request $request, Job $job, $materialId)
    {
        $this->JobDetailRepository->updateMaterial($job, $materialId, $request->only('koefisien', 'total_harga'));
        return back();
    }

    public function updateEquipment(Request $request, Job $job, $equipmentId)
    {
        $this->JobDetailRepository->updateEquipment($job, $equipmentId, $request->only('koefisien', 'total_harga'));
        return back();
    }

    public function updateEmployee(Request $request, Job $job, $employeeId)
    {
        $this->JobDetailRepository->updateEmployee($job, $employeeId, $request->only('koefisien', 'total_harga'));
        return back();
    }

    public function deleteMaterial($job, $materialId)
    {
        $this->JobDetailRepository->deleteMaterial($job, $materialId);
        return back();
    }
    public function deleteEquipment($job, $equipmentId)
    {
        $this->JobDetailRepository->deleteEquipment($job, $equipmentId);
        return back();
    }
    public function deleteEmployee($job, $employeeId)
    {
        $this->JobDetailRepository->deleteEmployee($job, $employeeId);
        return back();
    }

    public function updateTotalCost($job_id)
    {
        $job = $this->JobDetailRepository->getJobDetail($job_id);

        $totalMaterial = $job->materials->sum(fn($item) => $item->pivot->total_cost ?? 0);
        $totalEquipment = $job->equipments->sum(fn($item) => $item->pivot->total_cost ?? 0);
        $totalEmployee = $job->employees->sum(fn($item) => $item->pivot->total_cost ?? 0);

        $subtotal = $totalMaterial + $totalEquipment + $totalEmployee;
        $ppn = $subtotal * 0.1;
        $grandTotal = $subtotal + $ppn;

        $job->total_cost = $grandTotal;
        $job->save();

        return redirect()->route('rab.index', ['house_id' => $job->job_category->house->house_id])
            ->with('success', 'Total biaya berhasil disimpan.');
    }
}
