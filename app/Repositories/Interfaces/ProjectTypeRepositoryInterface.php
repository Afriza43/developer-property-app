<?php

namespace App\Repositories\Interfaces;

interface ProjectTypeRepositoryInterface
{
    public function getProjectTypesByProject($projectId);
    public function createProjectType(array $data);
    public function updateProjectType($typeId, array $data);
    public function deleteProjectType($typeId);
    public function searchAndFilter($projectId, $type = null);
    public function projectData($projectId);
}
