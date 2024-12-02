@extends(getActiveTheme().'.layouts.main')
@section('content')
    @include(getActiveTheme().'.partials.breadcrumb')
    @if(!is_null($page->section_key))
        @foreach($page->section_key as $section)
            @include(getActiveTheme().'.component.'.$section)
        @endforeach
    @endif
@endsection
