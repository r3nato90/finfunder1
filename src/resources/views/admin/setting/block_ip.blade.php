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
                 'blocked' => __('Blocked'),
             ],
             'rows' => $blockIps,
             'page_identifier' => \App\Enums\PageIdentifier::BLOCK_IP->value,
        ])
    </section>
@endsection
