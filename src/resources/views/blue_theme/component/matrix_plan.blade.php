@if(getArrayValue($setting->investment_setting, getInputName(\App\Enums\InvestmentType::MATRIX->name)) == 1)
    @php
        $fixedContent = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::MATRIX_PLAN, \App\Enums\Frontend\Content::FIXED);
    @endphp
    <section class="community pt-120 pb-120">
        <div class="container-fluid container-wrapper">
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-10">
                    <div class="section-title text-center">
                        <h2>{{ getArrayValue($fixedContent?->meta, 'heading') }}</h2>
                        <p>{{ getArrayValue($fixedContent?->meta, 'sub_heading') }}</p>
                    </div>
                </div>
            </div>

            <div class="row g-4 justify-content-center">
                @include('user.partials.matrix.blue_plan')
            </div>
        </div>

        <div class="community-vector">
            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0"
                 viewBox="0 0 511.94 511.94" xml:space="preserve">
      <g>
          <path
              d="m323.74 80.35.01-35.21c.27-12.21 10-22.41 22.26-22.58 12.677-.159 22.9 10.057 22.9 22.58V30.09c0-12.48 10.12-22.59 22.59-22.59 12.473 0 22.59 10.117 22.59 22.59v22.59c0-12.48 10.11-22.59 22.59-22.59 12.473 0 22.59 10.109 22.59 22.59v37.64c0-12.47 10.11-22.58 22.58-22.58 12.48 0 22.59 10.1 22.59 22.58v50.96c0 25.97-5.56 51.63-16.3 75.27a238.187 238.187 0 0 0-21.34 98.52v7.68M323.74 115.35V137c0 10.993-11.48 18.275-21.39 13.56l-21.59-10.81c-11.515-5.758-25.153-2.094-32.41 7.99a14.995 14.995 0 0 0 1.58 19.36c22.343 22.343 48.569 49.437 93.55 83.19M459.271 90.321l-.004 45.18M414.094 52.678l-.003 67.764M368.918 45.148l-.004 75.294M190.19 466.8h6.68c33.83 0 67.443 7.218 98.52 21.34a181.996 181.996 0 0 0 75.27 16.3h7.41"
              style="
              stroke-width: 15;
              stroke-linecap: round;
              stroke-linejoin: round;
              stroke-miterlimit: 10;
            " fill="none" stroke="currentColor" stroke-width="15" stroke-linecap="round" stroke-linejoin="round"
              stroke-miterlimit="10" data-original="currentColor" class=""></path>
          <path
              d="M262.08 342.91c33.21-44.164 60.526-70.746 82.76-92.98 5.2-5.2 13.39-5.87 19.36-1.58 10.093 7.263 13.741 20.908 7.99 32.41l-10.66 21.26c-5 9.97 2.26 21.72 13.41 21.72h91.34c12.44 0 22.93 9.84 23.1 22.27.158 12.606-9.983 22.9-22.59 22.9h15.06c12.48 0 22.59 10.12 22.59 22.59 0 12.473-10.117 22.59-22.59 22.59h-22.59c12.48 0 22.59 10.11 22.59 22.59 0 12.473-10.109 22.59-22.59 22.59h-37.64c12.47 0 22.58 10.11 22.58 22.58 0 12.48-10.1 22.59-22.58 22.59h-8.55M421.621 459.271l-45.18-.004M459.264 414.094l-67.765-.003M466.794 368.918l-75.295-.004M45.14 189.19c0 17.692-.27 32.151-4.45 53.45M168.46 261.65c43.491 32.635 69.493 59.133 93.55 83.19 5.2 5.2 5.87 13.39 1.58 19.36-7.263 10.093-20.908 13.741-32.41 7.99l-21.26-10.66c-9.97-5-21.72 2.26-21.72 13.41v91.34c0 12.44-9.84 22.93-22.27 23.1-12.606.158-22.9-9.983-22.9-22.59v15.06c0 12.48-10.12 22.59-22.59 22.59-12.473 0-22.59-10.117-22.59-22.59v-22.59c0 12.48-10.11 22.59-22.59 22.59-12.473 0-22.59-10.109-22.59-22.59v-37.64c0 12.47-10.11 22.58-22.58 22.58-12.48 0-22.59-10.1-22.59-22.58v-50.96c0-25.96 5.56-51.63 16.3-75.27 2.82-6.21 5.37-12.52 7.63-18.92M52.669 421.621l.004-45.18M97.846 459.264l.003-67.765M143.022 466.794l.004-75.295"
              style="
              stroke-width: 15;
              stroke-linecap: round;
              stroke-linejoin: round;
              stroke-miterlimit: 10;
            " fill="none" stroke="currentColor" stroke-width="15" stroke-linecap="round" stroke-linejoin="round"
              stroke-miterlimit="10" data-original="currentColor" class=""></path>
          <path
              d="M250.29 168.46c-33.345 44.438-60.846 71.206-83.19 93.55-5.2 5.2-13.39 5.87-19.36 1.58-10.093-7.263-13.741-20.908-7.99-32.41l10.66-21.26c5-9.97-2.26-21.72-13.41-21.72H45.66c-12.44 0-22.93-9.84-23.1-22.27-.158-12.606 9.983-22.9 22.59-22.9H30.09c-12.48 0-22.59-10.12-22.59-22.59 0-12.473 10.117-22.59 22.59-22.59h22.59c-12.48 0-22.59-10.11-22.59-22.59 0-12.473 10.109-22.59 22.59-22.59h37.64c-12.47 0-22.58-10.11-22.58-22.58 0-12.48 10.1-22.59 22.58-22.59h50.96c25.96 0 51.63 5.56 75.27 16.3a238.158 238.158 0 0 0 98.52 21.34h7.68M90.319 52.669l45.18.004M52.676 97.846l67.765.003M45.146 143.022l75.295.004"
              style="
              stroke-width: 15;
              stroke-linecap: round;
              stroke-linejoin: round;
              stroke-miterlimit: 10;
            " fill="none" stroke="currentColor" stroke-width="15" stroke-linecap="round" stroke-linejoin="round"
              stroke-miterlimit="10" data-original="currentColor"></path>
      </g>
    </svg>
        </div>
    </section>

    <div class="modal fade" id="enrollMatrixModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="matrixTitle"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('user.matrix.store') }}">
                    @csrf
                    <input type="hidden" name="uid" value="">
                    <div class="modal-body">
                        <p>{{ __("Are you sure you want to enroll in this matrix scheme?") }}</p>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="i-btn btn--primary btn--sm">{{ __('Submit') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('script-push')
        <script>
            "use strict";
            $(document).ready(function () {
                $('.enroll-matrix-process').click(function () {
                    const uid = $(this).data('uid');
                    const name = $(this).data('name');

                    $('input[name="uid"]').val(uid);
                    const title = " Join " + name + " Matrix Scheme";
                    $('#matrixTitle').text(title);
                });
            });
        </script>
    @endpush
@endif


