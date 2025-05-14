<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Interfaces\RABRepositoryInterface;

class RABController extends Controller
{
    protected $rabRepository;

    public function __construct(RABRepositoryInterface $rabRepository)
    {
        $this->rabRepository = $rabRepository;
    }

    public function index(Request $request)
    {
        $data = $this->rabRepository->getRAB($request->type_id);
        return view('rab.index', $data);
    }

    public function create(Request $request)
    {
        $type = $this->rabRepository->getType($request->type_id);
        return view('rab.create', compact('type'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_name' => 'required|string|max:50',
            'category_cost' => 'required|numeric',
            'type_id' => 'required|exists:project_types,type_id',
        ]);

        $this->rabRepository->createJobCategory($data);

        return redirect()->back()->with('success', 'RAB created successfully.');
    }

    public function update(Request $request, $categoryId)
    {
        $data = $request->validate([
            'category_name' => 'required|string|max:50',
            'category_cost' => 'required|numeric',
            'type_id' => 'required|exists:project_types,type_id',
            'budget_plan' => 'nullable|numeric'
        ]);

        $this->rabRepository->updateJobCategory($categoryId, $data);
        return redirect()->back()->with('success', 'RAB updated successfully.');
    }

    public function destroy($categoryId)
    {
        $this->rabRepository->deleteJobCategory($categoryId);
        return redirect()->back()->with('success', 'RAB deleted successfully.');
    }

    public function updateBudgetPlan(Request $request, $typeId)
    {
        $projectType = $this->rabRepository->getType($typeId);

        $request->validate([
            'budget_plan' => 'required|numeric|min:0'
        ]);

        $this->rabRepository->updateBudgetPlan($typeId, $request->budget_plan);

        return redirect()->route('project-types.index', ['project_id' => $projectType->project_id])->with('success', 'Budget plan berhasil diperbarui.');
    }


    public function updatePivotCategoryName(Request $request)
    {
        $request->validate([
            'type_id' => 'required|exists:project_types,type_id',
            'category_id' => 'required|exists:job_categories,category_id',
            'rename' => 'required|string|max:50',
        ]);

        $this->rabRepository->updatePivotCategoryName(
            $request->type_id,
            $request->category_id,
            $request->rename
        );

        return redirect()->back()->with('success', 'Nama kategori berhasil diubah.');
    }
}
