<?php

namespace App\Http\Controllers;

use App\Models\SubJob;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\SubJobDetailRepositoryInterface;

class JobEmployeeController extends Controller
{
    protected $repo;

    public function __construct(SubJobDetailRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    // Halaman untuk memilih Employee yang akan ditambahkan
    public function select(Request $request, $subJobId)
    {
        $subJob = $this->repo->getJob($subJobId);

        $query = Employee::query();

        if ($request->filled('search')) {
            $query->where('position', 'LIKE', '%' . $request->search . '%');
        }

        $employees = $query->get();

        return view('unit-prices.job-employees', compact('subJob', 'employees'));
    }


    // Menyimpan banyak Employee terpilih ke pivot
    public function storeSelected(Request $request, $subJobId)
    {
        $request->validate([
            'employees' => 'required|array',
            'employees.*' => 'exists:employees,employee_id'
        ]);

        $subJob = $this->repo->getJob($subJobId);

        foreach ($request->employees as $employeeId) {
            $this->repo->addEmployee($subJob, $employeeId);
        }

        return redirect()->route('jobs.priceAnalysis', $subJobId)
            ->with('success', 'employee berhasil ditambahkan.');
    }

    public function updateSingle(Request $request, $subJobId, $employeeId)
    {
        $subJob = SubJob::findOrFail($subJobId);
        $employee = Employee::findOrFail($employeeId);

        $koefisien = floatval($request->input('koefisien'));
        $wage = $request->input('wage');
        $totalCost = $koefisien * $wage;

        $subJob->employees()->updateExistingPivot($employeeId, [
            'koefisien' => $koefisien,
            'total_cost' => $totalCost,
            'wage' => $wage,
        ]);

        return redirect()->back()->with('success', 'Data Employee berhasil diperbarui.');
    }

    public function destroy($subJobId, $employeeId)
    {
        $subJob = SubJob::findOrFail($subJobId);
        $subJob->employees()->detach($employeeId);

        return redirect()->back()->with('success', 'Data Employee berhasil dihapus.');
    }
}
