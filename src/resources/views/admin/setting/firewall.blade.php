@extends('admin.layouts.main')
@section('panel')
    <section>
        @include('admin.partials.filter', [
            'is_filter' => false,
            'is_modal' => false,
        ])

        @include('admin.partials.table', [
            'columns' => [
                'created_at' => __('Initiated At'),
                'ip' => __('Ip'),
                'level' => __('Level'),
                'middleware' => __('Middleware'),
                'url' => __('Url'),
            ],
            'rows' => $firewallLogs,
            'page_identifier' => \App\Enums\PageIdentifier::FIREWALL_LOG->value,
        ])
    </section>
@endsection
