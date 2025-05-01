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
    public function searchAndFilter($search = null, $location = null)
    {
        $searchLocate = Project::when($search, function ($query, $search) {
            $query->where('project_name', 'like', '%' . $search . '%');
        })->when($location, function ($query, $location) {
            $query->where('location', $location);
        })->get();

        return $searchLocate;
    }
}
