<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\SubJob;
use App\Models\JobCategory;
use App\Models\JobType;
use Illuminate\Http\Request;

class SubJobController extends Controller
{
    // Menampilkan pekerjaan yang tersedia untuk ditambahkan
    public function selectJob(Request $request, $jobtype_id)
    {
        $jobType = JobType::with(['job_category', 'project_type', 'sub_jobs.job'])->findOrFail($jobtype_id);

        $selectedJobs = $jobType->sub_jobs()->with('job')->get();
        $selectedIds = $selectedJobs->pluck('job_id')->toArray();

        $query = Job::query()->whereNotIn('job_id', $selectedIds);

        if ($request->filled('search')) {
            $query->where('job_name', 'LIKE', '%' . $request->search . '%');
        }

        $availableJobs = $query->get();

        return view('rab.select-job', compact('jobType', 'availableJobs', 'selectedJobs'));
    }

    // Menyimpan pekerjaan yang dipilih
    public function storeSelectedJob(Request $request, $jobtype_id)
    {
        $request->validate([
            'jobs' => 'required|array',
            'jobs.*' => 'exists:jobs,job_id'
        ]);

        $jobType = JobType::findOrFail($jobtype_id);

        foreach ($request->jobs as $jobId) {
            SubJob::firstOrCreate([
                'jobtype_id' => $jobtype_id,
                'job_id' => $jobId
            ], [
                'total_volume' => 0,
                'job_cost' => 0,
                'rename' => null
            ]);
        }

        return redirect()->route('jobs.selectJob', $jobtype_id)->with('success', 'Pekerjaan berhasil ditambahkan.');
    }

    public function createJobType(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:job_categories,category_id',
            'type_id' => 'required|exists:project_types,type_id'
        ]);

        // Buat atau ambil JobType untuk kombinasi category_id dan type_id
        $jobType = JobType::firstOrCreate([
            'category_id' => $validated['category_id'],
            'type_id' => $validated['type_id']
        ]);

        // Redirect ke halaman pemilihan job dengan JobType baru
        return redirect()->route('jobs.selectJob', [
            'jobtype_id' => $jobType->jobtype_id,
            'type_id' => $validated['type_id']
        ]);
    }

    // Menghapus pekerjaan dari sub_jobs
    public function destroySelectedJob($jobtype_id, $job_id)
    {
        // Dapatkan JobType
        $jobType = JobType::findOrFail($jobtype_id);

        // Cari dan hapus SubJob berdasarkan job_type_id dan job_id
        $subJob = SubJob::where('jobtype_id', $jobtype_id)
            ->where('job_id', $job_id)
            ->firstOrFail();

        $subJob->delete();

        return redirect()->route('jobs.selectJob', [
            'jobtype_id' => $jobtype_id,
            'type_id' => $jobType->project_type_id
        ])->with('success', 'Pekerjaan berhasil dihapus.');
    }

    public function addJob(Request $request)
    {
        $validated = $request->validate([
            'job_name' => 'required|string|max:30',
            'satuan_volume' => 'required|string|max:5',
        ]);

        Job::create($validated);

        return redirect()->back()->with('success', 'Job created successfully.');
    }

    public function updateJob(Request $request, $jobId)
    {
        $validated = $request->validate([
            'job_name' => 'required|string|max:30',
            'satuan_volume' => 'required|string|max:5',
        ]);

        Job::find($jobId)->update($validated);

        return redirect()->back()->with('success', 'Job updated successfully.');
    }

    public function deleteJob($jobId)
    {
        Job::find($jobId)->delete();
        return redirect()->back()->with('success', 'Job deleted successfully.');
    }
}
