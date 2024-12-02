<!DOCTYPE html>
<html lang="en" color-scheme="light">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>{{__(getArrayValue($setting?->appearance, 'site_title'))}} - {{@$setTitle}}</title>
    @include('partials.seo')
    <link rel="shortcut icon" href="{{ displayImage(getArrayValue($setting?->logo, 'favicon'), "592x89") }}" type="image/x-icon">
    @foreach(getThemeFiles(\App\Enums\Theme\ThemeType::GLOBAL, \App\Enums\Theme\FileType::CSS) as $key =>  $themeFile)
        <link rel="stylesheet" href="{{ getAssetPath(\App\Enums\Theme\ThemeAsset::GLOBAL, \App\Enums\Theme\FileType::CSS, $themeFile) }}" />
    @endforeach
    @foreach(getThemeFiles(\App\Enums\Theme\ThemeType::AUTH, \App\Enums\Theme\FileType::CSS) as $key =>  $themeFile)
        <link rel="stylesheet" href="{{ getAssetPath(\App\Enums\Theme\ThemeAsset::AUTH, \App\Enums\Theme\FileType::CSS, $themeFile) }}" />
    @endforeach
    @include(getActiveTheme().'.partials.color')
    @stack('style-file')
    @stack('style-push')
</head>

<body class="tt-magic-cursor">
<div id="magic-cursor">
    <div id="ball"></div>
</div>
@yield('panel')
@foreach(getThemeFiles(\App\Enums\Theme\ThemeType::GLOBAL, \App\Enums\Theme\FileType::JS) as $key => $themeFile)
    <script src="{{ getAssetPath(\App\Enums\Theme\ThemeAsset::GLOBAL, \App\Enums\Theme\FileType::JS, $themeFile) }}"></script>
@endforeach
@foreach(getThemeFiles(\App\Enums\Theme\ThemeType::AUTH, \App\Enums\Theme\FileType::JS) as $key => $themeFile)
    <script src="{{ getAssetPath(\App\Enums\Theme\ThemeAsset::AUTH, \App\Enums\Theme\FileType::JS, $themeFile) }}"></script>
@endforeach
@include('partials.notify')
@include('partials.tawkto')
@include('partials.google_analytics')
@include('partials.hoory')
@stack('script-file')
@stack('script-push')
</body>
</html>
