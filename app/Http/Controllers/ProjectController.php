<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Repositories\ProjectRepository;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    protected $projectRepository;
    /**
     * Display a listing of the resource.
     */
    public function __construct(ProjectRepository $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $location = $request->input('location');

        $projects = $this->projectRepository->searchAndFilter($search, $location);

        return view('projects.index', compact('projects', 'search', 'location'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = $request->validate([
            'project_name' => 'required',
            'location' => 'required',
            'year' => 'required|digits:4|integer',
            'total_cost' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|file',
        ]);

        $this->projectRepository->createProject($validator);

        return redirect()->route('projects.index')->with('success', 'Project created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($projectId)
    {
        $data  = $this->projectRepository->getHouseByProject($projectId);
        return view('houses.index', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($projectId)
    {
        $project = $this->projectRepository->getProject($projectId);
        return view('projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $projectId)
    {
        $validator = $request->validate([
            'project_name' => 'required',
            'location' => 'required',
            'year' => 'required|digits:4|integer',
            'total_cost' => 'nullable',
        ]);

        $this->projectRepository->updateProject($projectId, $validator);

        return redirect()->route('projects.index')->with('success', 'Project updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($projectId)
    {
        $this->projectRepository->deleteProject($projectId);

        return redirect()->route('projects.index')->with('success', 'Project deleted successfully.');
    }
}
