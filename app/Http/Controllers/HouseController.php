<?php

namespace App\Http\Controllers;

use App\Repositories\HouseRepository;
use Illuminate\Http\Request;

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
        $users = $this->houseRepository->getUser();
        $project_id = $request->query('project_id');
        return view('houses.create', compact('users', 'project_id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'block_number' => 'required|integer',
            'type' => 'required|integer',
            'total_cost' => 'nullable',
            'project_id' => 'required|exists:projects,project_id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'password' => 'required',
        ]);

        // if ($request->hasFile('image')) {
        //     $data['image'] = $request->file('image')->store('images/houses', 'public');
        // }

        $this->houseRepository->createHouse($data);

        return redirect()->route('houses.index', ['project_id' => $request->project_id])
            ->with('success', 'Rumah berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($houseId)
    {
        return view('expenses.index', compact('houseId'));
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
            'name' => 'required',
            'block_number' => 'required|integer',
            'type' => 'required|integer',
            'total_cost' => 'nullable',
            'project_id' => 'required|exists:projects,project_id',
            // 'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'password' => 'required',
        ]);

        $house = $this->houseRepository->updateHouse($houseId, $data);

        return redirect()->route('houses.index', ['project_id' => $house->project_id])
            ->with('success', 'Rumah berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($houseId)
    {
        $house = $this->houseRepository->deleteHouse($houseId);

        return redirect()->route('houses.index', ['project_id' => $house->project_id])
            ->with('success', 'Rumah berhasil dihapus.');
    }
}
