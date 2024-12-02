@extends('admin.layouts.main')
@section('panel')
    <section>
        <div class="container-fluid p-0">
            <div class="row gy-4">
                <div class="col-lg-auto">
                    <div class="card sticky-item">
                        <div class="card-body">
                            <div class="nav nav-style-two flex-column nav-pills gap-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                @foreach($plugins as $plugin)
                                    <a class="nav-link {{ $loop->first ? 'active' : '' }}" id="v-pills-{{ strtolower(str_replace(' ', '-', $plugin['name'])) }}-tab" data-bs-toggle="pill" href="#v-pills-{{ strtolower(str_replace(' ', '-', $plugin['name'])) }}" role="tab" aria-controls="v-pills-{{ strtolower(str_replace(' ', '-', $plugin['name'])) }}" aria-selected="{{ $loop->first ? 'true' : 'false' }}" tabindex="{{ $loop->index }}">
                                        {{ __($plugin['name']) }}
                                        <span><i class="las la-angle-right"></i></span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="tab-content vertical-tab-content" id="v-pills-tabContent">
                        @foreach($plugins as $plugin)
                            <div class="tab-pane fade {{ $loop->first ? 'active show' : '' }}" id="v-pills-{{ strtolower(str_replace(' ', '-', $plugin['name'])) }}" role="tabpanel" aria-labelledby="v-pills-{{ strtolower(str_replace(' ', '-', $plugin['name'])) }}-tab">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">{{ __($plugin['name']) }}</h4>
                                    </div>

                                    <div class="card-body">
                                        <form id="setting-form" action="{{ route('admin.plugin.update') }}" method="POST">
                                            @csrf
                                            <input type="hidden" value="{{ $plugin->code }}" name="code">
                                            <div class="row g-3">
                                                <div class="mb-3 col-lg-12">
                                                    <label for="api_key" class="form-label">@lang('Api Key')</label>
                                                    <input type="text" name="api_key" value="{{ getArrayValue($plugin['short_key'], 'api_key') }}" class="form-control" id="api_key" placeholder="@lang('Enter Api Key')">
                                                </div>

                                                <div class="mb-3 col-lg-12">
                                                    <label for="status" class="form-label">@lang('Status')</label>
                                                    <select class="form-select" name="status" id="status" required>
                                                        @foreach(\App\Enums\Status::toArray() as $key => $status)
                                                            <option value="{{ $status }}" @if($status == (int)$plugin['status']) selected @endif>{{ replaceInputTitle($key) }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <button class="i-btn btn--primary btn--lg">@lang('Submit')</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
