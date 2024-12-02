<section class="inner-banner img-adjust">
    <div class="banner-blur"></div>
    <div class="container">
        <h2 class="inner-banner-title">{{ __($setTitle) }}</h2>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">{{ __('Home') }} </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page"> {{ __($setTitle) }}</li>
            </ol>
        </nav>
    </div>
</section>
