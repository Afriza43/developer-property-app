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
        $totalExpense = $this->reportRepository->sumExpense($request->house_id);

        return view('unit-reports.index', compact('progressReports', 'expenseReports', 'photos', 'totalExpense'));
    }

    public function exportPDF(Request $request)
    {
        $type = $request->get('type'); // 'expenses' atau 'progress'
        $houseId = $request->house_id;

        if ($type === 'expenses') {
            return $this->exportExpenseReport($houseId);
        } elseif ($type === 'progress') {
            return $this->exportProgressReport($houseId);
        }

        return redirect()->back()->with('error', 'Tipe laporan tidak valid');
    }

    private function exportExpenseReport($houseId)
    {
        $expenseReports = $this->reportRepository->getExpenseReports($houseId);

        // Hitung total pengeluaran
        $totalExpense = $this->reportRepository->sumExpense($houseId);

        $html = view('unit-reports.print-expenses', compact('expenseReports', 'totalExpense', 'houseId'))->render();

        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'orientation' => 'P',
            'margin_left' => 15,
            'margin_right' => 15,
            'margin_top' => 20,
            'margin_bottom' => 20,
        ]);

        $mpdf->WriteHTML($html);

        $filename = 'Laporan-Pengeluaran-Unit-' . $houseId . '-' . date('Y-m-d') . '.pdf';

        return $mpdf->Output();
    }

    private function exportProgressReport($houseId)
    {
        $progressReports = $this->reportRepository->getProgressReports($houseId);
        $photos = $this->reportRepository->showProgressPhoto($progressReports);

        // Group photos by progress_reports_id
        $groupedPhotos = $photos->groupBy('progress_reports_id');

        $html = view('unit-reports.print-progress', compact('progressReports', 'groupedPhotos', 'houseId'))->render();

        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'orientation' => 'P',
            'margin_left' => 15,
            'margin_right' => 15,
            'margin_top' => 20,
            'margin_bottom' => 20,
        ]);

        $mpdf->WriteHTML($html);

        $filename = 'Laporan-Progress-Unit-' . $houseId . '-' . date('Y-m-d') . '.pdf';

        return $mpdf->Output(); // 'D' untuk download
    }
}
