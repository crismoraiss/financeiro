@extends('layout.layout')

@section('title', 'Nova Despesa')

@section('content')

<section class="page-container">

    <div class="page-header">

        <div>
            <h1>Nova despesa</h1>
            <p>Registre uma nova conta ou gasto.</p>
        </div>

        <a href="{{ route('expenses.index') }}" class="btn-secondary">
            <i class="fa-solid fa-arrow-left"></i>
            Voltar
        </a>

    </div>

    <div class="form-card">

        <form action="{{ route('expenses.store') }}" method="POST">

            @csrf

            <div class="form-group">
                <label for="description">Descrição</label>

                <input
                    type="text"
                    id="description"
                    name="description"
                    value="{{ old('description') }}"
                    placeholder="Ex: Faculdade"
                >

                @error('description')
                    <small class="error-message">
                        {{ $message }}
                    </small>
                @enderror
            </div>

            <div class="form-group">
                <label for="category_id">Categoria</label>

                <select id="category_id" name="category_id">

                    <option value="">
                        Selecione uma categoria
                    </option>

                    @foreach($categories as $category)
                        <option
                            value="{{ $category->id }}"
                            {{ old('category_id') == $category->id ? 'selected' : '' }}
                        >
                            {{ $category->name }}
                        </option>
                    @endforeach

                </select>

                @error('category_id')
                    <small class="error-message">
                        {{ $message }}
                    </small>
                @enderror
            </div>

            <div class="form-group">
                <label for="amount">Valor</label>

                <input
                    type="number"
                    id="amount"
                    name="amount"
                    step="0.01"
                    min="0.01"
                    value="{{ old('amount') }}"
                    placeholder="0,00"
                >

                @error('amount')
                    <small class="error-message">
                        {{ $message }}
                    </small>
                @enderror
            </div>

            <div class="form-group">
                <label for="expense_type">Tipo da despesa</label>

                <select id="expense_type" name="expense_type">

                    <option value="">
                        Selecione
                    </option>

                    <option
                        value="fixed"
                        {{ old('expense_type') === 'fixed' ? 'selected' : '' }}
                    >
                        Fixa
                    </option>

                    <option
                        value="variable"
                        {{ old('expense_type') === 'variable' ? 'selected' : '' }}
                    >
                        Variável
                    </option>

                </select>

                @error('expense_type')
                    <small class="error-message">
                        {{ $message }}
                    </small>
                @enderror
            </div>

            <div class="form-group">
                <label for="due_date">Data de vencimento</label>

                <input
                    type="date"
                    id="due_date"
                    name="due_date"
                    value="{{ old('due_date') }}"
                >

                @error('due_date')
                    <small class="error-message">
                        {{ $message }}
                    </small>
                @enderror
            </div>

            <div class="form-group">
                <label for="status">Status</label>

                <select id="status" name="status">

                    <option
                        value="pending"
                        {{ old('status', 'pending') === 'pending' ? 'selected' : '' }}
                    >
                        Pendente
                    </option>

                    <option
                        value="paid"
                        {{ old('status') === 'paid' ? 'selected' : '' }}
                    >
                        Pago
                    </option>

                </select>
            </div>

            <div class="form-group">
                <label for="paid_at">Data do pagamento</label>

                <input
                    type="date"
                    id="paid_at"
                    name="paid_at"
                    value="{{ old('paid_at') }}"
                >
            </div>

            <div class="form-group">
                <label for="payment_method">Forma de pagamento</label>

                <select id="payment_method" name="payment_method">

                    <option value="">
                        Selecione
                    </option>

                    <option value="Pix">
                        Pix
                    </option>

                    <option value="Débito">
                        Débito
                    </option>

                    <option value="Crédito">
                        Crédito
                    </option>

                    <option value="Dinheiro">
                        Dinheiro
                    </option>

                    <option value="Boleto">
                        Boleto
                    </option>

                </select>
            </div>

            <div class="form-group">

                <label class="checkbox-label">

                    <input
                        type="checkbox"
                        name="is_recurring"
                        value="1"
                        {{ old('is_recurring') ? 'checked' : '' }}
                    >

                    Esta despesa se repete todos os meses

                </label>

            </div>

            <div class="form-group">
                <label for="observation">Observação</label>

                <textarea
                    id="observation"
                    name="observation"
                    rows="4"
                    placeholder="Ex: pagar antes do vencimento..."
                >{{ old('observation') }}</textarea>
            </div>

            <div class="form-actions">

                <a href="{{ route('expenses.index') }}" class="btn-secondary">
                    Cancelar
                </a>

                <button type="submit" class="btn-primary">
                    <i class="fa-solid fa-check"></i>
                    Salvar despesa
                </button>

            </div>

        </form>

    </div>

</section>

@endsection
