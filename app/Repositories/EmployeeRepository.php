<?php

namespace App\Repositories;

use App\Models\Employee;
use App\Repositories\Interfaces\EmployeeRepositoryInterface;

class EmployeeRepository implements EmployeeRepositoryInterface
{
    public function getEmployees()
    {
        return Employee::all();
    }

    public function getEmployeeById($id)
    {
        return Employee::find($id);
    }

    public function createEmployee(array $data)
    {
        return Employee::create($data);
    }

    public function updateEmployee($id, array $data)
    {
        $employee = $this->getEmployeeById($id);
        $employee->update($data);
        return $employee;
    }

    public function deleteEmployee($id)
    {
        $employee = $this->getEmployeeById($id);
        $employee->delete();
        return $employee;
    }
}
