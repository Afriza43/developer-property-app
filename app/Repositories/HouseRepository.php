<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\House;
use App\Models\Project;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Interfaces\HouseRepositoryInterface;

class HouseRepository implements HouseRepositoryInterface
{
    public function getHouse($id)
    {
        return House::findOrFail($id);
    }

    public function getUser()
    {
        return User::all();
    }

    public function getProject($id)
    {
        return Project::where('project_id', $id)->first();
    }

    public function getHouseById($id)
    {
        return House::with('project')->where('project_id', $id)->get();
    }

    public function getHousesData($projectId)
    {
        $houses = $this->getHouseById($projectId);
        $project = $this->getProject($projectId);

        return compact('houses', 'project');
    }


    public function createHouse(array $data)
    {

        return House::create($data);
    }

    public function updateHouse($houseId, array $data)
    {
        $house = $this->getHouse($houseId);

        // if (request()->hasFile('image')) {
        //     if ($house->image && Storage::disk('public')->exists($house->image)) {
        //         Storage::disk('public')->delete($house->image);
        //     }
        //     $data['image'] = request()->file('image')->store('images/houses', 'public');
        // }

        $house->update($data);
        return $house;
    }

    public function deleteHouse($houseId)
    {
        $house = $this->getHouse($houseId);
        $house->delete();
        return $house;
    }
    public function viewHouse($house)
    {
        return $house->load('project');
    }

    public function searchByName(string $name)
    {
        return House::where('name', 'like', '%' . $name . '%')->get();
    }
}
