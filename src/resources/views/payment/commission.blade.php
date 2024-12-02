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
                        <div class="row">
                            <div class="col-lg-12">
                                @include('user.partials.matrix.commission', [
                                    'commissions' => $depositCommissions,
                                    'type' => \App\Enums\CommissionType::DEPOSIT->value,
                                    'route' => route('user.payment.commission'),
                                ])
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-4">{{ $depositCommissions->links() }}</div>
            </div>
        </div>
    </div>
@endsection
