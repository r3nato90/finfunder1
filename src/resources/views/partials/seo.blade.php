@if (is_array($setting?->seo_setting))
    <meta name="title" Content="{{ getArrayValue($setting->appearance, 'site_title').' - '. @$setTitle }}">
    <meta name="description" content="{{ getArrayValue($setting->seo_setting,'description') }}">
    <meta name="keywords" content="{{ implode(',',\Illuminate\Support\Arr::get($setting->seo_setting,'keywords')) }}">
    <link rel="shortcut icon" href="{{ displayImage(getArrayValue($setting->seo_setting, 'image')) }}" type="image/x-icon">

    <link rel="apple-touch-icon" href="{{ displayImage(getArrayValue($setting->logo, 'white'), "592x89") }}">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="{{ getArrayValue($setting->appearance, 'site_title').' - '. @$setTitle }}">

    <meta itemprop="name" content="{{ getArrayValue($setting->appearance, 'site_title').' - '. @$setTitle }}">
    <meta itemprop="description" content="{{ getArrayValue($setting->seo_setting,'description') }}">
    <meta itemprop="image" content="{{ displayImage(getArrayValue($setting->seo_setting, 'image')) }}">

    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ getArrayValue($setting->seo_setting,'title') }}">
    <meta property="og:description" content="{{ getArrayValue($setting->seo_setting,'description') }}">
    <meta property="og:image" content="{{ displayImage(getArrayValue($setting->seo_setting, 'image')) }}"/>
    <meta property="og:url" content="{{ url()->current() }}">
@endif
