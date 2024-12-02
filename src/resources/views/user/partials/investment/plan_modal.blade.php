<div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Terms and policy') }}</h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="invest_terms" class="text-white"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="i-btn btn--danger btn--md" data-bs-dismiss="modal">{{ __('Close') }}</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="investModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="investTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form method="POST" action="{{ route('user.investment.store') }}">
                @csrf
                <input type="hidden" name="uid" value="">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="amount" class="col-form-label">{{ __('Amount') }}</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="amount" name="amount"
                                   placeholder="{{ __('Enter Invest amount') }}"
                                   aria-label="Recipient's username" aria-describedby="basic-addon2">
                            <span class="input-group-text" id="basic-addon2">{{ getCurrencyName() }}</span>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="i-btn btn--outline btn--md" data-bs-dismiss="modal">{{ __('Close') }}</button>
                    <button type="submit" class="i-btn btn--primary btn--md">{{ __('Submit') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@push('script-push')
    <script>
        "use strict";
        $(document).ready(function () {
            $('.invest-process').click(function () {
                const name = $(this).data('name');
                const uid = $(this).data('uid');
                $('input[name="uid"]').val(uid);

                const title = "Start Investing with the " + name + " Plan";
                $('#investTitle').text(title);
            });

            $('.terms-policy').click(function () {
                const terms = $(this).data('terms_policy');
                $('#invest_terms').text(terms);
            });
        });
    </script>
@endpush
