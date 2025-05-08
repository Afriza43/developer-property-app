<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Repositories\ProjectRepository;
use Illuminate\Support\Facades\Storage;

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
        $countProject = $this->projectRepository->countProject();
        $countHouses = $this->projectRepository->countHouses();
        $sumCost = $this->projectRepository->sumCost();
        $countLocation = $this->projectRepository->countLocation();

        return view('projects.index', compact('projects', 'search', 'location', 'countProject', 'countHouses', 'sumCost', 'countLocation'));
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
            'image' => 'image|file|max:5000',
        ]);

        if ($request->file('image')) {
            $validator['image'] = $request->file('image')->store('project-images');
        }

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
            'image' => 'nullable|image|file|max:5000',
        ]);

        // Cek apakah ada file gambar yang diunggah
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            $project = $this->projectRepository->getProject($projectId); // Asumsi ada method ini di repository
            if ($project && $project->image) {
                Storage::delete($project->image); // Hapus file dari storage
            }

            // Simpan gambar yang baru diunggah
            $validator['image'] = $request->file('image')->store('project-images');
        } else {
            // Jika tidak ada gambar baru, hapus validasi 'image' dari array validator
            unset($validator['image']);
        }

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
