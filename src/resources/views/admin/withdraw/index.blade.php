@extends('admin.layouts.main')
@section('panel')
    <section>
        @include('admin.partials.filter', [
            'is_filter' => true,
            'is_modal' => false,
            'route' => route('admin.withdraw.index'),
            'btn_name' => __('Search'),
            'filters' => [
                [
                    'type' => \App\Enums\FilterType::SELECT_OPTIONS->value,
                    'value' => \App\Enums\Payment\Withdraw\Status::toArrayByKey(),
                    'name' => 'status',
                    'label' => 'Status',
                ],
                [
                    'type' => \App\Enums\FilterType::TEXT->value,
                    'name' => 'search',
                    'label' => 'Search',
                    'placeholder' => __('Search with trx or email')
                ],
                [
                    'type' => \App\Enums\FilterType::DATE_RANGE->value,
                    'name' => 'date',
                    'label' => 'Date',
                    'placeholder' => __('From Date-To Date')
                ]
            ],
        ])
        @include('admin.partials.table', [
             'columns' => [
                 'created_at' => __('Initiated At'),
                 'trx' => __('Trx'),
                 'user_id' => __('User'),
                 'withdraw_method_id' => __('Gateway'),
                 'withdraw_amount' => __('Amount'),
                 'final_amount' => __('Final Amount'),
                 'charge' => __('Charge'),
                 'after_charge' => __('After Charge'),
                 'withdraw_conversion' => __('Conversion'),
                 'status' => __('Status'),
                 'action' => __('Action'),
             ],
             'rows' => $withdrawLogs,
             'page_identifier' => \App\Enums\PageIdentifier::WITHDRAW_LOG->value,
        ])
    </section>
@endsection
