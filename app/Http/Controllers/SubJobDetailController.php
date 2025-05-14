<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\SubJob;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\SubJobDetailRepositoryInterface;

class SubJobDetailController extends Controller
{
    protected $subJobDetailRepository;

    public function __construct(SubJobDetailRepositoryInterface $subJobDetailRepository)
    {
        $this->subJobDetailRepository = $subJobDetailRepository;
    }
    public function priceAnalysis($subJobId)
    {
        $jobData = $this->subJobDetailRepository->getJobDetail($subJobId);
        return view('unit-prices.ahs', compact('jobData'));
    }

    public function addMaterial(Request $request, SubJob $subJob)
    {
        $this->subJobDetailRepository->addMaterial($subJob, $request->material_id);
        return back();
    }

    public function addEquipment(Request $request, SubJob $subJob)
    {
        $this->subJobDetailRepository->addEquipment($subJob, $request->equipment_id);
        return back();
    }

    public function addEmployee(Request $request, SubJob $subJob)
    {
        $this->subJobDetailRepository->addEmployee($subJob, $request->employee_id);
        return back();
    }

    public function updateMaterial(Request $request, SubJob $subJob, $materialId)
    {
        $this->subJobDetailRepository->updateMaterial($subJob, $materialId, $request->only('koefisien', 'total_cost', 'material_cost'));
        return back();
    }

    public function updateEquipment(Request $request, SubJob $subJob, $equipmentId)
    {
        $this->subJobDetailRepository->updateEquipment($subJob, $equipmentId, $request->only('koefisien', 'total_cost', 'equipment_cost'));
        return back();
    }

    public function updateEmployee(Request $request, SubJob $subJob, $employeeId)
    {
        $this->subJobDetailRepository->updateEmployee($subJob, $employeeId, $request->only('koefisien', 'total_cost', 'wage'));
        return back();
    }

    public function deleteMaterial($subJob, $materialId)
    {
        $this->subJobDetailRepository->deleteMaterial($subJob, $materialId);
        return back();
    }
    public function deleteEquipment($subJob, $equipmentId)
    {
        $this->subJobDetailRepository->deleteEquipment($subJob, $equipmentId);
        return back();
    }
    public function deleteEmployee($subJob, $employeeId)
    {
        $this->subJobDetailRepository->deleteEmployee($subJob, $employeeId);
        return back();
    }

    public function updateTotalCost($subJobId)
    {
        $subJob = $this->subJobDetailRepository->getJobDetail($subJobId);

        $totalMaterial = $subJob->materials->sum(fn($item) => $item->pivot->total_cost ?? 0);
        $totalEquipment = $subJob->equipments->sum(fn($item) => $item->pivot->total_cost ?? 0);
        $totalEmployee = $subJob->employees->sum(fn($item) => $item->pivot->total_cost ?? 0);

        $subtotal = $totalMaterial + $totalEquipment + $totalEmployee;
        $ppn = $subtotal * 0.1;
        $grandTotal = $subtotal + $ppn;

        $subJob->job_cost = $grandTotal;
        $subJob->save();

        return redirect()->route('rab.index', ['type_id' => $subJob->job_type->type_id])
            ->with('success', 'Total biaya berhasil disimpan.');
    }
}
