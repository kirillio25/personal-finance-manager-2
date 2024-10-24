<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->input('month');
        $query = Transaction::with('category');

        if ($month) {
            $date = Carbon::parse($month);
            $query->whereMonth('transaction_date', $date->month)
                  ->whereYear('transaction_date', $date->year);
        }

        $transactions = $query->get();

        $income = $transactions->where('category.id', '1')->sum('amount');
        $expenses = $transactions->where('category.id', '2')->sum('amount');

        return Inertia::render('Transactions', [
            'transactions' => $transactions,
            'income' => $income,
            'expenses' => $expenses,
            'categories' => TransactionCategory::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:transaction_categories,id',
            'amount' => 'required|numeric',
            'transaction_date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        Transaction::create($request->all());

        return redirect()->back();
    }

    public function update(Request $request, Transaction $transaction)
    {
        $request->validate([
            'category_id' => 'required|exists:transaction_categories,id',
            'amount' => 'required|numeric',
            'transaction_date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        $transaction->update($request->all());

        return redirect()->back();
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();

        return redirect()->back();
    }
}

