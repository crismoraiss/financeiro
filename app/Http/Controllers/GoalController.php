<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use App\Models\GoalTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GoalController extends Controller
{
    public function index()
    {
        $goals = Goal::with([
            'transactions' => function ($query) {
                $query->orderByDesc('transaction_date')
                    ->orderByDesc('id');
            }
        ])
        ->orderByDesc('created_at')
        ->get();

        return view('goals.index', compact('goals'));
    }

    public function create()
    {
        return view('goals.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'initial_amount' => 'required|numeric|min:0',
            'target_amount' => 'required|numeric|min:0.01',
            'deadline' => 'nullable|date',
            'description' => 'nullable|string',
        ]);

        Goal::create([
            'name' => $request->name,
            'initial_amount' => $request->initial_amount,
            'target_amount' => $request->target_amount,
            'deadline' => $request->deadline,
            'description' => $request->description,
            'status' => 'active',
        ]);

        return redirect()
            ->route('goals.index')
            ->with('success', 'Meta cadastrada com sucesso!');
    }

    public function deposit(Request $request, Goal $goal)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'transaction_date' => 'required|date',
            'observation' => 'nullable|string|max:500',
        ]);

        DB::transaction(function () use ($request, $goal) {

            GoalTransaction::create([
                'goal_id' => $goal->id,
                'type' => 'deposit',
                'amount' => $request->amount,
                'transaction_date' => $request->transaction_date,
                'observation' => $request->observation,
            ]);

            $goal->refresh();

            if ($goal->current_amount >= $goal->final_target) {
                $goal->update([
                    'status' => 'completed',
                ]);
            }
        });

        return redirect()
            ->route('goals.index')
            ->with('success', 'Dinheiro adicionado à reserva!');
    }

    public function withdraw(Request $request, Goal $goal)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'transaction_date' => 'required|date',
            'observation' => 'nullable|string|max:500',
        ]);

        if ($request->amount > $goal->current_amount) {
            return back()
                ->withErrors([
                    'amount' => 'Você não pode retirar um valor maior que o saldo atual da reserva.'
                ])
                ->withInput();
        }

        DB::transaction(function () use ($request, $goal) {

            GoalTransaction::create([
                'goal_id' => $goal->id,
                'type' => 'withdrawal',
                'amount' => $request->amount,
                'transaction_date' => $request->transaction_date,
                'observation' => $request->observation,
            ]);

            $goal->update([
                'status' => 'active',
            ]);
        });

        return redirect()
            ->route('goals.index')
            ->with('success', 'Retirada registrada com sucesso!');
    }

    public function destroy(Goal $goal)
    {
        $goal->delete();

        return redirect()
            ->route('goals.index')
            ->with('success', 'Meta excluída com sucesso!');
    }
}
