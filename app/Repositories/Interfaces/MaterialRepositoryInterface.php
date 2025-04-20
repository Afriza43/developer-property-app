<?php

namespace App\Repositories\Interfaces;

interface MaterialRepositoryInterface
{
    public function getMaterials();
    public function getMaterialById($materialId);
    public function createMaterial(array $data);
    public function updateMaterial($id, array $data);
    public function deleteMaterial($id);
}
