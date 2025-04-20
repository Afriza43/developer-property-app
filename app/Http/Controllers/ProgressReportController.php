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
        $data = $request->validate([
            'description'     => 'required|string|max:50',
            'progress_photo'  => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'house_id'        => 'required|exists:houses,house_id',
            'report_date'     => 'required|date',
        ]);

        $this->progressRepository->createProgres($data);

        return redirect()->route('progress.index', ['house_id' => $request->house_id])
            ->with('success', 'Laporan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProgressReport $progressRepository)
    {
        return view('progress.index', compact('progress'));
    }
}
