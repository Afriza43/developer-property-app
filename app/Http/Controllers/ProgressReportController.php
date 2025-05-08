<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProgressReport;
use App\Repositories\ProgresRepository;

class ProgressReportController extends Controller
{
    public $progressRepository;

    public function __construct(ProgresRepository $progressRepository)
    {
        $this->progressRepository = $progressRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = $this->progressRepository->getProgressData($request->house_id);
        return view('progress.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $house = $this->progressRepository->getHouse($request->house_id);
        return view('progress.create', compact('house'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data laporan progres
        $data = $request->validate([
            'description' => 'required|string|max:50',
            'house_id'    => 'required|exists:houses,house_id',
            'report_date' => 'required|date',
            'period'      => 'required|integer|min:1',
            'images'      => 'required|array|max:5', // maksimal 5 gambar
            'images.*'    => 'image|mimes:jpeg,png,jpg', // max 2MB per gambar
        ]);

        // Simpan laporan progres terlebih dahulu
        $progress = $this->progressRepository->createProgres([
            'description' => $data['description'],
            'house_id'    => $data['house_id'],
            'report_date' => $data['report_date'],
            'period'      => $data['period'],
        ]);

        // Simpan semua gambar progres
        foreach ($request->file('images') as $image) {
            $path = $image->store('progress-photos');

            $this->progressRepository->addProgressPhoto([
                'progress_reports_id' => $progress->progress_reports_id,
                'image' => $path,
            ]);
        }

        return redirect()->route('progress.index', ['house_id' => $data['house_id']])
            ->with('success', 'Laporan berhasil ditambahkan.');
    }


    /**
     * Display the specified resource.
     */
    public function show(ProgressReport $progressRepository)
    {
        return view('progress.index', compact('progress'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'description' => 'required|string|max:50',
            'period' => 'required|integer|min:1',
        ]);

        $progress = $this->progressRepository->getProgres($id);
        $progress->description = $request->description;
        $progress->period = $request->period;
        $progress->save();

        return redirect()->back()->with('success', 'Progress berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $progress = $this->progressRepository->getProgres($id);
        $progress->delete();

        return redirect()->back()->with('success', 'Progress berhasil dihapus.');
    }
}
