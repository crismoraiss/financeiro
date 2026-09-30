@extends('layout.layout')

@section('title', 'Despesas')

@section('content')

<section class="page-container">

    <div class="page-header">
        <div>
            <h1>Despesas</h1>
            <p>Gerencie suas contas e gastos do mês.</p>
        </div>

        <a href="{{ route('expenses.create') }}" class="btn-primary">
            <i class="fa-solid fa-plus"></i>
            Nova despesa
        </a>
    </div>

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-card">

        <table class="data-table">

            <thead>
                <tr>
                    <th>Descrição</th>
                    <th>Categoria</th>
                    <th>Tipo</th>
                    <th>Vencimento</th>
                    <th>Status</th>
                    <th>Valor</th>
                    <th>Ações</th>
                </tr>
            </thead>

            <tbody>

                @forelse($expenses as $expense)

                    <tr>

                        <td>{{ $expense->description }}</td>

                        <td>
                            <span class="badge badge-expense">
                                {{ $expense->category->name }}
                            </span>
                        </td>

                        <td>
                            {{ $expense->expense_type === 'fixed' ? 'Fixa' : 'Variável' }}
                        </td>

                        <td>
                            {{ $expense->due_date->format('d/m/Y') }}
                        </td>

                        <td>
                            @if($expense->status === 'paid')
                                <span class="badge badge-paid">
                                    Pago
                                </span>
                            @else
                                <span class="badge badge-pending">
                                    Pendente
                                </span>
                            @endif
                        </td>

                        <td class="text-red">
                            <strong>
                                R$ {{ number_format($expense->amount, 2, ',', '.') }}
                            </strong>
                        </td>

                        <td class="actions">

                            <a
                                href="{{ route('expenses.edit', $expense) }}"
                                class="btn-edit"
                            >
                                <i class="fa-solid fa-pen"></i>
                            </a>

                            <form
                                action="{{ route('expenses.destroy', $expense) }}"
                                method="POST"
                                onsubmit="return confirm('Deseja realmente excluir esta despesa?')"
                            >
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn-delete">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="7" class="empty-table">
                            Nenhuma despesa cadastrada.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</section>

@endsection
