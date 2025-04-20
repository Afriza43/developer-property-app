<?php

namespace App\Repositories\Interfaces;

interface EmployeeRepositoryInterface
{
    public function getEmployees();
    public function getEmployeeById($employeeId);
    public function createEmployee(array $data);
    public function updateEmployee($id, array $data);
    public function deleteEmployee($id);
}
