@php
    $primaryColor = getArrayValue($setting?->theme_setting, 'primary_color');
    $primaryLightFirstColor = hex2rgba($primaryColor, 0.15);
    $primaryLightSecondColor = hex2rgba($primaryColor, 0.08);
    $secondaryColor = getArrayValue($setting?->theme_setting, 'secondary_color');
    $primaryTextColor = getArrayValue($setting?->theme_setting, 'primary_text_color');
    $secondaryTextColor = getArrayValue($setting?->theme_setting, 'secondary_text_color');
@endphp
<style>
    :root {
        color-scheme: light;
        --font-primary: "Kanit", sans-serif;
        --font-secondary: "Kanit", sans-serif;
        --color-primary: @php echo $primaryColor @endphp;
        --color-primary-light: @php echo $primaryLightFirstColor @endphp;
        --color-primary-light-2: @php echo $primaryLightSecondColor @endphp;
        --color-primary-text: #ffffff;
        --text-primary: @php echo $primaryTextColor @endphp;;
        --text-secondary: @php echo $secondaryTextColor @endphp;
        --text-light: #b7b7b7;
        --color-border: #d1d1d1;
        --border-primary: rgba(234, 125, 24, 0.4);
        --border-light: rgba(255, 255, 255, .2);
        --color-white: #fff;
        --color-gray-1: #eff2f7;
        --color-dark: #101010;
        --color-dark-2: #2d3134;
        --bg-light: #f7f6f5;
        --site-bg: #ffffff;
        --card-bg: #fff;
        --topbar-bg: #fff;
        --sidebar-bg: #fff;
        --color-success: #2EBD85;
        --color-success-light: rgba(10, 179, 156, 0.12);
        --success-border: rgba(10, 179, 156, 0.4);
        --color-danger: rgb(255, 20, 35);
        --color-danger-light: rgba(240, 101, 72, 0.12);
        --danger-border: rgba(240, 101, 72, 0.4);
        --color-warning: rgb(259, 165, 81);
        --color-warning-light: rgba(247, 184, 75, 0.15);
        --color-info: rgb(45, 140, 210);
        --color-info-light: rgba(45, 140, 210, 0.15);
        --color-green: rgb(10, 179, 58);
        --color-green-light: rgba(10, 179, 58, 0.1);
        --color-purple: rgb(105, 4, 207);
        --color-purple-light: rgba(105, 4, 207, 0.1);
        --color-blue: rgb(4, 163, 207);
        --color-blue-light: rgba(4, 163, 207, 0.1)
    }

</style>
