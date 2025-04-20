<?php

namespace App\Repositories;

use App\Models\Project;
use App\Repositories\Interfaces\ProjectRepositoryInterface;

class ProjectRepository implements ProjectRepositoryInterface
{

    public function getAllProject()
    {
        return Project::all();
    }

    public function getProject($id)
    {
        return Project::findOrFail($id);
    }

    public function getHouseByProject($id)
    {

        $project = Project::with('houses')->findOrFail($id);
        $houses = $project->houses;

        return compact('project', 'houses');
    }

    public function createProject(array $data)
    {
        return Project::create($data);
    }

    public function updateProject($id, array $data)
    {
        $project = Project::findOrFail($id);
        $project->update($data);
        return $project;
    }

    public function deleteProject($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();
        return $project;
    }
    public function searchByName(string $name)
    {
        return Project::where('name', 'like', '%' . $name . '%')->get();
    }
}
