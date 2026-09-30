@extends('layout.layout')

@section('title', 'Editar Despesa')

@section('content')

<section class="page-container">

    <div class="page-header">

        <div>
            <h1>Editar despesa</h1>
            <p>Atualize as informações da despesa.</p>
        </div>

        <a href="{{ route('expenses.index') }}" class="btn-secondary">
            <i class="fa-solid fa-arrow-left"></i>
            Voltar
        </a>

    </div>

    <div class="form-card">

        <form
            action="{{ route('expenses.update', $expense) }}"
            method="POST"
        >

            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="description">Descrição</label>

                <input
                    type="text"
                    id="description"
                    name="description"
                    value="{{ old('description', $expense->description) }}"
                >
            </div>

            <div class="form-group">
                <label for="category_id">Categoria</label>

                <select id="category_id" name="category_id">

                    @foreach($categories as $category)

                        <option
                            value="{{ $category->id }}"
                            {{ old('category_id', $expense->category_id) == $category->id ? 'selected' : '' }}
                        >
                            {{ $category->name }}
                        </option>

                    @endforeach

                </select>
            </div>

            <div class="form-group">
                <label for="amount">Valor</label>

                <input
                    type="number"
                    id="amount"
                    name="amount"
                    step="0.01"
                    min="0.01"
                    value="{{ old('amount', $expense->amount) }}"
                >
            </div>

            <div class="form-group">
                <label for="expense_type">Tipo da despesa</label>

                <select id="expense_type" name="expense_type">

                    <option
                        value="fixed"
                        {{ old('expense_type', $expense->expense_type) === 'fixed' ? 'selected' : '' }}
                    >
                        Fixa
                    </option>

                    <option
                        value="variable"
                        {{ old('expense_type', $expense->expense_type) === 'variable' ? 'selected' : '' }}
                    >
                        Variável
                    </option>

                </select>
            </div>

            <div class="form-group">
                <label for="due_date">Data de vencimento</label>

                <input
                    type="date"
                    id="due_date"
                    name="due_date"
                    value="{{ old('due_date', $expense->due_date->format('Y-m-d')) }}"
                >
            </div>

            <div class="form-group">
                <label for="status">Status</label>

                <select id="status" name="status">

                    <option
                        value="pending"
                        {{ old('status', $expense->status) === 'pending' ? 'selected' : '' }}
                    >
                        Pendente
                    </option>

                    <option
                        value="paid"
                        {{ old('status', $expense->status) === 'paid' ? 'selected' : '' }}
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
                    value="{{ old(
                        'paid_at',
                        $expense->paid_at
                            ? $expense->paid_at->format('Y-m-d')
                            : ''
                    ) }}"
                >
            </div>

            <div class="form-group">
                <label for="payment_method">Forma de pagamento</label>

                <select id="payment_method" name="payment_method">

                    <option value="">
                        Selecione
                    </option>

                    @foreach(['Pix', 'Débito', 'Crédito', 'Dinheiro', 'Boleto'] as $method)

                        <option
                            value="{{ $method }}"
                            {{ old('payment_method', $expense->payment_method) === $method ? 'selected' : '' }}
                        >
                            {{ $method }}
                        </option>

                    @endforeach

                </select>
            </div>

            <div class="form-group">

                <label class="checkbox-label">

                    <input
                        type="checkbox"
                        name="is_recurring"
                        value="1"
                        {{ old('is_recurring', $expense->is_recurring) ? 'checked' : '' }}
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
                >{{ old('observation', $expense->observation) }}</textarea>
            </div>

            <div class="form-actions">

                <a href="{{ route('expenses.index') }}" class="btn-secondary">
                    Cancelar
                </a>

                <button type="submit" class="btn-primary">
                    Atualizar despesa
                </button>

            </div>

        </form>

    </div>

</section>

@endsection
