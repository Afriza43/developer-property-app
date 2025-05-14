<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;
use App\Repositories\EquipmentRepository;

class EquipmentController extends Controller
{
    public $equipmentRepository;

    public function __construct(EquipmentRepository $equipmentRepository)
    {
        $this->equipmentRepository = $equipmentRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $equipments = $this->equipmentRepository->getEquipments();

        if ($request->has('set_redirect') && $request->has('sub_job_id')) {
            session(['redirect_sub_job_id' => $request->query('sub_job_id')]);
        }

        return view('equipments.index', compact('equipments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('equipments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'equipment_name'   => 'required|string|max:20',
            'description'      => 'required|string|max:50',
            'equipment_unit'   => 'required',
        ]);

        $this->equipmentRepository->createEquipment($data);

        return redirect()->back()->with('success', 'Equipment created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Equipment $equipment)
    {
        $equipment = $this->equipmentRepository->getEquipmentById($equipment->id);
        return view('equipments.index', compact('equipment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Equipment $equipment)
    {
        $equipment = $this->equipmentRepository->getEquipmentById($equipment->id);
        return view('equipments.edit', compact('equipment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Equipment $equipment)
    {
        $data = $request->validate([
            'equipment_name'   => 'required|string|max:20',
            'description'      => 'required|string|max:50',
            'equipment_unit'   => 'required',
        ]);

        $this->equipmentRepository->updateEquipment($equipment->equipment_id, $data);

        return redirect()->back()->with('success', 'Equipment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Equipment $equipment)
    {
        $this->equipmentRepository->deleteEquipment($equipment->equipment_id);

        return redirect()->back()->with('success', 'Equipment deleted successfully.');
    }
}
