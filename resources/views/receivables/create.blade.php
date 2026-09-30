@extends('layout.layout')

@section('content')

<section class="form-page">

    <div class="page-header">

        <div>
            <h1>Novo valor a receber</h1>

            <p>
                Cadastre um valor emprestado e acompanhe o recebimento.
            </p>
        </div>

        <a href="{{ route('receivables.index') }}" class="btn-secondary">
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

        <form action="{{ route('receivables.store') }}" method="POST">

            @csrf


            <div class="form-row">

                <div class="form-group">

                    <label for="person_name">
                        Quem te deve?
                    </label>

                    <input
                        type="text"
                        id="person_name"
                        name="person_name"
                        value="{{ old('person_name') }}"
                        placeholder="Ex: Mãe, Pai, João..."
                        required
                    >

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
                        value="{{ old('amount') }}"
                        placeholder="0,00"
                        required
                    >

                </div>

            </div>


            <div class="form-group">

                <label for="description">
                    Descrição
                </label>

                <input
                    type="text"
                    id="description"
                    name="description"
                    value="{{ old('description') }}"
                    placeholder="Ex: Empréstimo, compra no cartão..."
                    required
                >

            </div>


            <div class="form-row">

                <div class="form-group">

                    <label for="due_date">
                        Data prevista para receber
                    </label>

                    <input
                        type="date"
                        id="due_date"
                        name="due_date"
                        value="{{ old('due_date') }}"
                    >

                </div>


                <div class="form-group">

                    <label for="status">
                        Status
                    </label>

                    <select id="status" name="status" required>

                        <option
                            value="pending"
                            {{ old('status', 'pending') === 'pending' ? 'selected' : '' }}
                        >
                            Pendente
                        </option>

                        <option
                            value="received"
                            {{ old('status') === 'received' ? 'selected' : '' }}
                        >
                            Recebido
                        </option>

                    </select>

                </div>

            </div>


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

                <small class="form-help">
                    Preencha apenas se o valor já tiver sido recebido.
                </small>

            </div>


            <div class="form-group">

                <label for="observation">
                    Observação
                </label>

                <textarea
                    id="observation"
                    name="observation"
                    rows="4"
                    placeholder="Adicione alguma informação adicional..."
                >{{ old('observation') }}</textarea>

            </div>


            <div class="form-actions">

                <a
                    href="{{ route('receivables.index') }}"
                    class="btn-cancel"
                >
                    Cancelar
                </a>

                <button type="submit" class="btn-save">

                    <i class="fa-solid fa-floppy-disk"></i>

                    Salvar valor

                </button>

            </div>

        </form>

    </div>

</section>

@endsection
