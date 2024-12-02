@extends('agent.layouts.main')
@section('panel')
    <section>
        <div class="card">
            <div class="responsive-table">
                <table>
                    <thead>
                        <tr>
                            <th>@lang('Initiated At')</th>
                            <th>@lang('TRX')</th>
                            <th>@lang('User')</th>
                            <th>@lang('Plan')</th>
                            <th>@lang('Amount')</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($investmentLogs as $investmentLog)
                        <tr>
                            <td data-label="Initiated At">{{ showDateTime($investmentLog->created_at) }}</td>
                            <td data-label="TRX">{{ $investmentLog->trx }}</td>
                            <td data-label="User">{{ $investmentLog->user->fullname ?? '' }}</td>
                            <td data-label="Plan">{{ $investmentLog->plan->name }}</td>
                            <td data-label="Amount">{{ getCurrencySymbol() }}{{shortAmount($investmentLog->amount) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-muted text-center" colspan="100%">{{ __('No Data Found')}}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-4">
            {{ $investmentLogs->appends(request()->all())->links() }}
        </div>
    </section>
@endsection
