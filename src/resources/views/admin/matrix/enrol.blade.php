@extends('admin.layouts.main')
@section('panel')
    <section>
        @include('admin.partials.filter', [
            'is_filter' => true,
            'is_modal' => false,
            'route' => route('admin.matrix.enrol'),
            'btn_name' => __('admin.filter.search'),
            'filters' => [
                [
                    'type' => \App\Enums\FilterType::SELECT_OPTIONS->value,
                    'value' => \App\Enums\Matrix\InvestmentStatus::toArrayByKey(),
                    'name' => 'status',
                ],
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
                'name' => __('admin.table.name'),
                'user_id' => __('admin.table.user'),
                'price' => __('admin.table.price'),
                'referral_commissions' => __('admin.user.content.referral'),
                'level_commissions' => __('admin.user.content.level'),
                'status' => __('admin.table.status'),
            ],
            'rows' => $matrixEnrolled,
            'page_identifier' => \App\Enums\PageIdentifier::MATRIX_ENROLLED->value,
        ])
    </section>
@endsection


