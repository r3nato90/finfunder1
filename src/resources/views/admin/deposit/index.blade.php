@extends('admin.layouts.main')
@section('panel')
    <section>
        @include('admin.partials.filter', [
            'is_filter' => true,
            'is_modal' => false,
            'route' => route('admin.deposit.index'),
            'btn_name' => __('admin.filter.search'),
            'filters' => [
                [
                    'type' => \App\Enums\FilterType::SELECT_OPTIONS->value,
                    'value' => \App\Enums\Payment\Deposit\Status::toArrayByKey(),
                    'name' => 'status',
                ],
                [
                    'type' => \App\Enums\FilterType::SELECT_OPTIONS->value,
                    'value' => \App\Enums\Payment\GatewayType::toArrayByKey(),
                    'name' => 'payment_processor',
                ],
                [
                    'type' => \App\Enums\FilterType::TEXT->value,
                    'name' => 'search',
                    'placeholder' => __('admin.filter.placeholder.user_trx')
                ],
                [
                    'type' => \App\Enums\FilterType::DATE_RANGE->value,
                    'name' => 'date',
                    'label' => 'Date',
                    'placeholder' =>  __('admin.filter.placeholder.date')
                ]
            ],
        ])

        @include('admin.partials.table', [
             'columns' => [
                 'created_at' => __('admin.table.created_at'),
                 'trx' => __('admin.table.trx'),
                 'user_id' => __('admin.table.user'),
                 'payment_gateway_id' => __('admin.table.gateway'),
                 'amount' => __('admin.table.amount'),
                 'charge' => __('admin.table.charge'),
                 'final_amount' => __('admin.table.final_amount'),
                 'status' => __('admin.table.status'),
                 'action' => __('admin.table.action'),
             ],
             'rows' => $deposits,
             'page_identifier' => \App\Enums\PageIdentifier::DEPOSIT->value,
        ])
    </section>
@endsection
