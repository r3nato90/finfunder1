@extends('admin.layouts.main')
@section('panel')
    <section>
        <div class="row g-4">
            <div class="col-xl-8 col-lg-7">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{__($setTitle)}}</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{route('admin.notifications.save')}}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="mail_template" class="form-label">{{ __('admin.input.mail_template') }}<sup class="text-danger">*</sup></label>
                                <textarea class="summernote" name="mail_template" id="mail_template" cols="30" rows="10">@php echo $setting->mail_template @endphp</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="sms_template" class="form-label">{{ __('admin.input.sms_template') }}<sup class="text-danger">*</sup></label>
                                <textarea class="form-control" name="sms_template" id="sms_template" cols="10" rows="5">{{ $setting->sms_template }}</textarea>
                            </div>
                            <button class="i-btn btn--primary btn--lg"> {{ __('admin.button.save') }}</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-5">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{__('admin.notification.content.short_code')}}</h4>
                    </div>
                    <div class="card-body">
                        <ul class="shortcode-list">
                            <li><span>{{ __('admin.input.full_name') }}</span><span>[full_name]</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script-push')
    <script>
        'use strict'
        $(document).ready(function() {
            $('.summernote').summernote({
                height: 300,
                placeholder: 'Enter Descriptions',
                dialogsInBody: true,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['insert', ['picture', 'link', 'video']],
                ],
                callbacks: {
                    onInit: function() {
                    }
                }
            });
            $(".note-image-input").removeAttr('name');
        });
    </script>
@endpush

