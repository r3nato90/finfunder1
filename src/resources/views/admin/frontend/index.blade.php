@extends('admin.layouts.main')
@section('panel')
    <section>
        @include('admin.frontend.fixed', [
            'key' => $key,
            'section' => $section,
            'content' => $getFixedContent,
            'content_type' => \App\Enums\Frontend\Content::FIXED->value
        ])

        @include('admin.frontend.enhancement', [
            'section_key' => $key,
            'section' => $section,
            'content_type' => \App\Enums\Frontend\Content::ENHANCEMENT->value,
            'contents' => $getEnhancementContents
        ])
    </section>

    <div class="modal fade" id="delete-element" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Delete Element') }}</h5>
                </div>
                <form action="{{route('admin.frontend.section.delete')}}" method="POST">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <p>{{ __('Are you sure to delete this section element')}}</p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn--danger btn--sm" data-bs-dismiss="modal">{{ __('admin.button.close') }}</button>
                        <button type="submit" class="btn btn--primary btn--sm">{{ __('admin.button.delete') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script-push')
    <script>
        "use strict";
        $('.remove-element').on('click', function () {
            const modal = $('#delete-element');
            modal.find('input[name=id]').val($(this).data('id'));
            modal.modal('show');
        });
    </script>
@endpush



