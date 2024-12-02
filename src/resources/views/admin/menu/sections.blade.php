@extends('admin.layouts.main')
@section('panel')
    <section>
        <div class="container-fluid p-0">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ $setTitle }}</h4>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <h5 class="mb-2">{{ __('All Sections') }}</h5>
                            <ul id="list" class="list-group gap-2 dragable-list">
                                @forelse($sections as $sectionKey)
                                    <li class="list-group-item bg--light rounded-1 cursor-pointer" data-section_key="{{ $sectionKey }}">
                                        <p>{{ ucfirst(replaceInputTitle($sectionKey))}}</p>

                                        <span class="dragable-icon">
                                            <i class="bi bi-arrows-move"></i>
                                        </span>
                                    </li>
                                @empty
                                    <li class="list-group-item no-sections-message">No sections found</li>
                                @endforelse
                            </ul>
                        </div>

                        <div class="col-lg-6">
                            <h5 class="mb-2">{{ __($menu->name) }} Sections</h5>
                            <form id="submitForm" method="post" action="{{ route('admin.pages.section.update', ['id' => $menu->id]) }}">
                                @csrf
                                <ul id="list2" class="list-group gap-2 dragable-list" data-menu-id="{{ $menu->id }}">
                                    @forelse($menu->section_key ?? [] as $section)
                                        <li class="list-group-item bg--light rounded-1 cursor-pointer" data-section_key="{{ $section }}">
                                            <p>
                                                {{ replaceInputTitle($section) }}
                                            </p>

                                            <span class="dragable-icon">
                                                <i class="bi bi-arrows-move"></i>
                                            </span>
                                        </li>
                                    @empty
                                        <li class="list-group-item bg--light rounded-1 cursor-pointer"></li>
                                    @endforelse
                                </ul>
                                <button class="i-btn btn--primary btn--md" type="button" onclick="submitForm()">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('style-push')
    <style>
        ul:empty {
            padding: 20px;
            background: pink;
        }
    </style>
@endpush

@push('script-include')
    <script src="{{ getAssetPath(\App\Enums\Theme\ThemeAsset::ADMIN, \App\Enums\Theme\FileType::JS, 'sortable.js') }}"></script>
@endpush

@push('script-push')
    <script>
        "use strict";
        function submitForm() {
            const sectionKeys = $('#list2 li').map(function () {
                return $(this).data('section_key');
            }).get();

            $.ajax({
                method: 'POST',
                url: $('#submitForm').attr('action'),
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    section_keys: sectionKeys
                },
                success: function (response) {
                    notify('success', response);
                },
                error: function (error) {
                    notify('error', error);
                }
            });
        }

        $(document).ready(function () {
            new Sortable(document.getElementById('list'), {
                group: 'shared',
                animation: 100
            });

            new Sortable(document.getElementById('list2'), {
                group: 'shared',
                animation: 100,
                emptyInsertThreshold: 0
            });
        });
    </script>
@endpush
