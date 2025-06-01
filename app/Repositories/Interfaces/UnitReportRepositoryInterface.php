<?php

namespace App\Repositories\Interfaces;

interface UnitReportRepositoryInterface
{
    public function getProgressReports($id);
    public function getExpenseReports($id);
    public function showProgressPhoto($progressCollection);
    public function sumExpense($id);
}
