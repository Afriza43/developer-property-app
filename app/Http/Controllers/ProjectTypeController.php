<?php

namespace App\Http\Controllers;

use App\Models\ProjectType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Interfaces\ProjectTypeRepositoryInterface;

class ProjectTypeController extends Controller
{
    protected $projectTypeRepository;

    public function __construct(ProjectTypeRepositoryInterface $projectTypeRepository)
    {
        $this->projectTypeRepository = $projectTypeRepository;
    }

    public function index(Request $request)
    {
        $selectType = $request->input('selectType');

        $types = $this->projectTypeRepository->searchAndFilter($request->project_id, $selectType);
        $project = $this->projectTypeRepository->projectData($request->project_id);

        return view('project-types.index', [
            'types' => $types,
            'projectId' => $request->project_id,
            'selectType' => $selectType,
            'project' => $project,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:15',
            'type' => 'required|string|max:8',
            'image' => 'nullable|image|mimes:jpeg,png,jpg',
            'project_id' => 'required|exists:projects,project_id',
        ]);

        // Simpan gambar jika ada
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('project-types', 'public');
        }

        $this->projectTypeRepository->createProjectType($data);

        return redirect()->back()->with('success', 'Project type created successfully.');
    }

    public function update(Request $request, $typeId)
    {
        $data = $request->validate([
            'name' => 'required|string|max:15',
            'type' => 'required|string|max:8',
            'image' => 'nullable|image|mimes:jpeg,png,jpg',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('project-types', 'public');
        }

        $this->projectTypeRepository->updateProjectType($typeId, $data);

        return redirect()->back()->with('success', 'Project type updated successfully.');
    }


    public function destroy($typeId)
    {
        $this->projectTypeRepository->deleteProjectType($typeId);

        return redirect()->back()->with('success', 'Project type deleted successfully.');
    }
}
