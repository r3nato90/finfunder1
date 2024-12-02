@extends('admin.layouts.main')
@section('panel')
    <section>
    @include('admin.partials.filter', [
        'is_filter' => true,
        'is_modal' => false,
        'route' => route('admin.trade.index'),
        'btn_name' => __('admin.filter.search'),
        'filters' => [
            [
                'type' => \App\Enums\FilterType::SELECT_OPTIONS->value,
                'value' => \App\Enums\Trade\TradeStatus::toArrayByKey(),
                'name' => 'status',
            ],
            [
                'type' => \App\Enums\FilterType::SELECT_OPTIONS->value,
                'value' => \App\Enums\Trade\TradeVolume::toArrayByKey(),
                'name' => 'volume',
            ],
            [
                'type' => \App\Enums\FilterType::SELECT_OPTIONS->value,
                'value' => \App\Enums\Trade\TradeOutcome::toArrayByKey(),
                'name' => 'outcome',
            ],
            [
                'type' => \App\Enums\FilterType::TEXT->value,
                'name' => 'search',
                'placeholder' => __('admin.filter.placeholder.crypto_email')
            ],
            [
                'type' => \App\Enums\FilterType::DATE_RANGE->value,
                'name' => 'date',
                'placeholder' => __('admin.filter.placeholder.date')
            ]
        ],
    ])
    @include('admin.partials.table', [
        'columns' => [
            'created_at' => __('admin.table.created_at'),
            'user_id' => __('admin.table.user'),
            'trade_currency_id' => __('admin.table.crypto'),
            'trade_original_price' => __('admin.table.price_was'),
            'trade_outcome_amount' => __('admin.table.amount'),
            'arrival_time' => __('admin.table.arrival_time'),
            'trade_volume' => __('admin.table.volume'),
            'trade_outcome' => __('admin.table.outcome'),
            'status' => __('admin.table.status'),
        ],
        'rows' => $trades,
        'page_identifier' => \App\Enums\PageIdentifier::TRADE->value,
   ])
    </section>
@endsection
