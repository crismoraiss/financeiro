@extends('layout.layout')

@section('content')

<section class="form-page">

    <div class="page-header">

        <div>
            <h1>Novo parcelamento</h1>

            <p>
                Cadastre uma compra parcelada para acompanhar os pagamentos.
            </p>
        </div>

        <a href="{{ route('installments.index') }}" class="btn-secondary">
            <i class="fa-solid fa-arrow-left"></i>
            Voltar
        </a>

    </div>

    @if ($errors->any())
        <div class="alert-error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-card">

        <form action="{{ route('installments.store') }}" method="POST">
            @csrf

            <div class="form-row">











  <label for="category_id">
        Categoria
    </label>

    <select
        id="category_id"
        name="category_id"
        required
    >

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









                <div class="form-group">
                    <label for="description">Descrição</label>

                    <input
                        type="text"
                        id="description"
                        name="description"
                        value="{{ old('description') }}"
                        placeholder="Ex: Gio Estética"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="card_name">Cartão</label>

                    <input
                        type="text"
                        id="card_name"
                        name="card_name"
                        value="{{ old('card_name') }}"
                        placeholder="Ex: Inter"
                    >
                </div>

            </div>

            <div class="form-row">

                <div class="form-group">
                    <label for="installment_amount">Valor da parcela</label>

                    <input
                        type="number"
                        id="installment_amount"
                        name="installment_amount"
                        step="0.01"
                        min="0.01"
                        value="{{ old('installment_amount') }}"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="total_installments">Total de parcelas</label>

                    <input
                        type="number"
                        id="total_installments"
                        name="total_installments"
                        min="1"
                        value="{{ old('total_installments') }}"
                        required
                    >
                </div>

            </div>

            <div class="form-row">

                <div class="form-group">
                    <label for="paid_installments">Parcelas já pagas</label>

                    <input
                        type="number"
                        id="paid_installments"
                        name="paid_installments"
                        min="0"
                        value="{{ old('paid_installments', 0) }}"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="due_day">Dia do vencimento</label>

                    <input
                        type="number"
                        id="due_day"
                        name="due_day"
                        min="1"
                        max="31"
                        value="{{ old('due_day') }}"
                        placeholder="Ex: 25"
                        required
                    >
                </div>

            </div>

            <div class="form-group">
                <label for="first_due_date">
                    Vencimento da primeira parcela
                </label>

                <input
                    type="date"
                    id="first_due_date"
                    name="first_due_date"
                    value="{{ old('first_due_date') }}"
                    required
                >

                <small class="form-help">
                    Informe a data em que venceu a parcela 1.
                </small>
            </div>

            <div class="form-group">
                <label for="observation">Observação</label>

                <textarea
                    id="observation"
                    name="observation"
                    rows="4"
                >{{ old('observation') }}</textarea>
            </div>

            <div class="form-actions">

                <a href="{{ route('installments.index') }}" class="btn-cancel">
                    Cancelar
                </a>

                <button type="submit" class="btn-save">
                    <i class="fa-solid fa-floppy-disk"></i>
                    Salvar parcelamento
                </button>

            </div>

        </form>

    </div>

</section>

@endsection
