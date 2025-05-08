<?php

namespace App\Repositories\Interfaces;

interface ExpenseRepositoryInterface
{
    public function getExpensesByHouseId($houseId);
    public function getExpense($id);
    public function sumExpense();
    public function getExpensesData($id);
    public function getHouse($houseId);
    public function createExpense(array $data);
}
