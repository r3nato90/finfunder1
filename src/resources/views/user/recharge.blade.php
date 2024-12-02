@extends('layouts.user')
@section('content')
    <div class="main-content" data-simplebar>
        <div class="row">
            <div class="col-lg-12">
                <div class="i-card-sm">
                    <div class="card-header">
                        <h4 class="title">{{ __($setTitle) }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-lg-6">
                                <div class="i-card-sm card--dark shadow-none">
                                    <div class="row justify-content-center align-items-center g-lg-2 g-1">
                                        <div class="col-lg-7 col-md-7 col-sm-7 text-end">
                                            <div class="d-flex flex-column justify-content-center align-items-center">
                                                <div class="avatar--xl rounded-0 mb-3 opacity-75">
                                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 60 60"  xml:space="preserve" class=""><g><path d="M58 12H2a2 2 0 0 0-2 2v32a2 2 0 0 0 2 2h56a2 2 0 0 0 2-2V14a2 2 0 0 0-2-2ZM2 46V14h56v32Z"  opacity="1" data-original="#000000" class=""></path><path d="M54.284 21.949a5.01 5.01 0 0 1-4.233-4.23A1.985 1.985 0 0 0 48.078 16H11.922a2.006 2.006 0 0 0-1.973 1.716 5.011 5.011 0 0 1-4.229 4.233A1.984 1.984 0 0 0 4 23.922v12.156a1.985 1.985 0 0 0 1.716 1.974 5.011 5.011 0 0 1 4.233 4.229A2.008 2.008 0 0 0 11.922 44h36.156a1.985 1.985 0 0 0 1.973-1.719 5.01 5.01 0 0 1 4.234-4.23A1.984 1.984 0 0 0 56 36.078V23.922a2.006 2.006 0 0 0-1.716-1.973ZM54 36.071a7.011 7.011 0 0 0-4.215 2.262A6.908 6.908 0 0 0 48.078 42h-36.15A7 7 0 0 0 6 36.078v-12.15A7 7 0 0 0 11.922 18h36.15A7.01 7.01 0 0 0 54 23.929Z"  opacity="1" data-original="#000000" class=""></path><path d="M12 26a4 4 0 1 0 4 4 4 4 0 0 0-4-4Zm0 6a2 2 0 1 1 2-2 2 2 0 0 1-2 2ZM44 30a4 4 0 1 0 4-4 4 4 0 0 0-4 4Zm6 0a2 2 0 1 1-2-2 2 2 0 0 1 2 2ZM30 20a10 10 0 1 0 10 10 10.011 10.011 0 0 0-10-10Zm0 18a8 8 0 1 1 8-8 8.009 8.009 0 0 1-8 8Z"  opacity="1" data-original="#000000" class=""></path><path d="M30 29a1 1 0 1 1 .867-1.5 1 1 0 1 0 1.731-1A2.993 2.993 0 0 0 31 25.2V25a1 1 0 0 0-2 0v.184A2.993 2.993 0 0 0 30 31a1 1 0 1 1-.867 1.5 1 1 0 0 0-1.731 1 3 3 0 0 0 1.6 1.3v.2a1 1 0 0 0 2 0v-.183A2.993 2.993 0 0 0 30 29Z"  opacity="1" data-original="#000000" class=""></path></g></svg>
                                                </div>
                                                <button class="arrow--btn deposit-process"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#rechargeModal"
                                                >{{ __('Recharge Now') }}<i class="bi bi-box-arrow-up-right ms-2"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="i-card-sm card--dark shadow-none">
                                    <div class="row justify-content-center align-items-center g-lg-2 g-1">
                                        <div class="col-lg-7 col-md-7 col-sm-7 text-end">
                                        <div class="d-flex flex-column justify-content-center align-items-center">
                                                <div class="avatar--xl rounded-0 mb-3 opacity-75">
                                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 60 60"  xml:space="preserve" class=""><g><path d="M22 27h15a1 1 0 0 0 1-1V14a1 1 0 0 0-1-1h-2v-2.5C35 7.467 32.532 5 29.5 5S24 7.467 24 10.5V13h-2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1zm4-16.5C26 8.57 27.57 7 29.5 7S33 8.57 33 10.5V13h-7v-2.5zM23 15h13v10H23V15zM49 33H11C4.935 33 0 37.935 0 44s4.935 11 11 11h38c6.065 0 11-4.935 11-11s-4.935-11-11-11zm0 20H11c-4.963 0-9-4.038-9-9s4.037-9 9-9h38c4.963 0 9 4.038 9 9s-4.037 9-9 9z"  opacity="1" data-original="#000000" class=""></path><path d="M15.553 41.105 13 42.382V39a1 1 0 1 0-2 0v3.382l-2.553-1.276a1 1 0 0 0-.895 1.789l2.928 1.464L8.2 47.4a1 1 0 1 0 1.6 1.2l2.2-2.934 2.2 2.934a.997.997 0 0 0 1.4.2 1 1 0 0 0 .2-1.4l-2.281-3.041 2.928-1.464a1 1 0 0 0-.894-1.79zM27.553 41.105 25 42.382V39a1 1 0 1 0-2 0v3.382l-2.553-1.276a1 1 0 0 0-.895 1.789l2.928 1.464L20.2 47.4a1 1 0 1 0 1.6 1.2l2.2-2.934 2.2 2.934a.997.997 0 0 0 1.4.2 1 1 0 0 0 .2-1.4l-2.281-3.041 2.928-1.464a1 1 0 0 0-.894-1.79zM39.553 41.105 37 42.382V39a1 1 0 1 0-2 0v3.382l-2.553-1.276a1 1 0 0 0-.895 1.789l2.928 1.464L32.2 47.4a1 1 0 1 0 1.6 1.2l2.2-2.934 2.2 2.934a.997.997 0 0 0 1.4.2 1 1 0 0 0 .2-1.4l-2.281-3.041 2.928-1.464a1 1 0 0 0-.894-1.79zM51.553 41.105 49 42.382V39a1 1 0 1 0-2 0v3.382l-2.553-1.276a1 1 0 0 0-.895 1.789l2.928 1.464L44.2 47.4a1 1 0 1 0 1.6 1.2l2.2-2.934 2.2 2.934a.997.997 0 0 0 1.4.2 1 1 0 0 0 .2-1.4l-2.281-3.041 2.928-1.464a1 1 0 0 0-.894-1.79z"  opacity="1" data-original="#000000" class=""></path></g></svg>
                                                </div>
                                                <button class="arrow--btn deposit-process"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#generateModal"
                                            >{{ __('Generate New Pin') }}<i class="bi bi-box-arrow-up-right ms-2"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-lg-12">
                <div class="i-card-sm">
                    <div class="card-body">
                        <div class="table-container">
                            <table id="myTable" class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">{{ __('Initiated At') }}</th>
                                        <th scope="col">{{ __('Amount') }}</th>
                                        <th scope="col">{{ __('Pin Number') }}</th>
                                        <th scope="col">{{ __('Status') }}</th>
                                        <th scope="col">{{ __('Details') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($pins as $key => $item)
                                        <tr>
                                            <td data-label="{{ __('Initiated At') }}">{{ showDateTime($item->created_at) }}</td>
                                            <td data-label="{{ __('Amount') }}">{{ getCurrencySymbol() }}{{ shortAmount($item->amount) }}</td>
                                            <td data-label="{{ __('Pin Number') }}">
                                                {{ $item->pin_number }}   <span class="reference-copy" data-pin="{{ $item->pin_number }}"><i class="las la-copy"></i></span>
                                            </td>
                                            <td data-label="{{ __('Status') }}">
                                                <span class="i-badge {{ \App\Enums\Matrix\PinStatus::getColor((int)$item->status) }} capsuled">
                                                    {{ \App\Enums\Matrix\PinStatus::getName((int)$item->status) }}
                                                </span>
                                            </td>
                                            <td data-label="{{ __('Details') }}">
                                                {{ $item->details }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="text-white text-center" colspan="100%">{{ __('No Data Found')}}</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="mt-4">{{ $pins->links() }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="rechargeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg--dark">
                    <h5 class="modal-title">{{ __('Top up Now') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                @if(getArrayValue($setting->system_configuration, 'e_pin.value') == \App\Enums\Status::ACTIVE->value)
                    <form method="POST" action="{{ route('user.recharge.save') }}">
                        @csrf
                        <div class="modal-body">
                            <div class="text-start">
                                <p class="mb-2 fw-bold">{{ __('This InstaPIN recharge only adds to the primary wallet') }}</p>
                            </div>

                            <div class="mb-3">
                                <label for="pin_number" class="col-form-label">{{ __('Pin Number') }}</label>
                                <input type="text" class="form-control" id="pin_number" name="pin_number" placeholder="{{ __('Enter Pin Number') }}" required>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="i-btn btn--light btn--md" data-bs-dismiss="modal">{{ __('Close') }}</button>
                            <button type="submit" class="i-btn btn--primary btn--md">{{ __('Submit') }}</button>
                        </div>
                    </form>
                @else
                    <div class="modal-body">
                        <p>{{ __('E-pin Recharge Currently Unavailable') }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="modal fade" id="generateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg--dark">
                    <h5 class="modal-title">{{ __('Generated New Pins') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                @if(getArrayValue($setting->system_configuration, 'e_pin.value') == \App\Enums\Status::ACTIVE->value)
                    <form method="POST" action="{{ route('user.recharge.generate') }}">
                        @csrf
                        <div class="modal-body">
                            <div class="text-start">
                                <p class="mb-2 fw-bold">{{ __('The amount will be deducted from your primary wallet.') }}</p>
                            </div>

                            <div class="mb-3">
                                <label for="amount" class="col-form-label">{{ __('Amount') }}</label>
                                <input type="text" class="form-control" id="amount" name="amount" placeholder="{{ __('Enter Amount') }}" required>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="i-btn btn--light btn--md" data-bs-dismiss="modal">{{ __('Close') }}</button>
                            <button type="submit" class="i-btn btn--primary btn--md">{{ __('Submit') }}</button>
                        </div>
                    </form>
                @else
                    <div class="modal-body">
                        <p>{{ __('E-pin Generated Currently Unavailable') }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('script-push')
    <script>
        "use strict";
        $(document).ready(function () {
            $('.reference-copy').click(function() {
                const copyText = $(this).data('pin');
                const textArea = document.createElement('textarea');
                textArea.value = copyText;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                notify('success', 'Copied to clipboard!');
            });
        });
    </script>
@endpush
