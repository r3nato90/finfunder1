@extends('admin.layouts.main')
@section('panel')
    <section>
        @include('admin.partials.filter', [
            'is_filter' => false,
            'is_modal' => true,
            'urls' => [
                [
                    'type' => 'modal',
                    'id' => 'exampleModal',
                    'name' => __('admin.filter.parameter'),
                    'icon' => "<i class='fas fa-plus'></i>"
                ],
                 [
                     'type' => 'url',
                     'url' => route('admin.matrix.create'),
                     'name' => __('admin.filter.add_plan'),
                     'icon' => "<i class='fas fa-plus'></i>"
                ]
            ],
        ])
        @include('admin.partials.table', [
             'columns' => [
                 'created_at' => __('admin.table.created_at'),
                 'name' => __('admin.table.name'),
                 'amount' => __('admin.table.amount'),
                 'referral_reward' => __('admin.table.referral_bonus'),
                 'plan_profit_loss' => __('admin.table.profit_loss'),
                 'status' => __('admin.table.status'),
                 'action' => __('admin.table.action'),
             ],
             'rows' => $plans,
             'page_identifier' => \App\Enums\PageIdentifier::MATRIX->value,
        ])
    </section>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('admin.matrix.content.parameter') }}</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('admin.matrix.parameters')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="mb-3">
                                <label for="height" class="form-label">{{ __('admin.input.height') }} <sup class="text-danger">*</sup></label>
                                <input type="text" name="height" id="height" value="{{getArrayValue($setting->matrix_parameters, 'height', 0)}}" class="form-control" placeholder="@lang('Enter Height')">
                            </div>

                            <div class="mb-3">
                                <label for="width" class="form-label">{{ __('admin.input.width') }} <sup class="text-danger">*</sup></label>
                                <input type="text" name="width" id="width" value="{{getArrayValue($setting->matrix_parameters, 'width', 0)}}" class="form-control" placeholder="@lang('Enter Width')">
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


