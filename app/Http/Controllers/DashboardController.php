<?php

namespace App\Http\Controllers;

use App\Models\Expense; // model das despesas
use App\Models\Income; // model das receitas
use App\Models\Receivable; // model dos valores que tenho a receber
use App\Models\Goal; // model das metas
use Carbon\Carbon; // biblioteca para trabalhar com datas
use App\Models\GoalTransaction;

class DashboardController extends Controller
{

// método responsável por buscar e calcular todos os dados exibidos na página inicial
    public function index()
    {
        // controla qual mês e ano o dash vai exibir, caso nenhum seja selecionado vai utilizar o mês/ano atuais
        $month = request('month', now()->month);
        $year = request('year', now()->year);


        // soma todas as receitas recebidas no mês e ano selecionados
        $totalIncomes = Income::whereMonth('received_at', $month)
            ->whereYear('received_at', $year)
            ->sum('amount');


        // soma todas as despesas com vencimento no mês selecionado, independentemente de estarem pagas ou pendentes
        $totalExpenses = Expense::whereMonth('due_date', $month)
            ->whereYear('due_date', $year)
            ->sum('amount');


        // soma as despesas classificadas como fixas no mês selecionado
        $fixedExpenses = Expense::where('expense_type', 'fixed')
            ->whereMonth('due_date', $month)
            ->whereYear('due_date', $year)
            ->sum('amount');


        // soma as despesas classificadas como variáveis no mês selecionado
        $variableExpenses = Expense::where('expense_type', 'variable')
            ->whereMonth('due_date', $month)
            ->whereYear('due_date', $year)
            ->sum('amount');


        // busca até 5 despesas pendentes do mês selecionado, ordenadas pela data de vencimento -> para ficar exibindo na pag inicial
        $pendingExpenses = Expense::where('status', 'pending')
            ->whereMonth('due_date', $month)
            ->whereYear('due_date', $year)
            ->orderBy('due_date')
            ->take(5)
            ->get();


        // Busca os 5 pagamentos mais recentes do mês selecionado junto com a categoria -> para ficar exibindo na pag inicial
        $latestPayments = Expense::with('category')
            ->where('status', 'paid')
            ->whereMonth('paid_at', $month)
            ->whereYear('paid_at', $year)
            ->orderByDesc('paid_at')
            ->take(5)
            ->get();


        // soma todas as despesas que foram pagas durante o mês selecionado
        $paidExpenses = Expense::where('status', 'paid')
            ->whereMonth('paid_at', $month)
            ->whereYear('paid_at', $year)
            ->sum('amount');


        // soma o valor das despesas pendentes do mês selecionado
        $pendingExpensesTotal = Expense::where('status', 'pending')
            ->whereMonth('due_date', $month)
            ->whereYear('due_date', $year)
            ->sum('amount');


        // cria uma data correspondente ao primeiro dia do mês selecionado, ela será usada para calcular o saldo vindo dos meses anteriores.
        $selectedDate = Carbon::create($year, $month, 1);



/*
|--------------------------------------------------------------------------
| SALDO DOS MESES ANTERIORES
|--------------------------------------------------------------------------
*/

        // soma todas as receitas recebidas antes do mês selecionado
        $previousIncomes = Income::whereDate(
            'received_at',
            '<',
            $selectedDate->copy()->startOfMonth()
        )
            ->sum('amount');



        // soma todas as despesas pagas antes do mês selecionado.
        $previousPaidExpenses = Expense::where('status', 'paid')
            ->whereDate(
                'paid_at',
                '<',
                $selectedDate->copy()->startOfMonth()
            )
            ->sum('amount');








// soma todo o dinheiro guardado em metas antes do mês selecionado
$previousGoalDeposits = GoalTransaction::where('type', 'deposit')
    ->whereDate(
        'transaction_date',
        '<',
        $selectedDate->copy()->startOfMonth()
    )
    ->sum('amount');


// soma todo o dinheiro retirado das metas antes do mês selecionado
$previousGoalWithdrawals = GoalTransaction::where('type', 'withdrawal')
    ->whereDate(
        'transaction_date',
        '<',
        $selectedDate->copy()->startOfMonth()
    )
    ->sum('amount');







        // calcula o saldo acumulado até o mês anterior
$previousBalance =
    $previousIncomes
    - $previousPaidExpenses
    - $previousGoalDeposits
    + $previousGoalWithdrawals;

/*
|--------------------------------------------------------------------------
| SALDO DO MÊS SELECIONADO
|--------------------------------------------------------------------------
*/


    // soma o dinheiro guardado nas metas durante o mês selecionado
$monthGoalDeposits = GoalTransaction::where('type', 'deposit')
    ->whereMonth('transaction_date', $month)
    ->whereYear('transaction_date', $year)
    ->sum('amount');


// soma o dinheiro retirado das metas durante o mês selecionado
$monthGoalWithdrawals = GoalTransaction::where('type', 'withdrawal')
    ->whereMonth('transaction_date', $month)
    ->whereYear('transaction_date', $year)
    ->sum('amount');


// calcula quanto sobrou das movimentações do mês selecionado
$monthBalance =
    $totalIncomes
    - $paidExpenses
    - $monthGoalDeposits
    + $monthGoalWithdrawals;

/*
|--------------------------------------------------------------------------
| SALDO DISPONÍVEL
|--------------------------------------------------------------------------
*/

        // soma o saldo acumulado dos meses anteriores ao resultado financeiro do mês selecionado
        $balance = $previousBalance + $monthBalance;


        // soma todos os valores que ainda estão pendentes de recebimento
        $totalReceivables = Receivable::where('status', 'pending')
            ->sum('amount');


        //Busca até 5 valores ainda não recebidos, ordenados pela data prevista de recebimento
        $pendingReceivables = Receivable::where('status', 'pending')
            ->orderBy('due_date')
            ->take(5)
            ->get();


        $expensesByCategory = Expense::with('category')
            ->selectRaw('category_id, SUM(amount) as total')
            ->whereMonth('due_date', $month)
            ->whereYear('due_date', $year)
            ->groupBy('category_id')
            ->orderByDesc('total')
            ->get();


        $goal = Goal::where('status', 'active')
            ->orderBy('deadline')
            ->first();


        return view('dashboard.index', compact(
            'month',
            'year',
            'totalIncomes',
            'totalExpenses',
            'balance',
            'fixedExpenses',
            'variableExpenses',
            'pendingExpenses',
            'latestPayments',
            'paidExpenses',
            'pendingExpensesTotal',
            'totalReceivables',
            'pendingReceivables',
            'expensesByCategory',
            'goal',
        ));
    }
}
