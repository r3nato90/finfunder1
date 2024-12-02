@extends('admin.layouts.main')
@section('panel')
    <section>
        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="tree-view-container">
                            <ul class="treeview">
                                <li class="items-expanded"> {{ $user->fullname }} ( {{ $user->email }} )
                                    @include('user.partials.tree-view', [ 'user' => $user,'step' => 0,'isFirst'=>true ])
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('style-include')
    <link rel="stylesheet" href="{{ getAssetPath(\App\Enums\Theme\ThemeAsset::GLOBAL, \App\Enums\Theme\FileType::CSS, 'tree-view.css') }}" />
@endpush

@push('script-include')
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
