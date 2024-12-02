@extends('admin.layouts.main')
@section('panel')
    <section>
    @include('admin.partials.filter', [
        'is_filter' => true,
        'is_modal' => false,
        'route' => route('admin.binary.investment'),
        'btn_name' => __('admin.filter.search'),
        'filters' => [
            [
                'type' => \App\Enums\FilterType::SELECT_OPTIONS->value,
                'value' => \App\Enums\Investment\Status::toArrayByKey(),
                'name' => 'status',
            ],
            [
                'type' => \App\Enums\FilterType::SELECT_OPTIONS->value,
                'value' => \App\Enums\Investment\ReturnType::toArrayByKey(),
                'name' => 'return_type',
            ],
            [
                'type' => \App\Enums\FilterType::TEXT->value,
                'name' => 'search',
                'placeholder' => __('admin.filter.placeholder.user_plan')
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
             'plan_name' => __('admin.table.plan'),
             'amount' => __('admin.table.amount'),
             'investment_interest' => __('Interest'),
             'should_pay' => __('Should Pay'),
             'profit' => __('Paid'),
             'upcoming_investment_payment' => __('Upcoming Payment'),
             'action' => __('Action'),
         ],
         'rows' => $investmentLogs,
         'page_identifier' => \App\Enums\PageIdentifier::BINARY_INVESTMENT->value,
    ])
    </section>


    @foreach($investmentLogs as $investmentLog)

    @endforeach
@endsection


@push('script-push')
    <script>
        "use strict";
        function upcomingPaymentCount() {
            const elements = document.querySelectorAll('.payment_time');
            elements.forEach(function(element) {
                var profitTime = element.getAttribute('data-profit-time');
                var countDownDate = new Date(profitTime).getTime();

                var x = setInterval(function() {
                    var now = new Date().getTime();
                    var distance = countDownDate - now;

                    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    element.innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s ";

                    if (distance < 0) {
                        clearInterval(x);
                        element.innerHTML = "EXPIRED";
                    }
                }, 1000);
            });
        }

        document.addEventListener('DOMContentLoaded', upcomingPaymentCount);
    </script>
@endpush


