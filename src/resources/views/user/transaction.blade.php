@extends('layouts.user')
@section('content')
    <div class="main-content" data-simplebar>
        <div class="row">
            <div class="col-lg-12">
                <div class="i-card-sm mb-4">
                    <div class="card-header">
                        <h4 class="title">{{ __($setTitle) }}</h4>
                    </div>
                    @include('user.partials.transaction', ['transactions' => $transactions, 'is_paginate' => true])
                </div>
            </div>
        </div>
    </div>
@endsection
