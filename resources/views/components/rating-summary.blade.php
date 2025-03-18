@props([
    'dFlex' => true,
    'rating',
    'totalReviews',
    'productId',
    'displaytotalReviews',
    'disableJs',
    'displayChevron' => true,
    'displayReviewsText' => true,
    'displayAverageRatings' => true,
])
@php
    $fullStars = floor($rating);
    $halfStar = $rating - $fullStars >= 0.5 ? 1 : 0;
    $emptyStars = 5 - ($fullStars + $halfStar);
@endphp
<div class="mb-2 position-relative">
    {{-- Affichage de l'évaluation globale avec déclencheur --}}
    <div class="{{ $dFlex ? 'd-flex' : '' }} align-items-center rating-trigger"
        style="cursor: {{ $disableJs ? 'default' : 'pointer' }};" data-product-id="{{ $productId }}">
        @if ($displayAverageRatings)
            <span class="me-1">{{ number_format($rating, 1, decimal_separator: ',') }}</span>
        @endif

        @if ($totalReviews == 0)
            {{-- Afficher 5 étoiles jaunes si aucune évaluation --}}
            @for ($i = 0; $i < 5; $i++)
                <i class="fa fa-star text-warning"></i>
            @endfor
        @else
            {{-- Afficher les étoiles normales --}}
            @for ($i = 0; $i < $fullStars; $i++)
                <i class="fa fa-star text-warning"></i>
            @endfor
            @if ($halfStar)
                <i class="fa fa-star-half-o text-warning"></i>
            @endif
            @for ($i = 0; $i < $emptyStars; $i++)
                <i class="fa fa-star" style="color: lightgray"></i>
            @endfor
        @endif
        @if ($displaytotalReviews)
            @if ($displayChevron)
                <i class="fa fa-chevron-down text-primary ms-2" title="Cliquez pour voir plus de détails"></i>
            @endif
            @if ($displayReviewsText)
                <span class="ms-3">{{ $totalReviews }} - Reviews</span>
            @else
                <span class="ms-3 fw-bold text-secondary">{{ $totalReviews }}</span>
            @endif
        @endif

    </div>

    {{-- Popup Card --}}
    @if (!$disableJs)
        <div class="card p-3 shadow-sm rating-popup"
            style="width: 350px; top: 120%; left: 0; display: none; z-index: 10; background: white; position: absolute;">

            {{-- Bouton de fermeture --}}
            <button type="button" class="btn-close position-absolute top-0 end-0 m-2 close-popup"></button>

            {{-- Conteneur pour le spinner --}}
            <div id="spinner" class="d-flex justify-content-center align-items-center"
                style="height: 100px; display: none;">
                <div class="spinner-border text-warning" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>

            {{-- Conteneur pour les détails des évaluations --}}
            <div id="rating-details"></div>
        </div>
    @endif
</div>

{{-- Scripts pour l'affichage et la fermeture du popup --}}
@if (!$disableJs)
    <script src="{{ asset('assets/js/rating-stat.js') }}"></script>
@endif
