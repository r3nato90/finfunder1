@extends(getActiveTheme().'.layouts.app')
@section('panel')
    @include(getActiveTheme().'.partials.header')
    @yield('content')
    @include(getActiveTheme().'.partials.footer')
@endsection
