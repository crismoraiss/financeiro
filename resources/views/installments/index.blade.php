@extends('layout.layout')

@section('content')

<section class="installments-page">

    <div class="page-header">

        <div>
            <h1>Parcelamentos</h1>
            <p>
                Acompanhe suas compras parceladas e quanto ainda falta pagar.
            </p>
        </div>

        <a href="{{ route('installments.create') }}" class="btn-primary">
            <i class="fa-solid fa-plus"></i>
            Novo parcelamento
        </a>

    </div>

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="installments-grid">

        @forelse($installments as $installment)

            @php
                $paid = $installment->paid_installments;
                $total = $installment->total_installments;

                $remaining = $total - $paid;

                $totalValue =
                    $installment->installment_amount * $total;

                $paidValue =
                    $installment->installment_amount * $paid;

                $remainingValue =
                    $installment->installment_amount * $remaining;

                $progress =
                    $total > 0 ? ($paid / $total) * 100 : 0;
            @endphp

            <div class="installment-card">

                <div class="installment-header">

                    <div>
                        <h3>
                            {{ $installment->description }}
                        </h3>

                        @if($installment->card_name)
                            <span>
                                <i class="fa-regular fa-credit-card"></i>
                                Cartão {{ $installment->card_name }}
                            </span>
                        @endif
                    </div>

                    @if($installment->status === 'finished')

                        <span class="status received">
                            Finalizado
                        </span>

                    @else

                        <span class="status active">
                            Ativo
                        </span>

                    @endif

                </div>

                <div class="installment-main-value">

                    <strong>
                        R$ {{ number_format($installment->installment_amount, 2, ',', '.') }}
                    </strong>

                    <span>por parcela</span>

                </div>

                <div class="installment-progress-info">

                    <strong>
                        {{ $paid }} de {{ $total }} pagas
                    </strong>

                    <span>
                        {{ number_format($progress, 0) }}%
                    </span>

                </div>

                <div class="installment-progress">

                    <div
                        class="installment-progress-bar"
                        style="width: {{ $progress }}%"
                    ></div>

                </div>

                <div class="installment-details">

                    <div>
                        <span>Parcelas restantes</span>
                        <strong>{{ $remaining }}</strong>
                    </div>

                    <div>
                        <span>Já pago</span>

                        <strong>
                            R$ {{ number_format($paidValue, 2, ',', '.') }}
                        </strong>
                    </div>

                    <div>
                        <span>Valor restante</span>

                        <strong>
                            R$ {{ number_format($remainingValue, 2, ',', '.') }}
                        </strong>
                    </div>

                    <div>
                        <span>Vencimento</span>
                        <strong>Dia {{ $installment->due_day }}</strong>
                    </div>

                </div>

                <div class="installment-total">

                    <span>Valor total</span>

                    <strong>
                        R$ {{ number_format($totalValue, 2, ',', '.') }}
                    </strong>

                </div>

            </div>

        @empty

            <div class="empty-message">
                Nenhum parcelamento cadastrado.
            </div>

        @endforelse

    </div>

</section>

@endsection
