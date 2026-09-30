@extends('layout.layout')

@section('content')

<section class="receivables-page">

    <div class="page-header">

        <div>
            <h1>Valores a receber</h1>
            <p>
                Gerencie os valores que você emprestou e acompanhe os recebimentos.
            </p>
        </div>

        <a href="{{ route('receivables.create') }}" class="btn-primary">
            <i class="fa-solid fa-plus"></i>
            Novo valor a receber
        </a>

    </div>

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif


    <div class="receivables-card">

        @forelse($receivables as $receivable)

            <div class="receivable-item">

                <div class="receivable-info">

                    <strong>
                        {{ $receivable->person_name }}
                    </strong>

                    <span>
                        {{ $receivable->description }}
                    </span>

                    @if($receivable->due_date)
                        <small>
                            <i class="fa-regular fa-calendar"></i>

                            Previsto para:
                            {{ $receivable->due_date->format('d/m/Y') }}
                        </small>
                    @endif

                </div>


                <div class="receivable-value">

                    <strong>
                        R$ {{ number_format($receivable->amount, 2, ',', '.') }}
                    </strong>


                    @if($receivable->status === 'received')

                        <span class="status received">
                            <i class="fa-solid fa-check"></i>
                            Recebido
                        </span>

                        @if($receivable->received_at)

                            <small>
                                Recebido em
                                {{ $receivable->received_at->format('d/m/Y') }}
                            </small>

                        @endif

                    @else

                        <span class="status pending">
                            Pendente
                        </span>

                        <form
                            action="{{ route('receivables.update', $receivable) }}"
                            method="POST"
                        >
                            @csrf
                            @method('PUT')

                            <button
                                type="submit"
                                class="btn-received"
                                onclick="return confirm('Tem certeza que deseja marcar este valor como recebido?')"
                            >
                                <i class="fa-solid fa-check"></i>
                                Marcar como recebido
                            </button>

                        </form>

                    @endif

                </div>

            </div>

        @empty

            <div class="empty-message">

                <i class="fa-solid fa-hand-holding-dollar"></i>

                <p>
                    Nenhum valor a receber cadastrado.
                </p>

            </div>

        @endforelse

    </div>

</section>

@endsection
