<?php

namespace App\Http\Controllers;

use App\Models\ProjectType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            'identifier' => 'nullable|string|max:15',
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
            'identifier' => 'nullable|string|max:15',
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

    public function copyRAB($type_id)
    {
        DB::beginTransaction();
        try {
            $originalProjectType = ProjectType::with([
                'job_types.sub_jobs.materials',
                'job_types.sub_jobs.equipments',
                'job_types.sub_jobs.employees',
                'job_types.sub_jobs.volume_items'
            ])->findOrFail($type_id);

            // Replicate Project Type
            $newProjectType = $originalProjectType->replicate();
            $newProjectType->name .= ' (Copy)';
            $newProjectType->save();

            foreach ($originalProjectType->job_types as $originalJobType) {
                // Replicate JobType
                $newJobType = $originalJobType->replicate();
                $newJobType->type_id = $newProjectType->type_id;
                $newJobType->save();

                foreach ($originalJobType->sub_jobs as $originalSubJob) {
                    // Replicate SubJob
                    $newSubJob = $originalSubJob->replicate();
                    $newSubJob->jobtype_id = $newJobType->jobtype_id;
                    $newSubJob->job_id = $originalSubJob->job_id;
                    $newSubJob->save();

                    // Replicate Pivot: Materials
                    foreach ($originalSubJob->materials as $material) {
                        $newSubJob->materials()->attach($material->material_id, [
                            'koefisien' => $material->pivot->koefisien,
                            'material_cost' => $material->pivot->material_cost,
                            'total_cost' => $material->pivot->total_cost,
                        ]);
                    }

                    // Replicate Pivot: Equipments
                    foreach ($originalSubJob->equipments as $equipment) {
                        $newSubJob->equipments()->attach($equipment->equipment_id, [
                            'koefisien' => $equipment->pivot->koefisien,
                            'equipment_cost' => $equipment->pivot->equipment_cost,
                            'total_cost' => $equipment->pivot->total_cost,
                        ]);
                    }

                    // Replicate Pivot: Employees
                    foreach ($originalSubJob->employees as $employee) {
                        $newSubJob->employees()->attach($employee->employee_id, [
                            'koefisien' => $employee->pivot->koefisien,
                            'wage' => $employee->pivot->wage,
                            'total_cost' => $employee->pivot->total_cost,
                        ]);
                    }

                    // Replicate Volume Items
                    foreach ($originalSubJob->volume_items as $volume) {
                        $newVolume = $volume->replicate();
                        $newVolume->sub_job_id = $newSubJob->sub_job_id;
                        $newVolume->save();
                    }
                }
            }

            DB::commit();
            return redirect()->back()->with('success', 'RAB berhasil dicopy!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyalin RAB: ' . $e->getMessage());
        }
    }

    public function updateLandPrice(Request $request, $id)
    {
        $request->validate([
            'land_price' => 'required|numeric|min:0',
        ]);

        $type = ProjectType::findOrFail($id);
        $type->land_price = $request->land_price;
        $type->save();

        return back()->with('success', 'Harga tanah berhasil diperbarui.');
    }
}
