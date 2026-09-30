@extends('layout.layout')

@section('content')

<section class="form-page">

    <div class="page-header">

        <div>
            <h1>Nova meta</h1>

            <p>
                Crie uma reserva financeira e acompanhe seu progresso.
            </p>
        </div>

        <a href="{{ route('goals.index') }}" class="btn-secondary">
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

        <form action="{{ route('goals.store') }}" method="POST">

            @csrf


            <div class="form-group">

                <label for="name">
                    Nome da meta
                </label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Ex: Faculdade"
                    required
                >

            </div>


            <div class="form-row">

                <div class="form-group">

                    <label for="initial_amount">
                        Quanto você já tem guardado?
                    </label>

                    <input
                        type="number"
                        id="initial_amount"
                        name="initial_amount"
                        step="0.01"
                        min="0"
                        value="{{ old('initial_amount', 0) }}"
                        required
                    >

                    <small class="form-help">
                        Valor que já existe na sua reserva hoje.
                    </small>

                </div>


                <div class="form-group">

                    <label for="target_amount">
                        Quanto quer juntar a mais?
                    </label>

                    <input
                        type="number"
                        id="target_amount"
                        name="target_amount"
                        step="0.01"
                        min="0.01"
                        value="{{ old('target_amount') }}"
                        placeholder="2600.00"
                        required
                    >

                </div>

            </div>


            <div class="form-group">

                <label for="deadline">
                    Prazo
                </label>

                <input
                    type="date"
                    id="deadline"
                    name="deadline"
                    value="{{ old('deadline') }}"
                >

            </div>


            <div class="form-group">

                <label for="description">
                    Observação
                </label>

                <textarea
                    id="description"
                    name="description"
                    rows="4"
                    placeholder="Ex: Reserva destinada à faculdade."
                >{{ old('description') }}</textarea>

            </div>


            <div class="form-actions">

                <a href="{{ route('goals.index') }}" class="btn-cancel">
                    Cancelar
                </a>

                <button type="submit" class="btn-save">
                    <i class="fa-solid fa-floppy-disk"></i>
                    Criar meta
                </button>

            </div>

        </form>

    </div>

</section>

@endsection
