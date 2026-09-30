<?php

namespace App\Http\Controllers;

use App\Models\Receivable;
use Illuminate\Http\Request;

class ReceivableController extends Controller
{
    public function index()
    {
        $receivables = Receivable::orderBy('due_date')
            ->get();

        return view('receivables.index', compact('receivables'));
    }

    public function create()
    {
        return view('receivables.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'person_name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'due_date' => 'nullable|date',
            'status' => 'required|in:pending,received',
            'received_at' => 'nullable|date',
            'observation' => 'nullable|string',
        ]);

        Receivable::create($validated);

        return redirect()
            ->route('receivables.index')
            ->with('success', 'Valor a receber cadastrado com sucesso!');
    }

    public function show(Receivable $receivable)
    {
        //
    }

    public function edit(Receivable $receivable)
    {
        //
    }

    public function update(Request $request, Receivable $receivable)
    {
        $receivable->update([
            'status' => 'received',
            'received_at' => now(),
        ]);

        return redirect()
            ->route('receivables.index')
            ->with('success', 'Valor marcado como recebido!');
    }

    public function destroy(Receivable $receivable)
    {
        //
    }
}
