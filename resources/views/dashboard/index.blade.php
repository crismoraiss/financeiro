@extends('layout.layout')

@section('title', 'Dashboard')

@section('content')

    <section class="dashboard">

        <!-- HEADER -->
        <header class="dashboard-header">

            <div>
                <h1>Olá, Crislayne! 👋</h1>
                <p>
                    Resumo financeiro de
                    {{ ucfirst(\Carbon\Carbon::create()->month($month)->locale('pt_BR')->translatedFormat('F')) }}
                    de {{ $year }}
                </p>
            </div>

            <div class="header-actions">

                <form method="GET" action="{{ route('dashboard') }}">

                    <select name="month" class="month-select" onchange="this.form.submit()">

                        @foreach (range(1, 12) as $m)
                            <option value="{{ $m }}" {{ (int) $month === $m ? 'selected' : '' }}>
                                {{ ucfirst(\Carbon\Carbon::create()->month($m)->locale('pt_BR')->translatedFormat('F')) }}
                            </option>
                        @endforeach

                    </select>

                    <input type="hidden" name="year" value="{{ $year }}">

                </form>


            </div>

        </header>


        <!-- CARDS -->
        <section class="summary-grid">

            <div class="summary-card">

                <div class="summary-icon income">
                    <i class="fa-solid fa-arrow-trend-up"></i>
                </div>

                <div>
                    <span>Receitas</span>
                    <h2 class="text-green">
                        R$ {{ number_format($totalIncomes, 2, ',', '.') }}
                    </h2>
                    <small>Total do mês</small>
                </div>

            </div>


            <div class="summary-card">

                <div class="summary-icon expense">
                    <i class="fa-solid fa-arrow-trend-down"></i>
                </div>

                <div>
                    <span>Despesas</span>

                    <h2 class="text-red">
                        R$ {{ number_format($pendingExpensesTotal, 2, ',', '.') }}
                    </h2>

                    <small>
                        A pagar no mês
                        •
                        Pago: R$ {{ number_format($paidExpenses, 2, ',', '.') }}
                    </small>
                </div>

            </div>


            <div class="summary-card">

                <div class="summary-icon balance">
                    <i class="fa-solid fa-wallet"></i>
                </div>

                <div>
                    <span>Saldo disponível</span>
                    <h2 class="{{ $balance >= 0 ? 'text-blue' : 'text-red' }}">
                        R$ {{ number_format($balance, 2, ',', '.') }}
                    </h2>
                    <small>Receitas - Despesas</small>
                </div>

            </div>


            <div class="summary-card">

                <div class="summary-icon receivable">
                    <i class="fa-solid fa-users"></i>
                </div>

                <div>
                    <span>A receber</span>
                    <h2 class="text-orange">
                        R$ {{ number_format($totalReceivables, 2, ',', '.') }}
                    </h2>
                    <small>Total pendente</small>
                </div>

            </div>

        </section>


        <!-- CONTEÚDO CENTRAL -->
        <!-- CONTEÚDO CENTRAL -->
        <section class="dashboard-grid">

            <!-- PRÓXIMAS CONTAS -->
            <div class="dashboard-card">

                <div class="card-title">
                    <h3>
                        <i class="fa-regular fa-calendar"></i>
                        Próximas contas
                    </h3>
                </div>

                @forelse($pendingExpenses as $expense)
                    <div class="bill-item">

                        <div class="bill-info">

                            <div class="bill-icon education">
                                <i class="fa-solid fa-file-invoice-dollar"></i>
                            </div>

                            <div>
                                <strong>
                                    {{ $expense->description }}
                                </strong>

                                <small>
                                    Vence em {{ $expense->due_date->format('d/m/Y') }}
                                </small>
                            </div>

                        </div>

                        <div class="bill-value">

                            <strong>
                                R$ {{ number_format($expense->amount, 2, ',', '.') }}
                            </strong>

                            <span class="status pending">
                                Pendente
                            </span>

                            <form action="{{ route('expenses.pay', $expense) }}" method="POST">
                                @csrf
                                @method('PATCH')

                                <button type="submit" class="btn-pay"
                                    onclick="return confirm('Tem certeza que deseja marcar esta conta como paga?')">
                                    <i class="fa-solid fa-check"></i>
                                    Marcar como paga
                                </button>

                            </form>

                        </div>

                    </div>

                @empty

                    <p class="empty-message">
                        Nenhuma conta pendente neste mês.
                    </p>
                @endforelse

                <a href="{{ route('expenses.index') }}" class="card-link">
                    Ver todas as contas
                    <i class="fa-solid fa-arrow-right"></i>
                </a>

            </div>



            <!-- ÚLTIMOS PAGAMENTOS -->
            <div class="dashboard-card">

                <div class="card-title">
                    <h3>Últimos pagamentos</h3>
                </div>

                @forelse($latestPayments as $expense)
                    <div class="transaction-item">

                        <div>
                            <strong>
                                {{ $expense->description }}
                            </strong>

                            <small>
                                @if ($expense->category)
                                    {{ $expense->category->name }}
                                @else
                                    Despesa
                                @endif
                            </small>
                        </div>

                        <div class="transaction-value">

                            <strong class="text-red">
                                - R$ {{ number_format($expense->amount, 2, ',', '.') }}
                            </strong>

                            <small>
                                Pago em {{ $expense->paid_at->format('d/m/Y') }}
                            </small>

                            <form action="{{ route('expenses.pending', $expense) }}" method="POST">
                                @csrf
                                @method('PATCH')

                                <button type="submit" class="btn-undo-payment"
                                    onclick="return confirm('Tem certeza que deseja desfazer este pagamento?')">
                                    <i class="fa-solid fa-rotate-left"></i>
                                    Desfazer pagamento
                                </button>
                            </form>

                        </div>

                    </div>

                @empty

                    <p class="empty-message">
                        Nenhum pagamento realizado neste mês.
                    </p>
                @endforelse

                <a href="#" class="card-link">
                    Ver todos os pagamentos
                    <i class="fa-solid fa-arrow-right"></i>
                </a>

            </div>


            <!-- CATEGORIAS -->
            <div class="dashboard-card">

                <div class="card-title">
                    <h3>Despesas por categoria</h3>
                </div>

                <div class="category-list">

                    @forelse($expensesByCategory as $item)
                        <div class="category-item">

                            <span>
                                {{ $item->category?->name ?? 'Sem categoria' }}
                            </span>

                            <strong>
                                R$ {{ number_format($item->total, 2, ',', '.') }}
                            </strong>

                        </div>

                    @empty

                        <p class="empty-message">
                            Nenhuma despesa cadastrada neste mês.
                        </p>
                    @endforelse

                </div>

            </div>

        </section>


        <!-- PARTE INFERIOR -->
        <section class="bottom-grid">


            <!-- A RECEBER -->
            <div class="dashboard-card">

                <div class="card-title">
                    <h3>A receber</h3>
                </div>

                @forelse($pendingReceivables as $receivable)
                    <div class="receivable-item">

                        <div>
                            <strong>
                                {{ $receivable->person_name }}
                            </strong>

                            <small>
                                {{ $receivable->description }}
                            </small>
                        </div>

                        <strong>
                            R$ {{ number_format($receivable->amount, 2, ',', '.') }}
                        </strong>

                        <span class="status pending">
                            Pendente
                        </span>

                    </div>

                @empty

                    <p class="empty-message">
                        Nenhum valor pendente a receber.
                    </p>
                @endforelse

                <div class="receivable-total">

                    <span>Total a receber</span>

                    <strong class="text-green">
                        R$ {{ number_format($totalReceivables, 2, ',', '.') }}
                    </strong>

                </div>

            </div>


            <!-- META -->
            <div class="dashboard-card">

                <div class="card-title">

                    <h3>
                        @if ($goal)
                            Meta: {{ $goal->name }}
                        @else
                            Meta financeira
                        @endif
                    </h3>

                </div>


                @if ($goal)

                    <div class="goal-values">

                        <span>
                            <strong>
                                R$ {{ number_format($goal->goal_progress_amount, 2, ',', '.') }}
                            </strong>

                            de R$ {{ number_format($goal->target_amount, 2, ',', '.') }}
                        </span>

                        <span>
                            {{ number_format($goal->progress, 0) }}%
                        </span>

                    </div>


                    <div class="progress">

                        <div class="progress-bar" style="width: {{ $goal->progress }}%">
                        </div>

                    </div>


                    <div class="goal-dashboard-info">

                        <span>
                            Saldo atual:
                            <strong>
                                R$ {{ number_format($goal->current_amount, 2, ',', '.') }}
                            </strong>
                        </span>

                        <span>
                            Falta juntar:
                            <strong>
                                R$ {{ number_format($goal->remaining_amount, 2, ',', '.') }}
                            </strong>
                        </span>

                    </div>


                    <div class="goal-footer">

                        <span>

                            @if ($goal->deadline)
                                Prazo:
                                {{ $goal->deadline->translatedFormat('F \d\e Y') }}
                            @else
                                Sem prazo definido
                            @endif

                        </span>


                        <a href="{{ route('goals.index') }}">
                            Detalhes da meta
                        </a>

                    </div>
                @else
                    <div class="empty-message">
                        Nenhuma meta ativa cadastrada.
                    </div>

                    <div class="goal-footer">

                        <span>
                            Crie uma meta para acompanhar seu progresso.
                        </span>

                        <a href="{{ route('goals.create') }}">
                            Criar meta
                        </a>

                    </div>

                @endif

            </div>

        </section>

    </section>

@endsection
