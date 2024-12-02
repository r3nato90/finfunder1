@extends('agent.layouts.main')
@section('panel')
    <div class="container-fluid px-0">
        <div class="row g-4">
            <h5>Current Balance: {{ getCurrencySymbol() }}{{ shortAmount(auth()->guard('agent')->user()->balance) }}</h5>
            <div class="col-12">
                <div class="card p-3">
                    <label for="referral-url" class="form-label">{{ __('Referral URL') }}</label>
                    <div class="input-group">
                        <input type="text" id="referral-url" class="form-control reference-url" value="{{ route('home', ['reference' => auth()->guard('agent')->user()->uuid]) }}" aria-label="Recipient's username" aria-describedby="reference-copy" readonly>
                        <span class="input-group-text bg-primary text-white" id="reference-copy">{{ __('Copy') }}<i class="las la-copy ms-2"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>{{ __('Agent Investment Commission Setting: If you refer someone and their investment is completed, you will receive a commission based on the parameters set below. ') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <h5 class="mb-3">{{ __('Fixed & Percentage Commission Settings') }}</h5>

                            <div class="col-lg-6 mb-3">
                                <h6 class="fw-semibold">{{ __('Fixed Commission Status') }}</h6>
                                <p class="border p-3 rounded bg-light">{{ \App\Enums\Status::getName(getArrayValue($setting->agent_investment_commission,'fixed_commission.status')) }}</p>
                            </div>

                            <!-- Fixed Amount -->
                            <div class="col-lg-6 mb-3">
                                <h6 class="fw-semibold">{{ __('Fixed Amount') }}</h6>
                                <p class="border p-3 rounded bg-light">{{ getCurrencySymbol() }}{{ getArrayValue($setting->agent_investment_commission,'fixed_commission.bonus') }}</p> <!-- Replace with dynamic content -->
                            </div>

                            <!-- Percentage Commission Status -->
                            <div class="col-lg-6 mb-3">
                                <h6 class="fw-semibold">{{ __('Percentage Commission Status') }}</h6>
                                <p class="border p-3 rounded bg-light">{{ \App\Enums\Status::getName(getArrayValue($setting->agent_investment_commission,'percentage_commission.status')) }}</p> <!-- Replace 'Active' with dynamic content -->
                            </div>

                            <!-- Percentage Commission -->
                            <div class="col-lg-6 mb-3">
                                <h6 class="fw-semibold">{{ __('Percentage Commission') }}</h6>
                                <p class="border p-3 rounded bg-light">{{ getArrayValue($setting->agent_investment_commission,'percentage_commission.bonus') }}%</p> <!-- Replace with dynamic content -->
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <h5 class="mb-3">{{ __('Performance-Based Commission Settings') }}</h5>

                            <!-- Performance Threshold Status -->
                            <div class="col-lg-4 mb-3">
                                <h6 class="fw-semibold">{{ __('Performance Threshold Status') }}</h6>
                                <p class="border p-3 rounded bg-light">{{ \App\Enums\Status::getName(getArrayValue($setting->agent_investment_commission,'performance_based_commission.status')) }}</p> <!-- Replace 'Active' with dynamic content -->
                            </div>

                            <!-- Performance Threshold Amount -->
                            <div class="col-lg-4 mb-3">
                                <h6 class="fw-semibold">{{ __('Performance Threshold Amount') }}</h6>
                                <p class="border p-3 rounded bg-light">{{ getCurrencySymbol() }}{{ getArrayValue($setting->agent_investment_commission,'performance_based_commission.threshold') }}</p> <!-- Replace with dynamic content -->
                            </div>

                            <!-- Performance Bonus -->
                            <div class="col-lg-4 mb-3">
                                <h6 class="fw-semibold">{{ __('Performance Bonus') }}</h6>
                                <p class="border p-3 rounded bg-light">{{ getCurrencySymbol() }}{{ getArrayValue($setting->agent_investment_commission,'performance_based_commission.bonus') }}</p> <!-- Replace with dynamic content -->
                            </div>
                        </div>

                        <hr>

                        <!-- Monthly-Team Commission Settings -->
                        <div class="row">
                            <h5 class="mb-3">{{ __('Monthly Team Investment Commission Settings') }}</h5>

                            <!-- Monthly Team Investment Status -->
                            <div class="col-lg-4 mb-3">
                                <h6 class="fw-semibold">{{ __('Monthly Commission Status') }}</h6>
                                <p class="border p-3 rounded bg-light">{{ \App\Enums\Status::getName(getArrayValue($setting->agent_investment_commission,'monthly_team_investment_commission.status')) }}</p> <!-- Replace 'Active' with dynamic content -->
                            </div>

                            <!-- Monthly Team Investment Amount -->
                            <div class="col-lg-4 mb-3">
                                <h6 class="fw-semibold">{{ __('Monthly Team Investment Amount') }}</h6>
                                <p class="border p-3 rounded bg-light">{{ getCurrencySymbol() }}{{ getArrayValue($setting->agent_investment_commission,'monthly_team_investment_commission.monthly_team_investment') }}</p>
                            </div>

                            <!-- Monthly Team Investment Bonus -->
                            <div class="col-lg-4 mb-3">
                                <h6 class="fw-semibold">{{ __('Monthly Bonus') }}</h6>
                                <p class="border p-3 rounded bg-light">{{ getCurrencySymbol() }}{{ getArrayValue($setting->agent_investment_commission,'monthly_team_investment_commission.bonus') }}</p> <!-- Replace with dynamic content -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('admin.report.statistics.investment.five') }}</h4>
                    </div>
                    <div class="card-body">
                        <div id="investProfitChart" class="charts-height"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script-push')
    <script>
        "use strict";
        $(document).ready(function () {
            const months = @json($months);
            const currency = "{{ getCurrencySymbol() }}";
            const invest = @json($invest);

            const investmentOptions = {
                series: [{
                    name: 'Invest',
                    data: invest
                }],
                chart: {
                    height: 265,
                    type: 'line',
                    zoom: {
                        enabled: false
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth'
                },
                xaxis: {
                    type: 'date',
                    categories: months
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return currency + val
                        }
                    }
                }
            };

            const investmentProfit = new ApexCharts(document.querySelector("#investProfitChart"), investmentOptions);
            investmentProfit.render();

            // Right Sidebar
            let rightSidebarBtn = document.getElementById('right-sidebar-btn');
            const rightSidebar = document.querySelector(".right-sidebar");
            const minWidth = 1499;

            function handleSidebarButtonClick() {
                rightSidebar.classList.toggle("d-none");
                const windowWidth = window.innerWidth;
                const sidebarVisible = !rightSidebar.classList.contains("d-none");

                if (windowWidth <= minWidth && sidebarVisible) {
                    createOverlay();
                } else {
                    removeOverlay();
                }
            }

            function createOverlay() {
                const overlay = document.createElement('div');
                overlay.setAttribute("id", "overlay-wrapper");

                overlay.style.cssText = `
                    position: fixed;
                    inset: 0;
                    width: 100%;
                    height: 100vh;
                    background: rgb(0 0 0 / 10%);
                    z-index: 12;
                `;
                document.body.appendChild(overlay);

                overlay.addEventListener("click", () => {
                    rightSidebar.classList.add('d-none');
                    removeOverlay();
                });
            }

            function removeOverlay() {
                const overlayWrapper = document.querySelector("#overlay-wrapper")
                overlayWrapper && overlayWrapper.remove();
            }

            function handleResize() {
                const windowWidth = window.innerWidth;
                if (windowWidth <= 1499) {
                    rightSidebar.classList.remove("d-none")
                    createOverlay();
                } else {
                    rightSidebar.classList.remove("d-none")
                    removeOverlay();
                }
            }

            rightSidebarBtn.addEventListener("click", handleSidebarButtonClick);
            window.addEventListener('resize', handleResize);
            handleResize();

            rightSidebarBtn = $('.right-sidebar-btn');
            if (rightSidebarBtn.length) {
                rightSidebarBtn.click();
            }
        });


        $('#reference-copy').click(function() {
            const copyText = $('.reference-url');
            copyText.select();
            document.execCommand('copy');
            copyText.blur();
            notify('success', 'Copied to clipboard!');
        });
    </script>
@endpush
