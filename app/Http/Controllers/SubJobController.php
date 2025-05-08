<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobCategory;
use Illuminate\Http\Request;

class SubJobController extends Controller
{
    public function selectJob(Request $request, $categoryId)
    {
        $jobCategory = JobCategory::with(['jobs', 'project_types'])->findOrFail($categoryId);

        $selectedJobs = $jobCategory->jobs;
        $selectedIds = $selectedJobs->pluck('job_id')->toArray();

        $query = Job::query()->whereNotIn('job_id', $selectedIds);

        if ($request->filled('search')) {
            $query->where('job_name', 'LIKE', '%' . $request->search . '%');
        }

        $availableJobs = $query->get();

        return view('rab.select-job', compact('jobCategory', 'availableJobs', 'selectedJobs'));
    }

    public function storeSelectedJob(Request $request, $categoryId)
    {
        $request->validate([
            'jobs' => 'required|array',
            'jobs.*' => 'exists:jobs,job_id'
        ]);

        $jobCategory = JobCategory::findOrFail($categoryId);

        foreach ($request->jobs as $jobId) {
            $jobCategory->jobs()->attach($jobId, ['job_cost' => 0, 'total_volume' => 0]);
        }

        return redirect()->route('jobs.selectJob', $categoryId)->with('success', 'Pekerjaan berhasil ditambahkan.');
    }

    public function destroySelectedJob($categoryId, $jobId)
    {
        $jobCategory = JobCategory::findOrFail($categoryId);
        $jobCategory->jobs()->detach($jobId);

        return redirect()->back()->with('success', 'Pekerjaan berhasil dihapus.');
    }
}
