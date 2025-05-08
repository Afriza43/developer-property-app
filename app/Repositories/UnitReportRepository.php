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
        $progressReports = ProgressReport::where('house_id', $id)->get();
        return $progressReports;
    }

    public function getExpenseReports($id)
    {
        $expenseReports = ExpenseReport::where('house_id', $id)->get();
        return $expenseReports;
    }

    public function showProgressPhoto($progressCollection)
    {
        $ids = $progressCollection->pluck('progress_reports_id');
        return ProgressPhoto::whereIn('progress_reports_id', $ids)->get();
    }
}
