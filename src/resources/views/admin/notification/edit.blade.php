@extends('admin.layouts.main')
@section('panel')
    <section>
        <div class="card">
            <div class="card-header">
                <h4 class="card-title text-start">{{__('admin.notification.content.short_code')}}</h4>
            </div>
            <div class="responsive-table">
                <table>
                    <thead>
                        <tr>
                            <th>{{ __('admin.table.short_key') }}</th>
                            <th>{{ __('admin.table.details') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($template->short_key)
                            @foreach($template->short_key as $key => $value)
                                <tr>
                                    <td>[@lang($key)]</td>
                                    <td>{{__($value)}}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>

            <div class="card-header">
                <h4 class="card-title text-start">{{__('admin.notification.content.template_update')}}</h4>
            </div>

            <form id="setting-form" action="{{route('admin.notifications.update',$template->id)}}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-wrapper">
                        <div class="row g-3">
                            <div class="mb-3 col-lg-4">
                                <label for="subject" class="form-label">{{ __('admin.input.subject') }}</label>
                                <input type="text" name="subject" value="{{$template->subject}}" class="form-control" id="subject" placeholder="@lang('Enter Subject')">
                            </div>

                            <div class="mb-3 col-lg-4">
                                <label for="from_email" class="form-label">{{ __('admin.input.email_from') }}</label>
                                <input type="text" name="from_email" value="{{$template->from_email}}"  class="form-control" id="from_email" placeholder="@lang('Enter Email From')">
                            </div>

                            <div class="mb-3 col-lg-4">
                                <label for="status" class="form-label">{{ __('admin.input.status') }}</label>
                                <select class="form-select" name="status" id="status" required>
                                    @foreach(\App\Enums\Status::toArray() as $key =>  $status)
                                        <option value="{{ $status }}" @if($status == $template->status) selected @endif>{{ replaceInputTitle($key) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3 col-lg-12">
                                <label for="mail_template" class="form-label">{{ __('admin.input.mail_template') }}</label>
                                <textarea class="form-control" name="mail_template" id="mail_template" cols="30" rows="10">{{ $template->mail_template }}</textarea>
                            </div>

                            <div class="mb-3 col-lg-12">
                                <label for="sms_template" class="form-label">{{ __('admin.input.sms_template') }}<sup class="text-danger">*</sup></label>
                                <textarea class="form-control" name="sms_template" id="sms_template" cols="10" rows="5">{{ $template->sms_template }}</textarea>
                            </div>
                        </div>
                    </div>
                    <button class="i-btn btn--primary btn--lg">{{ __('admin.button.save') }}</button>
                </div>
            </form>
        </div>
    </section>
@endsection


