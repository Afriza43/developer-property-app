<?php

namespace App\Repositories;

use App\Models\House;
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
        $countHouses = $this->countHousesById($id);
        $countBlok = $this->countBlokById($id);
        $countType = $this->countTypeById($id);

        return compact('project', 'houses', 'countHouses', 'countBlok', 'countType');
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

    public function countProject()
    {
        $totalProjects = Project::count();
        return $totalProjects;
    }

    public function countHouses()
    {
        $totalHouses = House::count();
        return $totalHouses;
    }

    public function sumCost()
    {
        $totalCost = Project::sum('total_cost');
        return $totalCost;
    }

    public function countLocation()
    {
        $totalLocation = Project::distinct('location')->count('location');
        return $totalLocation;
    }

    public function countHousesById($id)
    {
        $countHouses = House::where('project_id', $id)->count();
        return $countHouses;
    }
    public function countBlokById($id)
    {
        $countBlok = House::where('project_id', $id)->distinct('block')->count('block');
        return $countBlok;
    }
    public function countTypeById($id)
    {
        $countType = House::where('project_id', $id)->distinct('type')->count('type');
        return $countType;
    }
}
