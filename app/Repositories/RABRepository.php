<?php

namespace App\Repositories;

use App\Models\JobType;
use App\Models\JobCategory;
use App\Models\ProjectType;
use App\Models\SubJob;
use Illuminate\Support\Facades\DB;
use App\Repositories\Interfaces\RABRepositoryInterface;

class RABRepository implements RABRepositoryInterface
{
    public function getType($typeId)
    {
        return ProjectType::with('project')->find($typeId);
    }

    public function getJobsByTypeId($typeId)
    {
        // Dapatkan job_categories yang memiliki job_types terkait dengan project_type ini
        $jobCategories = JobCategory::with([
            'job_types' => function ($query) use ($typeId) {
                // Filter job_types untuk project_type tertentu
                $query->where('type_id', $typeId);
            },
            'job_types.sub_jobs' => function ($query) {
                // Ambil sub_jobs yang terkait dengan job_types yang sudah difilter di atas
                $query->orderBy('sub_job_id');
            },
            'job_types.sub_jobs.job' => function ($query) {
                $query->select('job_id', 'job_name', 'satuan_volume');
            }
        ])
            ->whereHas('job_types', function ($query) use ($typeId) {
                // Pastikan hanya mengambil job_categories yang memiliki relasi dengan project_type ini
                $query->where('type_id', $typeId);
            })
            ->get();

        return $jobCategories;
    }

    public function getRAB($typeId)
    {
        $type = $this->getType($typeId);
        $jobCategories = $this->getJobsByTypeId($typeId);

        return compact('type', 'jobCategories');
    }

    public function getJobCategory($categoryId)
    {
        return JobCategory::findOrFail($categoryId);
    }

    public function createJobCategory(array $data)
    {
        $category = JobCategory::create([
            'category_name' => $data['category_name'],
        ]);

        // Tambahkan ke project type melalui pivot job_types
        DB::table('job_types')->insert([
            'type_id'     => $data['type_id'],
            'category_id' => $category->category_id,
            'rename'      => null,
            'created_at'  => now(),
            'updated_at'  => now()
        ]);

        return $category;
    }

    public function updateJobCategory($id, array $data)
    {
        $category = $this->getJobCategory($id);

        $category->update([
            'category_name' => $data['category_name'],
        ]);

        // Tidak mengubah pivot job_types karena rename dilakukan terpisah

        return $category;
    }

    public function deleteJobCategory($jobtype_id)
    {
        // Hapus job_type berdasarkan jobtype_id
        DB::table('job_types')->where('jobtype_id', $jobtype_id)->delete();

        return response()->json(['message' => 'Kategori berhasil dihapus.']);
    }

    public function updateBudgetPlan($typeId, $budgetPlan)
    {
        $projectType = ProjectType::findOrFail($typeId);
        $projectType->budget_plan = $budgetPlan;
        $projectType->save();

        return $projectType;
    }

    public function renameCategory($jobtype_id, $newName)
    {
        $jobType = JobType::findOrFail($jobtype_id);
        $jobType->rename = $newName;
        $jobType->save();
    }

    public function renameJob($sub_job_id, $newName)
    {
        $subJob = SubJob::findOrFail($sub_job_id);
        $subJob->rename = $newName;
        dd($subJob->rename);
        $subJob->save();
    }

    public function getNewCategoryName($jobtype_id)
    {
        return DB::table('job_types')
            ->where('jobtype_id', $jobtype_id)
            ->value('rename');
    }

    public function getNewJobName($sub_job_id)
    {
        return DB::table('sub_jobs')
            ->where('sub_job_id', $sub_job_id)
            ->value('rename');
    }


    public function deleteJob($id)
    {
        $job = SubJob::where('sub_job_id', $id)->first();
        $job->delete();

        return $job;
    }
}
