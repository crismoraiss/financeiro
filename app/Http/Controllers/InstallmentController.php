<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Expense;
use App\Models\Installment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InstallmentController extends Controller
{
    public function index()
    {
        $installments = Installment::orderByDesc('created_at')->get();

        return view('installments.index', compact('installments'));
    }

    public function create()
    {
        $categories = Category::where('type', 'expense')
            ->orderBy('name')
            ->get();

        return view('installments.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string|max:150',
            'card_name' => 'nullable|string|max:100',
            'installment_amount' => 'required|numeric|min:0.01',
            'total_installments' => 'required|integer|min:1',
            'paid_installments' => 'required|integer|min:0',
            'due_day' => 'required|integer|min:1|max:31',
            'first_due_date' => 'required|date',
            'observation' => 'nullable|string',
        ]);

        if ($request->paid_installments > $request->total_installments) {
            return back()
                ->withErrors([
                    'paid_installments' =>
                    'As parcelas pagas não podem ser maiores que o total de parcelas.'
                ])
                ->withInput();
        }

        DB::transaction(function () use ($request) {

            $installment = Installment::create([
                'category_id' => $request->category_id,
                'description' => $request->description,
                'card_name' => $request->card_name,
                'installment_amount' => $request->installment_amount,
                'total_installments' => $request->total_installments,
                'paid_installments' => $request->paid_installments,
                'due_day' => $request->due_day,
                'first_due_date' => $request->first_due_date,

                'status' =>
                $request->paid_installments >= $request->total_installments
                    ? 'finished'
                    : 'active',

                'observation' => $request->observation,
            ]);


            /*
        |--------------------------------------------------------------------------
        | GERA AS PARCELAS QUE AINDA NÃO FORAM PAGAS
        |--------------------------------------------------------------------------
        */

            $firstDueDate = Carbon::parse($request->first_due_date);

            for (
                $number = $request->paid_installments + 1;
                $number <= $request->total_installments;
                $number++
            ) {

                $month = $firstDueDate
                    ->copy()
                    ->startOfMonth()
                    ->addMonthsNoOverflow($number - 1);

                $day = min(
                    (int) $request->due_day,
                    $month->daysInMonth
                );

                $dueDate = $month->copy()->day($day);


                Expense::create([
                    'category_id' => $request->category_id,

                    'installment_id' => $installment->id,

                    'description' =>
                    $installment->description .
                        ' - Parcela ' .
                        $number .
                        '/' .
                        $installment->total_installments,

                    'amount' => $installment->installment_amount,

                    'expense_type' => 'fixed',

                    'due_date' => $dueDate,

                    'paid_at' => null,

                    'status' => 'pending',

                    'payment_method' => $installment->card_name
                        ? 'Cartão ' . $installment->card_name
                        : 'Cartão de crédito',

                    'is_recurring' => false,

                    'observation' =>
                    'Parcela gerada automaticamente pelo parcelamento.',
                ]);
            }
        });


        return redirect()
            ->route('installments.index')
            ->with('success', 'Parcelamento cadastrado e parcelas geradas com sucesso!');
    }
}
