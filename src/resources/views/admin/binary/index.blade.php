@extends('admin.layouts.main')
@section('panel')
    <section>
        @include('admin.partials.filter', [
             'is_filter' => false,
             'is_modal' => true,
             'urls' => [
                [
                     'type' => 'url',
                     'url' => route('admin.binary.create'),
                     'name' => __('admin.filter.add_scheme'),
                     'icon' => "<i class='las la-plus'></i>"
                ],
            ],
        ])
        @include('admin.partials.table', [
             'columns' => [
                 'created_at' => __('admin.table.created_at'),
                 'name' => __('admin.table.name'),
                 'invest_limit' => __('admin.table.invest_limit'),
                 'investment_interest_rate' => __('Interest'),
                 'investment_time' => __('Time'),
                 'investment_return_type' => __('Return Type'),
                 'investment_recommend' => __('Recommend'),
                 'status' => __('admin.table.status'),
                 'action' => __('admin.table.action'),
             ],
             'rows' => $binaryInvests,
             'page_identifier' => \App\Enums\PageIdentifier::BINARY->value,
        ])
    </section>
@endsection
