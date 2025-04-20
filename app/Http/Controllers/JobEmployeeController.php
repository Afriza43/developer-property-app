<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Repositories\JobDetailRepository;

class JobEmployeeController extends Controller
{
    protected $repo;

    public function __construct(JobDetailRepository $repo)
    {
        $this->repo = $repo;
    }

    // Halaman untuk memilih Employee yang akan ditambahkan
    public function select(Request $request, $job_id)
    {
        $job = $this->repo->getJob($job_id);

        $query = Employee::query();

        if ($request->filled('search')) {
            $query->where('position', 'LIKE', '%' . $request->search . '%');
        }

        $employees = $query->get();

        return view('unit-prices.job-employees', compact('job', 'employees'));
    }


    // Menyimpan banyak Employee terpilih ke pivot
    public function storeSelected(Request $request, $job_id)
    {
        $request->validate([
            'employees' => 'required|array',
            'employees.*' => 'exists:employees,employee_id'
        ]);

        $job = $this->repo->getJob($job_id);

        foreach ($request->employees as $employeeId) {
            $this->repo->addEmployee($job, $employeeId);
        }

        return redirect()->route('jobs.priceAnalysis', $job_id)
            ->with('success', 'employee berhasil ditambahkan.');
    }

    public function updateSingle(Request $request, $jobId, $employeeId)
    {
        $job = Job::findOrFail($jobId);
        $employee = Employee::findOrFail($employeeId);

        $koefisien = floatval($request->input('koefisien'));
        $totalCost = $koefisien * $employee->wage;

        $job->employees()->updateExistingPivot($employeeId, [
            'koefisien' => $koefisien,
            'total_cost' => $totalCost,
        ]);

        return redirect()->back()->with('success', 'Data Employee berhasil diperbarui.');
    }

    public function destroy($jobId, $employeeId)
    {
        $job = Job::findOrFail($jobId);
        $job->employees()->detach($employeeId);

        return redirect()->back()->with('success', 'Data Employee berhasil dihapus.');
    }
}
