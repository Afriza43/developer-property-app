<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Repositories\EmployeeRepository;

class EmployeeController extends Controller
{
    public $employeeRepository;

    public function __construct(EmployeeRepository $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = $this->employeeRepository->getEmployees();
        return view('employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('employees.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'position' => 'required|string|max:25',
            'unit'     => 'required',
            'wage'     => 'required|numeric|min:0',
        ]);

        $this->employeeRepository->createEmployee($data);

        return redirect()->back()->with('success', 'Employee created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        $employee = $this->employeeRepository->getEmployeeById($employee->id);
        return view('employees.index', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        $employee = $this->employeeRepository->getEmployeeById($employee->id);
        return view('employees.edit', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        $data = $request->validate([
            'position' => 'required|string|max:25',
            'unit'     => 'required',
            'wage'     => 'required|numeric|min:0',
        ]);

        $this->employeeRepository->updateEmployee($employee->employee_id, $data);

        return redirect()->back()->with('success', 'Employee updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $this->employeeRepository->deleteEmployee($employee->employee_id);
        return redirect()->back()->with('success', 'Employee deleted successfully.');
    }
}
