<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UnitReportRepository;

class UnitReportController extends Controller
{
    public $reportRepository;

    public function __construct(UnitReportRepository $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }

    public function index(Request $request)
    {
        $progressReports = $this->reportRepository->getProgressReports($request->house_id);
        $expenseReports = $this->reportRepository->getExpenseReports($request->house_id);
        $photos = $this->reportRepository->showProgressPhoto($progressReports);

        return view('unit-report.index', compact('progressReports', 'expenseReports', 'photos'));
    }
}
