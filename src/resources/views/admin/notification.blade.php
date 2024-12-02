@extends('admin.layouts.main')
@section('panel')
    <section>
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{ $setTitle }}</h4>
            </div>
            <div class="card-body pt-0">
                <div class="notification-items" data-simplebar>
                    <div class="notification-item">
                        <ul class="all-notification-list">
                            @foreach($notifications as $notification)
                                <li class="py-3 px-3">
                                    <a href="{{ getArrayValue($notification->data, 'url') }}">
                                        <div class="notification-item-content">
                                            <h6 class="mb-2 fs-14">{{ getArrayValue($notification->data, 'name') ?? '' }} <small class="primary--light text--muted fw-normal ms-2 py-1 px-2 bg--light rounded-2">{{ diffForHumans($notification->created_at) }}</small></h6>
                                            <p class="text--light">{{ getArrayValue($notification->data, 'message') }}</p>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-4">{{ $notifications->links() }}</div>
    </section>
@endsection
