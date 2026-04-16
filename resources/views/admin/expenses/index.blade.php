@extends('admin.layouts.main')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Expenses & Revenue</h1>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-6 text-white">
            <p class="text-green-100 text-sm">Total Income</p>
            <p class="text-2xl font-bold">₨{{ number_format($totalIncome, 0) }}</p>
        </div>
        <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl p-6 text-white">
            <p class="text-red-100 text-sm">Total Expenses</p>
            <p class="text-2xl font-bold">₨{{ number_format($totalExpenses, 0) }}</p>
        </div>
        <div class="bg-gradient-to-br from-[#2d5a27] to-[#4a7c42] rounded-xl p-6 text-white">
            <p class="text-white/70 text-sm">Net Profit</p>
            <p class="text-2xl font-bold">₨{{ number_format($profit, 0) }}</p>
        </div>
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-6 text-white">
            <p class="text-blue-100 text-sm">Total Orders</p>
            <p class="text-2xl font-bold">{{ \App\Models\Order::count() }}</p>
        </div>
    </div>

    <!-- Chart -->
    @php
        $maxIncome = $monthlyIncome->max() ?: 1;
        $maxExpense = $monthlyExpenses->max() ?: 1;
        $maxValue = max($maxIncome, $maxExpense, 1);
    @endphp
    <div class="bg-white rounded-xl shadow-lg p-4 mb-8">
        <h3 class="font-bold text-gray-800 mb-4">Income vs Expenses (This Year)</h3>
        <div class="h-48 flex items-end justify-around gap-1 overflow-x-auto">
            @for($i = 1; $i <= 12; $i++)
                @php
                    $incomeHeight = $maxValue > 0 ? (($monthlyIncome[$i] ?? 0) / $maxValue) * 100 : 0;
                    $expenseHeight = $maxValue > 0 ? (($monthlyExpenses[$i] ?? 0) / $maxValue) * 100 : 0;
                @endphp
                <div class="flex flex-col items-center flex-1 min-w-[30px]">
                    <div class="w-full flex flex-col gap-0.5 h-36 justify-end">
                        <div class="bg-green-500 rounded-t w-full" style="height: {{ $incomeHeight }}%; min-height: 2px;"></div>
                        <div class="bg-red-500 rounded-t w-full" style="height: {{ $expenseHeight }}%; min-height: 2px;"></div>
                    </div>
                    <span class="text-xs text-gray-500 mt-1 whitespace-nowrap">{{ date('M', mktime(0, 0, 0, $i, 1)) }}</span>
                </div>
            @endfor
        </div>
        <div class="flex justify-center gap-6 mt-2 text-sm">
            <span class="flex items-center"><span class="w-3 h-3 bg-green-500 rounded mr-1"></span> Income</span>
            <span class="flex items-center"><span class="w-3 h-3 bg-red-500 rounded mr-1"></span> Expenses</span>
        </div>
    </div>

    <!-- Add Expense Form -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
        <h3 class="font-bold text-gray-800 mb-4">Add New Expense</h3>
        <form method="POST" action="{{ route('admin.expenses.store') }}" class="grid md:grid-cols-5 gap-4">
            @csrf
            <div>
                <label class="block text-gray-700 font-medium mb-2">Title</label>
                <input type="text" name="title" required class="w-full px-4 py-3 border border-gray-300 rounded-lg" placeholder="Expense title">
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-2">Amount</label>
                <input type="number" name="amount" step="0.01" required class="w-full px-4 py-3 border border-gray-300 rounded-lg" placeholder="0.00">
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-2">Category</label>
                <select name="category" required class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                    @foreach(\App\Models\Expense::categories() as $cat)
                        <option value="{{ $cat }}">{{ ucfirst($cat) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-2">Date</label>
                <input type="date" name="expense_date" required class="w-full px-4 py-3 border border-gray-300 rounded-lg" value="{{ date('Y-m-d') }}">
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full green-gradient text-white py-3 rounded-lg font-bold hover:opacity-90">
                    <i class="fas fa-plus mr-2"></i> Add
                </button>
            </div>
        </form>
    </div>

    <!-- Expenses List -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <table class="w-full data-table">
            <thead class="green-gradient text-white">
                <tr>
                    <th class="px-6 py-4 text-left">Title</th>
                    <th class="px-6 py-4 text-left">Category</th>
                    <th class="px-6 py-4 text-left">Amount</th>
                    <th class="px-6 py-4 text-left">Date</th>
                    <th class="px-6 py-4 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($expenses as $expense)
                    <tr>
                        <td class="px-6 py-4 font-medium text-gray-800">{{ $expense->title }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ ucfirst($expense->category) }}</td>
                        <td class="px-6 py-4 text-red-600 font-bold">₨{{ number_format($expense->amount, 2) }}</td>
                        <td class="px-6 py-4 text-gray-500">{{ $expense->expense_date->format('M d, Y') }}</td>
                        <td class="px-6 py-4">
                            <form action="{{ route('admin.expenses.destroy', $expense->id) }}" method="POST" onsubmit="return confirm('Delete?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-100 text-red-700 px-3 py-2 rounded-lg hover:bg-red-200">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                @if($expenses->isEmpty())
                <tr style="display:none;"><td></td><td></td><td></td><td></td><td></td></tr>
                @endif
            </tbody>
        </table>
        @if($expenses->isEmpty())
        <div class="text-center py-12 text-gray-500">No expenses found yet.</div>
        @endif
    </div>
</div>
@endsection