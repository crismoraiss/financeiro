<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Income;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    public function index()
    {
        $incomes = Income::with('category')
            ->orderByDesc('received_at')
            ->get();

        return view('incomes.index', compact('incomes'));
    }

    public function create()
    {
        $categories = Category::where('type', 'income')
            ->orderBy('name')
            ->get();

        return view('incomes.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string|max:150',
            'amount' => 'required|numeric|min:0.01',
            'received_at' => 'required|date',
            'observation' => 'nullable|string',
        ]);

        Income::create([
            'category_id' => $request->category_id,
            'description' => $request->description,
            'amount' => $request->amount,
            'received_at' => $request->received_at,
            'observation' => $request->observation,
        ]);

        return redirect()
            ->route('incomes.index')
            ->with('success', 'Receita cadastrada com sucesso!');
    }

    public function edit(Income $income)
    {
        $categories = Category::where('type', 'income')
            ->orderBy('name')
            ->get();

        return view('incomes.edit', compact('income', 'categories'));
    }

    public function update(Request $request, Income $income)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string|max:150',
            'amount' => 'required|numeric|min:0.01',
            'received_at' => 'required|date',
            'observation' => 'nullable|string',
        ]);

        $income->update([
            'category_id' => $request->category_id,
            'description' => $request->description,
            'amount' => $request->amount,
            'received_at' => $request->received_at,
            'observation' => $request->observation,
        ]);

        return redirect()
            ->route('incomes.index')
            ->with('success', 'Receita atualizada com sucesso!');
    }

    public function destroy(Income $income)
    {
        $income->delete();

        return redirect()
            ->route('incomes.index')
            ->with('success', 'Receita excluída com sucesso!');
    }
}
