<?php

namespace App\Repositories;

use App\Models\ExpenseReport;
use App\Models\ProgressReport;
use App\Repositories\Interfaces\UnitReportRepositoryInterface;
use App\Models\ProgressPhoto;

class UnitReportRepository implements UnitReportRepositoryInterface
{
    public function getProgressReports($id)
    {
        $progressReports = ProgressReport::with(['progress_photos', 'house.project'])->where('house_id', $id)->orderBy('period', 'asc')->get();
        return $progressReports;
    }

    public function getExpenseReports($id)
    {
        $expenseReports = ExpenseReport::with('house.project')->where('house_id', $id)->orderBy('purchase_date', 'asc')->get();
        return $expenseReports;
    }

    public function showProgressPhoto($progressCollection)
    {
        $ids = $progressCollection->pluck('progress_reports_id');
        return ProgressPhoto::whereIn('progress_reports_id', $ids)->get();
    }

    public function sumExpense($id)
    {
        $totalExpense = ExpenseReport::where('house_id', $id)->sum('total_expense');
        return $totalExpense;
    }
}
