<?php

namespace App\Repositories\Interfaces;

interface ProjectRepositoryInterface
{
    public function getAllProject();
    public function getProject($id);
    public function createProject(array $data);
    public function updateProject($id, array $data);
    public function deleteProject($id);
    public function getHouseByProject($project);
    public function searchAndFilter($search, $location);
}
