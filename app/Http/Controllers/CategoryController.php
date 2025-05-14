<?php

namespace App\Http\Controllers;

use App\Models\SubJob;
use App\Models\JobCategory;
use App\Models\JobType;
use App\Models\ProjectType;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function selectJobCategory(Request $request, $typeId)
    {
        $projectType = ProjectType::findOrFail($typeId);

        // Ambil semua yang sudah dipilih dari pivot
        $selectedCategories = JobType::with('job_category')
            ->where('type_id', $typeId)->get();

        $selectedIds = $selectedCategories->pluck('category_id')->toArray();

        // Ambil yang belum dipilih
        $availableCategories = JobCategory::whereNotIn('category_id', $selectedIds)->when(
            $request->filled('search'),
            fn($q) => $q->where('category_name', 'like', '%' . $request->search . '%')
        )->get();

        return view('rab.select-category', compact('projectType', 'availableCategories', 'selectedCategories'));
    }


    // Menyimpan kategori pekerjaan ke pivot rab_type
    public function storeSelectedJobCategory(Request $request, $typeId)
    {
        $request->validate([
            'categories' => 'required|array',
            'categories.*' => 'exists:job_categories,category_id'
        ]);

        foreach ($request->categories as $categoryId) {
            JobType::firstOrCreate([
                'type_id' => $typeId,
                'category_id' => $categoryId,
            ], ['rename' => null]);
        }

        return redirect()->route('categories.selectJobCategory', $typeId)->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function destroySelectedJobCategory($typeId, $categoryId)
    {
        JobType::where('type_id', $typeId)
            ->where('category_id', $categoryId)
            ->delete();

        return redirect()->back()->with('success', 'Kategori berhasil dihapus.');
    }

    public function addJobCategory(Request $request)
    {
        $validated = $request->validate([
            'category_name' => 'required|string|max:30',
        ]);

        JobCategory::create($validated);

        return redirect()->back()->with('success', 'Job Category created successfully.');
    }

    public function updateJobCategory(Request $request, $categoryId)
    {
        $validated = $request->validate([
            'category_name' => 'required|string|max:30',
        ]);

        JobCategory::find($categoryId)->update($validated);

        return redirect()->back()->with('success', 'Job Category updated successfully.');
    }

    public function deleteJobCategory($categoryId)
    {
        dd($categoryId);
        JobCategory::find($categoryId)->delete();
        return redirect()->back()->with('success', 'Job Category deleted successfully.');
    }
}
