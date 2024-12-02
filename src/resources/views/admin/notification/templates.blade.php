@extends('admin.layouts.main')
@section('panel')
    <section>
        @include('admin.partials.filter', [
           'is_filter' => false,
           'is_modal' => false,
        ])

        @include('admin.partials.table', [
            'columns' => [
                'created_at' => __('admin.table.created_at'),
                'name' => __('admin.table.name'),
                'status' => __('admin.table.status'),
                'action' => __('admin.table.action'),
            ],
            'rows' => $templates,
            'page_identifier' => \App\Enums\PageIdentifier::SMS_EMAIL_TEMPLATES->value,
       ])
    </section>
@endsection
