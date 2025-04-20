<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Interfaces\JobRepositoryInterface;

class JobController extends Controller
{
    public $jobRepository;
    public function __construct(JobRepositoryInterface $jobRepository)
    {
        $this->jobRepository = $jobRepository;
    }

    // public function create(Request $request)
    // {
    //     $category = $this->jobRepository->getCategoryId($request->category_id);
    //     return view('jobs.create', compact('category'));
    // }

    public function store(Request $request)
    {
        $data = $request->validate([
            'job_name'   => 'required|string|max:30',
            'satuan_volume'     => 'required',
            'total_cost'     => 'nullable',
            'total_volume'     => 'nullable',
            'category_id'     => 'required|exists:job_categories,category_id',
        ]);

        $this->jobRepository->createJob($data);

        return redirect()->back()->with('success', 'Job created successfully.');
    }

    public function edit($jobId)
    {
        $job = $this->jobRepository->getJobById($jobId);
        return view('jobs.edit', compact('job'));
    }

    public function update(Request $request, $jobId)
    {
        $data = $request->validate([
            'job_name'   => 'required|string|max:30',
            'satuan_volume'     => 'required',
            'total_cost'     => 'nullable',
            'total_volume'     => 'nullable',
            'category_id'     => 'required|exists:job_categories,category_id',
        ]);

        $this->jobRepository->updateJob($jobId, $data);

        return redirect()->back()->with('success', 'Job updated successfully.');
    }
    public function destroy($jobId)
    {
        $this->jobRepository->deleteJob($jobId);
        return redirect()->back()->with('success', 'Job deleted successfully.');
    }
}
