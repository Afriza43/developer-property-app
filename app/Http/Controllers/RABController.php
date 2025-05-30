<?php

namespace App\Http\Controllers;

use App\Models\SubJob;
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

    public function destroy($jobTypeId)
    {
        $this->rabRepository->deleteJobCategory($jobTypeId);
        return redirect()->back()->with('success', 'Job Category deleted successfully.');
    }

    public function deleteJob($subJobId)
    {
        $this->rabRepository->deleteJob($subJobId);
        return redirect()->back()->with('success', 'Job deleted successfully.');
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


    public function renameCategory(Request $request)
    {
        $request->validate([
            'jobtype_id' => 'required|exists:job_types,jobtype_id',
            'rename' => 'required|string|max:50',
        ]);

        $this->rabRepository->renameCategory(
            $request->jobtype_id,
            $request->rename
        );

        return redirect()->back()->with('success', 'Nama kategori berhasil diubah.');
    }

    public function renameJob(Request $request)
    {
        $request->validate([
            'sub_job_id' => 'required|exists:sub_jobs,sub_job_id',
            'rename' => 'required|string|max:50',
        ]);

        $this->rabRepository->renameJob(
            $request->sub_job_id,
            $request->rename
        );

        return redirect()->back()->with('success', 'Nama pekerjaan berhasil diubah.');
    }

    public function viewPDF($typeId)
    {
        $data = $this->rabRepository->getRAB($typeId);
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML(view('rab.pdf', $data));
        $mpdf->Output();
    }
}
