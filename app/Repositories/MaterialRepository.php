<?php

namespace App\Repositories;

use App\Models\Material;
use App\Repositories\Interfaces\MaterialRepositoryInterface;

class MaterialRepository implements MaterialRepositoryInterface
{
    public function getMaterials()
    {
        return Material::all();
    }
    public function getMaterialById($materialId)
    {
        return Material::findOrFail($materialId);
    }
    public function createMaterial(array $data)
    {
        return Material::create($data);
    }
    public function updateMaterial($id, array $data)
    {
        $material = $this->getMaterialById($id);
        $material->update($data);
        return $material;
    }
    public function deleteMaterial($id)
    {
        $material = $this->getMaterialById($id);
        $material->delete();
        return $material;
    }
}
