<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\House;
use App\Models\Project;
use App\Models\ExpenseReport;
use App\Models\ProgressPhoto;
use App\Models\ProgressReport;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Interfaces\HouseRepositoryInterface;

class HouseRepository implements HouseRepositoryInterface
{
    public function getHouse($id)
    {
        return House::with('project')->findOrFail($id);
    }

    public function getProject($id)
    {
        $project = Project::with('project_types')->where('project_id', $id)->first();
        return $project;
    }

    public function countHouses($projectId)
    {
        $countHouses = House::where('project_id', $projectId)->count();
        return $countHouses;
    }
    public function countBlok($projectId)
    {
        $countBlok = House::where('project_id', $projectId)->distinct('block')->count('block');
        return $countBlok;
    }
    public function countType($projectId)
    {
        $countType = House::where('project_id', $projectId)->distinct('type')->count('type');
        return $countType;
    }

    // public function getHouseById($id)
    // {
    //     return House::with(['project', 'expense_reports'])->where('project_id', $id)->get()->map(function ($house) {
    //         $house->house_cost = $house->expense_reports->sum('total_expense');
    //         $house->save();
    //         return $house;
    //     });
    // }

    public function getHouseById($projectId)
    {
        $project = $this->getProject($projectId);
        $projectTypes = collect($project->project_types);

        return House::with(['project', 'expense_reports'])->where('project_id', $projectId)->get()->map(function ($house) use ($projectTypes) {
            $house->house_cost = $house->expense_reports->sum('total_expense');

            $matchingType = $projectTypes->first(function ($type) use ($house) {
                return $type->type === $house->type;
            });

            $house->budget_plan = $matchingType?->budget_plan ?? 0;
            $house->profit_loss = $house->budget_plan - $house->house_cost;

            return $house;
        });
    }


    public function getHousesData($projectId)
    {
        $houses = $this->getHouseById($projectId);
        $project = $this->getProject($projectId);
        $countHouses = $this->countHouses($projectId);
        $countBlok = $this->countBlok($projectId);
        $countType = $this->countType($projectId);

        return compact('houses', 'project', 'countHouses', 'countBlok', 'countType');
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

    public function getProgressReports($id)
    {
        $progressReports = ProgressReport::where('house_id', $id)->get();
        return $progressReports;
    }

    public function getExpenseReports($id)
    {
        $expenseReports = ExpenseReport::where('house_id', $id)->get();
        return $expenseReports;
    }

    public function showProgressPhoto($progressReports)
    {
        $progressIds = $progressReports->pluck('progress_reports_id');
        $photos = ProgressPhoto::whereIn('progress_reports_id', $progressIds)->get()->groupBy('progress_reports_id');

        return $photos;
    }
}
