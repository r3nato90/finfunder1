@extends('layouts.user')
@section('content')
    <div class="main-content" data-simplebar>
        <div class="i-card-sm">
            <div class="row align-items-center gy-5">
                <div class="col-xxl-12 col-xl-12 col-lg-12 order-lg-1 order-2">
                    <div class="card-header">
                        <h4 class="title">{{ __($setTitle) }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="tree-view-container">
                                    <ul class="treeview">
                                        <li class="items-expanded"> {{ $user->fullname }} ( {{ $user->email }} )  <span><i class="bi bi-activity"></i> {{ __('Referral Pool')}} <i class="bi bi-arrow-right"></i> {{ $user->referredUsers->count() }}</span>
                                            @include('user.partials.tree-view', [ 'user' => $user,'step' => 0,'isFirst'=>true ])
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style-file')
    <link rel="stylesheet" href="{{ getAssetPath(\App\Enums\Theme\ThemeAsset::GLOBAL, \App\Enums\Theme\FileType::CSS, 'tree-view.css') }}" />
@endpush

@push('script-file')
    <script src="{{ getAssetPath(\App\Enums\Theme\ThemeAsset::GLOBAL, \App\Enums\Theme\FileType::JS, 'tree-view.js') }}"></script>
@endpush

@push('script-push')
    <script>
        "use strict";
        $(document).ready(function () {
            $('.tree-view').treeView();
        });
    </script>
@endpush
