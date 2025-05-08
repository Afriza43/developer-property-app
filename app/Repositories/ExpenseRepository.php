<?php

namespace App\Repositories;

use App\Models\House;
use App\Models\ExpenseReport;
use App\Repositories\Interfaces\ExpenseRepositoryInterface;

class ExpenseRepository implements ExpenseRepositoryInterface
{

    public function getExpense($id)
    {
        return ExpenseReport::findOrFail($id);
    }

    public function getHouse($id)
    {
        return House::find($id);
    }

    public function getExpensesByHouseId($id)
    {
        return ExpenseReport::with('house')->where('house_id', $id)->get();
    }

    public function getExpensesData($id)
    {
        $expenses = $this->getExpensesByHouseId($id);
        $house = $this->getHouse($id);
        $totalExpenses = $this->sumExpense();

        return compact('expenses', 'house', 'totalExpenses');
    }

    public function createExpense(array $data)
    {
        return ExpenseReport::create($data);
    }

    public function sumExpense()
    {
        return ExpenseReport::sum('total_expense');
    }
}
