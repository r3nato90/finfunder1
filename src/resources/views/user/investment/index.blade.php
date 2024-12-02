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
                        @include('user.partials.investment.plan')
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('user.partials.investment.plan_modal')
@endsection


