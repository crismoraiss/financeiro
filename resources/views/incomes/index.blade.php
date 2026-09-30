@extends('layout.layout')

@section('title', 'Receitas')

@section('content')

<section class="page-container">

    <div class="page-header">
        <div>
            <h1>Receitas</h1>
            <p>Gerencie todas as suas entradas financeiras.</p>
        </div>

        <a href="{{ route('incomes.create') }}" class="btn-primary">
            <i class="fa-solid fa-plus"></i>
            Nova receita
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
                    <th>Data</th>
                    <th>Valor</th>
                    <th>Ações</th>
                </tr>
            </thead>

            <tbody>

                @forelse($incomes as $income)

                    <tr>

                        <td>
                            {{ $income->description }}
                        </td>

                        <td>
                            <span class="badge badge-income">
                                {{ $income->category->name }}
                            </span>
                        </td>

                        <td>
                            {{ \Carbon\Carbon::parse($income->received_at)->format('d/m/Y') }}
                        </td>

                        <td class="text-green">
                            <strong>
                                R$ {{ number_format($income->amount, 2, ',', '.') }}
                            </strong>
                        </td>

                        <td class="actions">

                            <a
                                href="{{ route('incomes.edit', $income) }}"
                                class="btn-edit"
                            >
                                <i class="fa-solid fa-pen"></i>
                            </a>

                            <form
                                action="{{ route('incomes.destroy', $income) }}"
                                method="POST"
                                onsubmit="return confirm('Deseja realmente excluir esta receita?')"
                            >

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="btn-delete"
                                >
                                    <i class="fa-solid fa-trash"></i>
                                </button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="5" class="empty-table">
                            Nenhuma receita cadastrada.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</section>

@endsection
