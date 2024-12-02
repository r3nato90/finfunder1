@extends(getActiveTheme().'.layouts.main')
@section('content')
    @include(getActiveTheme().'.partials.breadcrumb')
    <section class="privacy-policy pt-110 pb-110">
        <div class="container mt-5">
            @php echo getArrayValue($content?->meta, 'descriptions') @endphp
        </div>
    </section>
@endsection
