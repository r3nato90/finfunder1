<!DOCTYPE html>
<html lang="en" dir="ltl" data-sidebar="open" color-scheme="light">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>{{__(getArrayValue($setting?->appearance, 'site_title'))}} - {{@$setTitle}}</title>
    <link rel="shortcut icon" href="{{ displayImage(getArrayValue($setting?->logo, 'favicon'), "592x89") }}" type="image/x-icon">
    @foreach(getThemeFiles(\App\Enums\Theme\ThemeType::GLOBAL, \App\Enums\Theme\FileType::CSS) as $key =>  $themeFile)
        <link rel="stylesheet" href="{{ getAssetPath(\App\Enums\Theme\ThemeAsset::GLOBAL, \App\Enums\Theme\FileType::CSS, $themeFile) }}" />
    @endforeach
    @foreach(getThemeFiles(\App\Enums\Theme\ThemeType::USER, \App\Enums\Theme\FileType::CSS) as $key =>  $themeFile)
        <link rel="stylesheet" href="{{ getAssetPath(\App\Enums\Theme\ThemeAsset::USER, \App\Enums\Theme\FileType::CSS, $themeFile) }}" />
    @endforeach
    @include('default_theme.partials.color')
    @stack('style-file')
    @stack('style-push')
</head>

<body>
<div class="overlay-bg" id="overlay"></div>
    @include('user.partials.top-bar')
    <div class="dashboard-wrapper">
        @include('user.partials.side-bar')
        @yield('content')
    </div>

    @foreach(getThemeFiles(\App\Enums\Theme\ThemeType::GLOBAL, \App\Enums\Theme\FileType::JS) as $key => $themeFile)
        <script src="{{ getAssetPath(\App\Enums\Theme\ThemeAsset::GLOBAL, \App\Enums\Theme\FileType::JS, $themeFile) }}"></script>
    @endforeach
    @foreach(getThemeFiles(\App\Enums\Theme\ThemeType::FRONTEND, \App\Enums\Theme\FileType::JS) as $key => $themeFile)
        <script src="{{ getAssetPath(\App\Enums\Theme\ThemeAsset::FRONTEND, \App\Enums\Theme\FileType::JS, $themeFile) }}"></script>
    @endforeach
    @foreach(getThemeFiles(\App\Enums\Theme\ThemeType::USER, \App\Enums\Theme\FileType::JS) as $key => $themeFile)
        <script src="{{ getAssetPath(\App\Enums\Theme\ThemeAsset::USER, \App\Enums\Theme\FileType::JS, $themeFile) }}"></script>
    @endforeach
    @include('partials.notify')
    @stack('script-file')
    @stack('script-push')
</body>
</html>
