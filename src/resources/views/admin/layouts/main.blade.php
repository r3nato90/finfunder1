@extends('admin.layouts.admin')
@section('content')
    @include('admin.partials.sidebar')
    <div id="mainContent" class="main_content">
        @include('admin.partials.top-bar')
        <div class="dashboard_container">
            @yield('panel')
        </div>
        <footer>
            <div class="footer-content">
                <p>{{ __(getArrayValue($setting->appearance, 'copy_right_text')) }}</p>
                <div class="footer-right">
                    <ul>
                        <li><a href="https://support.kloudinnovation.com/" target="_blank">{{__('Support')}}</a></li>
                    </ul>
                    <span>{{__('App-Version')}}: {{config('app.app_version')}}</span>
                </div>
            </div>
        </footer>
    </div>
@endsection
