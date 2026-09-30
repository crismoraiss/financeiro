@extends('layout.layout')

@section('title', 'Categorias')

@section('content')

<section class="page-container">

    <div class="page-header">
        <div>
            <h1>Categorias</h1>
            <p>Organize suas receitas e despesas.</p>
        </div>

        <a href="{{ route('categories.create') }}" class="btn-primary">
            <i class="fa-solid fa-plus"></i>
            Nova categoria
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
                    <th>Nome</th>
                    <th>Tipo</th>
                    <th>Ações</th>
                </tr>
            </thead>

            <tbody>

                @forelse($categories as $category)

                    <tr>
                        <td>{{ $category->name }}</td>

                        <td>
                            @if($category->type === 'income')
                                <span class="badge badge-income">
                                    Receita
                                </span>
                            @else
                                <span class="badge badge-expense">
                                    Despesa
                                </span>
                            @endif
                        </td>

                        <td class="actions">

                            <a
                                href="{{ route('categories.edit', $category) }}"
                                class="btn-edit"
                            >
                                <i class="fa-solid fa-pen"></i>
                            </a>

                            <form
                                action="{{ route('categories.destroy', $category) }}"
                                method="POST"
                                onsubmit="return confirm('Deseja realmente excluir esta categoria?')"
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
                        <td colspan="3" class="empty-table">
                            Nenhuma categoria cadastrada.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</section>

@endsection
