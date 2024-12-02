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
                 'email' => __('admin.table.email'),
                 'subject' => __('admin.table.subject'),
                 'message' => __('admin.table.message'),
             ],
             'rows' => $contacts,
             'page_identifier' => \App\Enums\PageIdentifier::CONTACT->value,
        ])
    </section>
@endsection
