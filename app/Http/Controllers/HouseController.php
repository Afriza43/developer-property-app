<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\HouseRepository;

class HouseController extends Controller
{
    protected $houseRepository;

    public function __construct(HouseRepository $houseRepository)
    {
        $this->houseRepository = $houseRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = $this->houseRepository->getHousesData($request->project_id);

        return view('houses.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $project_id = $request->query('project_id');
        return view('houses.create', compact('project_id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'block' => 'required|string|max:8',
            'number' => 'required|string|max:2',
            'type' => 'required|string|max:8',
            'house_cost' => 'nullable',
            'project_id' => 'required|exists:projects,project_id',
        ]);

        $data['name'] = $data['block'] . ' - No. ' . $data['number'];

        $this->houseRepository->createHouse($data);

        return redirect()->back()->with('success', 'Rumah berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $houseId)
    {
        $type = $request->query('type');
        $totalExpense = $this->houseRepository->sumExpense($houseId);
        $house = $this->houseRepository->getHouse($houseId);
        $expenseReports = [];
        $progressReports = [];
        $photos = collect();

        if ($type === 'expenses') {
            $expenseReports = $house->expense_reports;
        } elseif ($type === 'progress') {
            $progressReports = $house->progress_reports;
            $photos = $this->houseRepository->showProgressPhoto($progressReports);
        }

        return view('unit-reports.index', compact('house', 'type', 'expenseReports', 'progressReports', 'photos', 'totalExpense'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($houseId)
    {
        $house = $this->houseRepository->getHouse($houseId);
        return view('houses.edit', compact('house'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $houseId)
    {
        $data = $request->validate([
            'block' => 'required|string|max:8',
            'number' => 'required|string|max:2',
            'type' => 'required|string|max:8',
            'house_cost' => 'nullable',
            'project_id' => 'required|exists:projects,project_id',
        ]);

        $data['name'] = $data['block'] . ' - No. ' . $data['number'];

        $house = $this->houseRepository->updateHouse($houseId, $data);

        return redirect()->back()->with('success', 'Rumah berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($houseId)
    {
        $house = $this->houseRepository->deleteHouse($houseId);

        return redirect()->back()->with('success', 'Rumah berhasil dihapus.');
    }
}
