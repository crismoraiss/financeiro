@extends('layout.layout')

@section('title', 'Editar Receita')

@section('content')

<section class="page-container">

    <div class="page-header">

        <div>
            <h1>Editar receita</h1>
            <p>Atualize as informações da receita.</p>
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
            action="{{ route('incomes.update', $income) }}"
            method="POST"
        >

            @csrf
            @method('PUT')


            <div class="form-group">

                <label for="description">
                    Descrição
                </label>

                <input
                    type="text"
                    id="description"
                    name="description"
                    value="{{ old('description', $income->description) }}"
                >

            </div>


            <div class="form-group">

                <label for="category_id">
                    Categoria
                </label>

                <select
                    id="category_id"
                    name="category_id"
                >

                    @foreach($categories as $category)

                        <option
                            value="{{ $category->id }}"
                            {{ old('category_id', $income->category_id) == $category->id ? 'selected' : '' }}
                        >
                            {{ $category->name }}
                        </option>

                    @endforeach

                </select>

            </div>


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
                    value="{{ old('amount', $income->amount) }}"
                >

            </div>


            <div class="form-group">

                <label for="received_at">
                    Data do recebimento
                </label>

                <input
                    type="date"
                    id="received_at"
                    name="received_at"
                    value="{{ old(
                        'received_at',
                        \Carbon\Carbon::parse($income->received_at)->format('Y-m-d')
                    ) }}"
                >

            </div>


            <div class="form-group">

                <label for="observation">
                    Observação
                </label>

                <textarea
                    id="observation"
                    name="observation"
                    rows="4"
                >{{ old('observation', $income->observation) }}</textarea>

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
                    Atualizar receita
                </button>

            </div>

        </form>

    </div>

</section>

@endsection
