<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Expense;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::with('category')
            ->orderBy('due_date')
            ->get();

        return view('expenses.index', compact('expenses'));
    }

    public function create()
    {
        $categories = Category::where('type', 'expense')
            ->orderBy('name')
            ->get();

        return view('expenses.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string|max:150',
            'amount' => 'required|numeric|min:0.01',
            'expense_type' => 'required|in:fixed,variable',
            'due_date' => 'required|date',
            'paid_at' => 'nullable|date',
            'status' => 'required|in:pending,paid',
            'payment_method' => 'nullable|string|max:100',
            'observation' => 'nullable|string',
        ]);

        Expense::create([
            'category_id' => $request->category_id,
            'description' => $request->description,
            'amount' => $request->amount,
            'expense_type' => $request->expense_type,
            'due_date' => $request->due_date,
            'paid_at' => $request->paid_at,
            'status' => $request->status,
            'payment_method' => $request->payment_method,
            'is_recurring' => $request->boolean('is_recurring'),
            'observation' => $request->observation,
        ]);

        return redirect()
            ->route('expenses.index')
            ->with('success', 'Despesa cadastrada com sucesso!');
    }

    public function edit(Expense $expense)
    {
        $categories = Category::where('type', 'expense')
            ->orderBy('name')
            ->get();

        return view('expenses.edit', compact('expense', 'categories'));
    }

    public function update(Request $request, Expense $expense)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string|max:150',
            'amount' => 'required|numeric|min:0.01',
            'expense_type' => 'required|in:fixed,variable',
            'due_date' => 'required|date',
            'paid_at' => 'nullable|date',
            'status' => 'required|in:pending,paid',
            'payment_method' => 'nullable|string|max:100',
            'observation' => 'nullable|string',
        ]);

        $expense->update([
            'category_id' => $request->category_id,
            'description' => $request->description,
            'amount' => $request->amount,
            'expense_type' => $request->expense_type,
            'due_date' => $request->due_date,
            'paid_at' => $request->paid_at,
            'status' => $request->status,
            'payment_method' => $request->payment_method,
            'is_recurring' => $request->boolean('is_recurring'),
            'observation' => $request->observation,
        ]);

        return redirect()
            ->route('expenses.index')
            ->with('success', 'Despesa atualizada com sucesso!');
    }


    public function markAsPaid(Expense $expense)
    {
        // Evita contar a mesma parcela duas vezes
        if ($expense->status === 'paid') {
            return redirect()
                ->back()
                ->with('success', 'Essa despesa já está paga!');
        }

        $expense->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        // Se a despesa pertence a um parcelamento
        if ($expense->installment) {

            $installment = $expense->installment;

            $newPaidInstallments = min(
                $installment->paid_installments + 1,
                $installment->total_installments
            );

            $installment->update([
                'paid_installments' => $newPaidInstallments,

                'status' => $newPaidInstallments >= $installment->total_installments
                    ? 'finished'
                    : 'active',
            ]);
        }


        if ($expense->is_recurring) {

    $nextDueDate = Carbon::parse($expense->due_date)
        ->addMonthNoOverflow();

    $alreadyExists = Expense::where('description', $expense->description)
        ->whereDate('due_date', $nextDueDate)
        ->where('is_recurring', true)
        ->exists();

    if (!$alreadyExists) {

        Expense::create([
            'category_id' => $expense->category_id,
            'installment_id' => null,
            'description' => $expense->description,
            'amount' => $expense->amount,
            'expense_type' => $expense->expense_type,
            'due_date' => $nextDueDate,
            'paid_at' => null,
            'status' => 'pending',
            'payment_method' => $expense->payment_method,
            'is_recurring' => true,
            'observation' => $expense->observation,
        ]);
    }
}

        return redirect()
            ->back()
            ->with('success', 'Despesa marcada como paga!');
    }


    public function markAsPending(Expense $expense)
    {
        // Só desfaz se realmente estiver paga
        if ($expense->status !== 'paid') {
            return redirect()
                ->back()
                ->with('success', 'Essa despesa já está pendente!');
        }

        $expense->update([
            'status' => 'pending',
            'paid_at' => null,
        ]);

        // Se pertence a um parcelamento, volta uma parcela
        if ($expense->installment) {

            $installment = $expense->installment;

            $newPaidInstallments = max(
                $installment->paid_installments - 1,
                0
            );

            $installment->update([
                'paid_installments' => $newPaidInstallments,
                'status' => 'active',
            ]);
        }

        return redirect()
            ->back()
            ->with('success', 'Pagamento desfeito com sucesso!');
    }




    public function destroy(Expense $expense)
    {
        $expense->delete();

        return redirect()
            ->route('expenses.index')
            ->with('success', 'Despesa excluída com sucesso!');
    }
}
