@extends('admin.layouts.main')
@section('panel')
    <section>
        @include('admin.partials.filter', [
           'is_filter' => false,
           'is_modal' => true,
           'urls' => [
               [
                   'type' => 'modal',
                   'id' => 'subscriberModal',
                   'name' => __('Send Mail'),
                   'icon' => "<i class='las la-paper-plane'></i>"
               ],
            ],
       ])
        @include('admin.partials.table', [
             'columns' => [
                 'created_at' => __('Subscribe At'),
                 'email' => __('admin.table.email'),
             ],
             'rows' => $subscribers,
             'page_identifier' => \App\Enums\PageIdentifier::SUBSCRIBER->value,
        ])
    </section>

    <div class="modal fade" id="subscriberModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Send Mail') }}</h5>
                </div>
                <form action="{{route('admin.subscriber.send')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12 mb-3">
                                <label class="form-label" for="subject">{{ __('admin.input.subject') }} <sup class="text-danger">*</sup></label>
                                <input type="text" name="subject" id="subject" class="form-control" placeholder="{{ __('Enter Subject') }}">
                            </div>

                            <div class="col-lg-12 mb-3">
                                <label class="form-label" for="body">{{ __('Message') }} <sup class="text-danger">*</sup></label>
                                <textarea type="text" name="body" id="body" class="form-control" placeholder="{{ __('Enter Message') }}"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn--outline btn--sm" data-bs-dismiss="modal">{{ __('admin.button.close') }}</button>
                        <button type="submit" class="btn btn--primary btn--sm">{{ __('admin.button.save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
