<?php

namespace App\Http\Controllers;

use App\Models\House;
use Illuminate\Http\Request;
use App\Models\ExpenseReport;
use App\Repositories\ExpenseRepository;

class ExpenseReportController extends Controller
{
    protected $expenseRepository;

    public function __construct(ExpenseRepository $expenseRepository)
    {
        $this->expenseRepository = $expenseRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = $this->expenseRepository->getExpensesData($request->house_id);
        return view('expenses.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $house = $this->expenseRepository->getHouse($request->house_id);
        return view('expenses.create', compact('house'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $data = $request->validate([
            'description'     => 'required|string|max:50',
            'total_expense'   => 'required',
            'evidence'        => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'house_id'        => 'required|exists:houses,house_id',
            'purchase_date'   => 'required|date',
        ]);

        // if ($request->hasFile('image')) {
        //     $data['image'] = $request->file('image')->store('images/houses', 'public');
        // }

        $this->expenseRepository->createExpense($data);

        return redirect()->route('expenses.index', ['house_id' => $request->house_id])
            ->with('success', 'Laporan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ExpenseReport $expenseReport)
    {
        return view('expenses.index', compact('expenses'));
    }

    public function showExpenseList($house_id)
    {
        $data = $this->expenseRepository->getExpensesByHouseId($house_id);
        return view('expenses.expense-list', $data);
    }
}
