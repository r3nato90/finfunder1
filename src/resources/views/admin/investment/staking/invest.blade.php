@extends('admin.layouts.main')
@section('panel')
    <section>
        @include('admin.partials.filter', [
          'is_filter' => true,
          'is_modal' => false,
          'route' => route('admin.binary.staking.investment'),
          'btn_name' => __('admin.filter.search'),
          'filters' => [
              [
                  'type' => \App\Enums\FilterType::TEXT->value,
                  'name' => 'search',
                  'placeholder' => __('Search by user')
              ],
              [
                  'type' => \App\Enums\FilterType::DATE_RANGE->value,
                  'name' => 'date',
                  'placeholder' => __('From Expiration Date - To Date')
              ]
          ],
      ])

        @include('admin.partials.table', [
             'columns' => [
                 'created_at' => __('admin.table.created_at'),
                 'user_id' => __('User'),
                 'amount' => __('Amount'),
                 'staking_interest' => __('Interest'),
                 'staking_total_return' => __('Total Return'),
                 'expiration_date' => __('Expiration Date'),
                 'status' => __('Status'),
             ],
             'rows' => $investments,
             'page_identifier' => \App\Enums\PageIdentifier::STAKING_INVESTMENT->value,
        ])
    </section>
@endsection
