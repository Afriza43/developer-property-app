<?php

namespace App\Repositories;

use App\Models\Project;
use App\Models\ProjectType;
use App\Repositories\Interfaces\ProjectTypeRepositoryInterface;

class ProjectTypeRepository implements ProjectTypeRepositoryInterface
{
    public function getProjectTypesByProject($projectId)
    {
        return ProjectType::with('project')->where('project_id', $projectId)->get();
    }

    public function createProjectType(array $data)
    {
        return ProjectType::create($data);
    }

    public function updateProjectType($typeId, array $data)
    {
        $type = ProjectType::findOrFail($typeId);
        $type->update($data);
        return $type;
    }

    public function deleteProjectType($typeId)
    {
        $type = ProjectType::findOrFail($typeId);
        return $type->delete();
    }

    public function searchAndFilter($projectId, $type = null)
    {
        return ProjectType::where('project_id', $projectId)
            ->when($type, function ($query, $type) {
                $query->where('type', $type);
            })
            ->get();
    }

    public function projectData($projectId)
    {
        $project = Project::with('project_types')->findOrFail($projectId);
        return $project;
    }
}
