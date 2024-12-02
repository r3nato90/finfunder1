@extends('admin.layouts.main')
@section('panel')
    <section>
         @include('admin.partials.filter', [
            'is_filter' => true,
            'is_modal' => true,
            'route' => route('admin.report.transactions'),
            'btn_name' => __('admin.filter.search'),
            'filters' => [
                [
                    'type' => \App\Enums\FilterType::SELECT_OPTIONS->value,
                    'value' => \App\Enums\Transaction\WalletType::toArrayByKey(),
                    'name' => 'wallet_type',
                ],
                 [
                    'type' => \App\Enums\FilterType::SELECT_OPTIONS->value,
                    'value' =>  \App\Enums\Transaction\Type::toArrayByKey(),
                    'name' => 'type',
                ],
                [
                    'type' => \App\Enums\FilterType::SELECT_OPTIONS->value,
                    'value' => \App\Enums\Transaction\Source::toArrayByKey(),
                    'name' => 'source',
                ],
                [
                    'type' => \App\Enums\FilterType::TEXT->value,
                    'name' => 'search',
                    'placeholder' => __('admin.filter.placeholder.trx')
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
                 'trx' => __('admin.table.trx'),
                 'user_id' => __('admin.table.user'),
                 'transaction_amount' => __('admin.table.amount'),
                 'transaction_post_balance' => __('admin.table.post_balance'),
                 'charge' => __('admin.table.charge'),
                 'transaction_wallet_type' => __('admin.table.wallet'),
                 'transaction_source' => __('admin.table.source'),
                 'details' => __('admin.table.details'),
             ],
            'rows' => $transactions,
            'page_identifier' => \App\Enums\PageIdentifier::TRANSACTIONS->value,
        ])
    </section>
@endsection



