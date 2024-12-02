@extends('admin.layouts.main')
@section('panel')
    <section>
        @include('admin.partials.table', [
             'columns' => [
                 'created_at' => __('Initiated At'),
                 'trx' => __('Trx'),
                 'agent_id' => __('User'),
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
             'page_identifier' => \App\Enums\PageIdentifier::AGENT_WITHDRAW_LOG->value,
        ])
    </section>
@endsection
