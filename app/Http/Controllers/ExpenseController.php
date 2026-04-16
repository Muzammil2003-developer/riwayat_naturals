<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ExpenseController extends Controller
{
    public function index(): View
    {
        $expenses = Expense::latest()->get();
        $totalExpenses = Expense::sum('amount');
        
        $totalIncome = Order::where('status', '!=', 'cancelled')->sum('total_price');
        $profit = $totalIncome - $totalExpenses;
        
        // Monthly data for chart
        $monthlyExpenses = Expense::selectRaw('MONTH(expense_date) as month, SUM(amount) as total')
            ->whereYear('expense_date', now()->year)
            ->groupBy('month')
            ->pluck('total', 'month');
            
        $monthlyIncome = Order::selectRaw('MONTH(created_at) as month, SUM(total_price) as total')
            ->whereYear('created_at', now()->year)
            ->where('status', '!=', 'cancelled')
            ->groupBy('month')
            ->pluck('total', 'month');
        
        return view('admin.expenses.index', compact('expenses', 'totalExpenses', 'totalIncome', 'profit', 'monthlyExpenses', 'monthlyIncome'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'category' => 'required|string',
            'expense_date' => 'required|date',
        ]);

        Expense::create($validated);

        return back()->with('success', 'Expense added successfully!');
    }

    public function destroy(Expense $expense): RedirectResponse
    {
        $expense->delete();
        return back()->with('success', 'Expense deleted!');
    }
}