@extends('layout.layout')

@section('title', 'Nova Categoria')

@section('content')

<section class="page-container">

    <div class="page-header">
        <div>
            <h1>Nova categoria</h1>
            <p>Cadastre uma nova categoria financeira.</p>
        </div>

        <a href="{{ route('categories.index') }}" class="btn-secondary">
            <i class="fa-solid fa-arrow-left"></i>
            Voltar
        </a>
    </div>

    <div class="form-card">

        <form action="{{ route('categories.store') }}" method="POST">

            @csrf

            <div class="form-group">

                <label for="name">Nome da categoria</label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Ex: Alimentação"
                >

                @error('name')
                    <small class="error-message">
                        {{ $message }}
                    </small>
                @enderror

            </div>

            <div class="form-group">

                <label for="type">Tipo</label>

                <select id="type" name="type">

                    <option value="">
                        Selecione
                    </option>

                    <option
                        value="income"
                        {{ old('type') === 'income' ? 'selected' : '' }}
                    >
                        Receita
                    </option>

                    <option
                        value="expense"
                        {{ old('type') === 'expense' ? 'selected' : '' }}
                    >
                        Despesa
                    </option>

                </select>

                @error('type')
                    <small class="error-message">
                        {{ $message }}
                    </small>
                @enderror

            </div>

            <div class="form-actions">

                <a
                    href="{{ route('categories.index') }}"
                    class="btn-secondary"
                >
                    Cancelar
                </a>

                <button type="submit" class="btn-primary">
                    Salvar categoria
                </button>

            </div>

        </form>

    </div>

</section>

@endsection
