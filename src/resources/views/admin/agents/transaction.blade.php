@extends('admin.layouts.main')
@section('panel')
    <section>
        @include('admin.partials.table', [
             'columns' => [
                 'created_at' => __('admin.table.created_at'),
                 'trx' => __('admin.table.trx'),
                 'transaction_name' => 'Agent',
                 'transaction_amount' => __('admin.table.amount'),
                 'post_balance' => __('admin.table.post_balance'),
                 'charge' => __('admin.table.charge'),
                 'details' => __('admin.table.details'),
             ],
            'rows' => $transactions,
            'page_identifier' => \App\Enums\PageIdentifier::AGENT_TRANSACTIONS->value,
        ])
    </section>
@endsection



