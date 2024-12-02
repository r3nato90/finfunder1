@extends('admin.layouts.main')
@section('panel')
    <section>
        @include('admin.partials.filter', [
             'is_filter' => true,
             'is_modal' => false,
             'route' => route('admin.binary.daily.commissions'),
             'btn_name' => __('admin.filter.search'),
             'filters' => [
                 [
                     'type' => \App\Enums\FilterType::TEXT->value,
                     'name' => 'search',
                     'placeholder' => __('admin.filter.placeholder.user_trx')
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
                'amount' => __('admin.table.amount'),
                'details' => __('admin.table.details'),
            ],
            'rows' => $dailyCommissions,
            'page_identifier' => \App\Enums\PageIdentifier::DAILY_COMMISSIONS->value,
        ])
    </section>
@endsection


