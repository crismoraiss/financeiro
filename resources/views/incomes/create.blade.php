@extends('layout.layout')

@section('title', 'Nova Receita')

@section('content')

<section class="page-container">

    <div class="page-header">

        <div>
            <h1>Nova receita</h1>
            <p>Registre uma nova entrada financeira.</p>
        </div>

        <a
            href="{{ route('incomes.index') }}"
            class="btn-secondary"
        >
            <i class="fa-solid fa-arrow-left"></i>
            Voltar
        </a>

    </div>


    <div class="form-card">

        <form
            action="{{ route('incomes.store') }}"
            method="POST"
        >

            @csrf


            <!-- DESCRIÇÃO -->

            <div class="form-group">

                <label for="description">
                    Descrição
                </label>

                <input
                    type="text"
                    id="description"
                    name="description"
                    value="{{ old('description') }}"
                    placeholder="Ex: Salário"
                >

                @error('description')
                    <small class="error-message">
                        {{ $message }}
                    </small>
                @enderror

            </div>


            <!-- CATEGORIA -->

            <div class="form-group">

                <label for="category_id">
                    Categoria
                </label>

                <select
                    id="category_id"
                    name="category_id"
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

                @error('category_id')
                    <small class="error-message">
                        {{ $message }}
                    </small>
                @enderror

            </div>


            <!-- VALOR -->

            <div class="form-group">

                <label for="amount">
                    Valor
                </label>

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


            <!-- DATA -->

            <div class="form-group">

                <label for="received_at">
                    Data do recebimento
                </label>

                <input
                    type="date"
                    id="received_at"
                    name="received_at"
                    value="{{ old('received_at') }}"
                >

                @error('received_at')
                    <small class="error-message">
                        {{ $message }}
                    </small>
                @enderror

            </div>


            <!-- OBSERVAÇÃO -->

            <div class="form-group">

                <label for="observation">
                    Observação
                </label>

                <textarea
                    id="observation"
                    name="observation"
                    rows="4"
                    placeholder="Alguma observação sobre esta receita..."
                >{{ old('observation') }}</textarea>

            </div>


            <div class="form-actions">

                <a
                    href="{{ route('incomes.index') }}"
                    class="btn-secondary"
                >
                    Cancelar
                </a>

                <button
                    type="submit"
                    class="btn-primary"
                >
                    <i class="fa-solid fa-check"></i>
                    Salvar receita
                </button>

            </div>

        </form>

    </div>

</section>

@endsection
