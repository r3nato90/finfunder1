@extends('admin.layouts.main')
@section('panel')
    <section>
        @include('admin.partials.filter', [
            'is_filter' => false,
            'is_modal' => true,
            'urls' => [
                 [
                     'type' => 'url',
                     'url' => route('admin.withdraw.method.create'),
                     'name' => __('Add New Method'),
                     'icon' => "<i class='fas fa-plus'></i>"
                ]
            ],
        ])
        @include('admin.partials.table', [
             'columns' => [
                 'name' => __('Name'),
                 'created_at' => __('Initiated At'),
                 'withdraw_rate' => __('Method Currency'),
                 'withdraw_limit' => __('Withdrawal Limit'),
                 'withdraw_charges' => __('Charges'),
                 'status' => __('Status'),
                 'action' => __('Action'),
             ],
             'rows' => $withdrawMethods,
             'page_identifier' => \App\Enums\PageIdentifier::WITHDRAW_METHOD->value,
        ])
    </section>
@endsection


