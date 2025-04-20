<?php

namespace App\Http\Controllers;

use App\Models\JobCategory;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\RABRepositoryInterface;

class RABController extends Controller
{
    protected $rabRepository;

    public function __construct(RABRepositoryInterface $rabRepository)
    {
        $this->rabRepository = $rabRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = $this->rabRepository->getRAB($request->house_id);
        return view('rab.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $house = $this->rabRepository->getHouse($request->house_id);
        return view('rab.create', compact('house'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'category_name' => 'required|string|max:50',
            'category_cost' => 'required|numeric',
            'house_id' => 'required|exists:houses,house_id',
        ]);

        $this->rabRepository->createJobCategory($data);

        return redirect()->back()->with('success', 'RAB created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(JobCategory $jobCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobCategory $jobCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $categoryId)
    {
        $data = $request->validate([
            'category_name' => 'required|string|max:50',
            'category_cost' => 'required|numeric',
            'house_id' => 'required|exists:houses,house_id',
        ]);

        $this->rabRepository->updateJobCategory($categoryId, $data);
        return redirect()->back()->with('success', 'RAB updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($categoryId)
    {
        $this->rabRepository->deleteJobCategory($categoryId);
        return redirect()->back()->with('success', 'RAB deleted successfully.');
    }
}
