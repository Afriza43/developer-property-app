<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\MaterialRepositoryInterface;

class MaterialController extends Controller
{
    public $materialRepository;

    public function __construct(MaterialRepositoryInterface $materialRepository)
    {
        $this->materialRepository = $materialRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $materials = $this->materialRepository->getMaterials();

        return view('materials.index', compact('materials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('materials.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'material_name'   => 'required|string|max:25',
            'description'     => 'required|string|max:50',
            'material_unit'   => 'required',
            'material_cost'   => 'required|numeric|min:0',
        ]);


        $this->materialRepository->createMaterial($data);

        return redirect()->back()->with('success', 'Material berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Material $material)
    {
        $material = $this->materialRepository->getMaterialById($material->id);

        return view('materials.index', compact('material'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Material $material)
    {
        $material = $this->materialRepository->getMaterialById($material->id);
        return view('materials.edit', compact('material'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Material $material)
    {
        $data = $request->validate([
            'material_name'   => 'required|string|max:25',
            'description'     => 'required|string|max:50',
            'material_unit'   => 'required',
            'material_cost'   => 'required|numeric|min:0',
        ]);

        $this->materialRepository->updateMaterial($material->material_id, $data);

        return redirect()->back()->with('success', 'Material berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Material $material)
    {
        $this->materialRepository->deleteMaterial($material->material_id);

        return redirect()->back()->with('success', 'Material berhasil dihapus.');
    }
}
