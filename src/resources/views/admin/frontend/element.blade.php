@extends('admin.layouts.main')
@section('panel')
    <section>
        @include('admin.frontend.fixed', [
            'key' => $key,
            'section' => $section,
            'content' => $frontend,
            'content_type' => \App\Enums\Frontend\Content::ENHANCEMENT->value
        ])
    </section>
@endsection
