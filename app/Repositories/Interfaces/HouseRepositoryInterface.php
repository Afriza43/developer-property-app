<?php

namespace App\Repositories\Interfaces;

interface HouseRepositoryInterface
{
    public function getHouseById($id);
    public function getHouse($id);
    public function countHouses($id);
    public function countBlok($id);
    public function countType($id);
    public function getHousesData($id);
    public function createHouse(array $data);
    public function updateHouse($id, array $data);
    public function deleteHouse($id);
    public function getProgressReports($id);
    public function getExpenseReports($id);
    public function sumExpense($id);
    public function showProgressPhoto($progressReports);
}
