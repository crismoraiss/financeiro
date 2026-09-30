@extends('layout.layout')

@section('content')

<section class="goals-page">

    <div class="page-header">

        <div>
            <h1>Metas</h1>

            <p>
                Acompanhe suas reservas e objetivos financeiros.
            </p>
        </div>

        <a href="{{ route('goals.create') }}" class="btn-primary">
            <i class="fa-solid fa-plus"></i>
            Nova meta
        </a>

    </div>


    @if(session('success'))

        <div class="alert-success">
            {{ session('success') }}
        </div>

    @endif


    @if($errors->any())

        <div class="alert-error">

            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>

    @endif


    @forelse($goals as $goal)

        <div class="goal-card">

            <div class="goal-header">

                <div>

                    <h2>
                        <i class="fa-solid fa-graduation-cap"></i>
                        {{ $goal->name }}
                    </h2>

                    @if($goal->deadline)

                        <span class="goal-deadline">
                            Objetivo até
                            {{ $goal->deadline->format('d/m/Y') }}
                        </span>

                    @endif

                </div>


                @if($goal->status === 'completed')

                    <span class="goal-status completed">
                        Meta alcançada
                    </span>

                @else

                    <span class="goal-status active">
                        Em andamento
                    </span>

                @endif

            </div>


            <div class="goal-balance">

                <span>Saldo atual da reserva</span>

                <strong>
                    R$ {{ number_format($goal->current_amount, 2, ',', '.') }}
                </strong>

            </div>


            <div class="goal-summary">

                <div>

                    <span>Valor inicial</span>

                    <strong>
                        R$ {{ number_format($goal->initial_amount, 2, ',', '.') }}
                    </strong>

                </div>


                <div>

                    <span>Meta de acréscimo</span>

                    <strong>
                        + R$ {{ number_format($goal->target_amount, 2, ',', '.') }}
                    </strong>

                </div>


                <div>

                    <span>Objetivo final</span>

                    <strong>
                        R$ {{ number_format($goal->final_target, 2, ',', '.') }}
                    </strong>

                </div>


                <div>

                    <span>Falta juntar</span>

                    <strong>
                        R$ {{ number_format($goal->remaining_amount, 2, ',', '.') }}
                    </strong>

                </div>

            </div>


            <div class="goal-progress-header">

                <span>Progresso da meta</span>

                <strong>
                    {{ number_format($goal->progress, 0) }}%
                </strong>

            </div>


            <div class="goal-progress">

                <div
                    class="goal-progress-bar"
                    style="width: {{ $goal->progress }}%"
                ></div>

            </div>


            <div class="goal-movement-summary">

                <span>
                    <i class="fa-solid fa-arrow-up"></i>

                    Guardado:
                    <strong>
                        R$ {{ number_format($goal->deposited_amount, 2, ',', '.') }}
                    </strong>
                </span>


                <span>
                    <i class="fa-solid fa-arrow-down"></i>

                    Retirado:
                    <strong>
                        R$ {{ number_format($goal->withdrawn_amount, 2, ',', '.') }}
                    </strong>
                </span>

            </div>


            <div class="goal-actions">

                <details class="goal-action-box">

                    <summary class="btn-goal-deposit">
                        <i class="fa-solid fa-plus"></i>
                        Guardar dinheiro
                    </summary>


                    <form
                        action="{{ route('goals.deposit', $goal) }}"
                        method="POST"
                        class="goal-transaction-form"
                    >

                        @csrf


                        <div class="form-row">

                            <div class="form-group">

                                <label>Valor</label>

                                <input
                                    type="number"
                                    name="amount"
                                    step="0.01"
                                    min="0.01"
                                    required
                                >

                            </div>


                            <div class="form-group">

                                <label>Data</label>

                                <input
                                    type="date"
                                    name="transaction_date"
                                    value="{{ date('Y-m-d') }}"
                                    required
                                >

                            </div>

                        </div>


                        <div class="form-group">

                            <label>Observação</label>

                            <input
                                type="text"
                                name="observation"
                                placeholder="Ex: Parte do salário"
                            >

                        </div>


                        <button type="submit" class="btn-save">
                            Confirmar depósito
                        </button>

                    </form>

                </details>


                <details class="goal-action-box">

                    <summary class="btn-goal-withdraw">
                        <i class="fa-solid fa-minus"></i>
                        Retirar dinheiro
                    </summary>


                    <form
                        action="{{ route('goals.withdraw', $goal) }}"
                        method="POST"
                        class="goal-transaction-form"
                    >

                        @csrf


                        <div class="form-row">

                            <div class="form-group">

                                <label>Valor</label>

                                <input
                                    type="number"
                                    name="amount"
                                    step="0.01"
                                    min="0.01"
                                    required
                                >

                            </div>


                            <div class="form-group">

                                <label>Data</label>

                                <input
                                    type="date"
                                    name="transaction_date"
                                    value="{{ date('Y-m-d') }}"
                                    required
                                >

                            </div>

                        </div>


                        <div class="form-group">

                            <label>Motivo da retirada</label>

                            <input
                                type="text"
                                name="observation"
                                placeholder="Ex: Imprevisto"
                            >

                        </div>


                        <button type="submit" class="btn-danger">
                            Confirmar retirada
                        </button>

                    </form>

                </details>

            </div>


            <div class="goal-history">

                <h3>
                    Histórico da reserva
                </h3>


                @forelse($goal->transactions as $transaction)

                    <div class="goal-history-item">

                        <div class="goal-history-info">

                            <span class="goal-history-date">
                                {{ $transaction->transaction_date->format('d/m/Y') }}
                            </span>


                            <div>

                                @if($transaction->type === 'deposit')

                                    <strong class="transaction-deposit">
                                        + R$ {{ number_format($transaction->amount, 2, ',', '.') }}
                                    </strong>

                                @else

                                    <strong class="transaction-withdrawal">
                                        - R$ {{ number_format($transaction->amount, 2, ',', '.') }}
                                    </strong>

                                @endif


                                @if($transaction->observation)

                                    <p>
                                        {{ $transaction->observation }}
                                    </p>

                                @endif

                            </div>

                        </div>

                    </div>

                @empty

                    <div class="goal-empty-history">
                        Nenhuma movimentação registrada ainda.
                    </div>

                @endforelse

            </div>

        </div>

    @empty

        <div class="empty-message">
            Você ainda não possui nenhuma meta cadastrada.
        </div>

    @endforelse

</section>

@endsection
