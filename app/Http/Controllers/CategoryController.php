<?php

namespace App\Http\Controllers;

use App\Models\JobCategory;
use App\Models\ProjectType;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // public function selectJobCategory(Request $request, $typeId)
    // {
    //     $projectType = ProjectType::findOrFail($typeId);

    //     $query = JobCategory::query();
    //     if ($request->filled('search')) {
    //         $query->where('category_name', 'LIKE', '%' . $request->search . '%');
    //     }

    //     $jobCategories = $query->get();

    //     return view('rab.select-category', compact('projectType', 'jobCategories'));
    // }

    public function selectJobCategory(Request $request, $typeId)
    {
        $projectType = ProjectType::with('job_categories')->findOrFail($typeId);

        $selectedCategories = $projectType->job_categories;
        $selectedIds = $selectedCategories->pluck('category_id')->toArray();

        $query = JobCategory::query()->whereNotIn('category_id', $selectedIds);

        if ($request->filled('search')) {
            $query->where('category_name', 'LIKE', '%' . $request->search . '%');
        }

        $availableCategories = $query->get();

        return view('rab.select-category', compact('projectType', 'availableCategories', 'selectedCategories'));
    }



    // Menyimpan kategori pekerjaan ke pivot rab_type
    public function storeSelectedJobCategory(Request $request, $typeId)
    {
        $request->validate([
            'categories' => 'required|array',
            'categories.*' => 'exists:job_categories,category_id'
        ]);

        $projectType = ProjectType::findOrFail($typeId);

        foreach ($request->categories as $categoryId) {
            $projectType->job_categories()->attach($categoryId, ['budget_plan' => 0]);
        }

        return redirect()->route('categories.selectJobCategory', $typeId)->with('success', 'Kategori pekerjaan berhasil ditambahkan.');
    }

    // CategoryController.php

    public function destroySelectedJobCategory($typeId, $categoryId)
    {
        $projectType = ProjectType::findOrFail($typeId);
        $projectType->job_categories()->detach($categoryId);

        return redirect()->back()->with('success', 'Kategori pekerjaan berhasil dihapus.');
    }
}
