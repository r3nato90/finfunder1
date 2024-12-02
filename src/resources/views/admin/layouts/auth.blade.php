<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>{{__(getArrayValue($setting->appearance, 'site_title'))}} - {{@$setTitle}}</title>
    <link rel="shortcut icon" href="{{ displayImage(getArrayValue($setting?->logo, 'favicon'), "592x89") }}" type="image/x-icon">
    @foreach(getThemeFiles(\App\Enums\Theme\ThemeType::GLOBAL, \App\Enums\Theme\FileType::CSS) as $key =>  $themeFile)
        <link rel="stylesheet" href="{{ getAssetPath(\App\Enums\Theme\ThemeAsset::GLOBAL, \App\Enums\Theme\FileType::CSS, $themeFile) }}" />
    @endforeach
    <link rel="stylesheet" href="{{ asset('assets/theme/admin/auth/css/style.css') }}" />
</head>
<body>
    <section class="admin-form">
        <div class="container">
            @yield('content')
        </div>
    </section>
    <div class="squire-container">
        <ul class="squares"></ul>
    </div>
    @foreach(getThemeFiles(\App\Enums\Theme\ThemeType::GLOBAL, \App\Enums\Theme\FileType::JS) as $key => $themeFile)
        <script src="{{ getAssetPath(\App\Enums\Theme\ThemeAsset::GLOBAL, \App\Enums\Theme\FileType::JS, $themeFile) }}"></script>
    @endforeach
    @include('partials.notify')
</body>
</html>
