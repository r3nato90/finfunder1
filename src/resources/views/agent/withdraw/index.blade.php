@extends('agent.layouts.main')
@section('panel')
    <section>
        <div class="card">
            <div class="responsive-table">
                <table>
                    <thead>
                        <tr>
                            <th scope="col">{{ __('Initiated At') }}</th>
                            <th scope="col">{{ __('Trx') }}</th>
                            <th scope="col">{{ __('Gateway') }}</th>
                            <th scope="col">{{ __('Amount') }}</th>
                            <th scope="col">{{ __('Charge') }}</th>
                            <th scope="col">{{ __('Final Amount') }}</th>
                            <th scope="col">{{ __('Conversion') }}</th>
                            <th scope="col">{{ __('Status') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($withdrawLogs as $key => $withdrawLog)
                        <tr>
                            <td data-label="{{ __('Initiated At') }}">
                                {{ showDateTime($withdrawLog->created_at) }}
                            </td>
                            <td data-label="{{ __('Trx') }}">
                                {{ $withdrawLog->trx }}
                            </td>
                            <td data-label="{{ __('Gateway') }}">
                                {{ $withdrawLog?->withdrawMethod?->name ?? 'N/A' }}
                            </td>
                            <td data-label="{{ __('Amount') }}">
                                {{ getCurrencySymbol() }}{{ shortAmount($withdrawLog->amount) }}
                            </td>
                            <td data-label="{{ __('Charge') }}">
                                {{ getCurrencySymbol() }}{{ shortAmount($withdrawLog->charge) }}
                            </td>
                            <td data-label="{{ __('Final Amount') }}">
                                {{ getCurrencySymbol() }}{{ shortAmount($withdrawLog->final_amount) }}
                            </td>
                            <td data-label="{{ __('Conversion') }}">
                                {{ getCurrencySymbol() }}1 = {{ shortAmount($withdrawLog->rate) }} {{ $withdrawLog?->withdrawMethod?->currency_name ?? getCurrencyName() }}
                            </td>
                            <td data-label="{{ __('Status') }}">
                                <span class="badge {{ App\Enums\Payment\Withdraw\Status::getColor($withdrawLog->status)}}">{{ App\Enums\Payment\Withdraw\Status::getName($withdrawLog->status)}}</span>
                            </td>
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
            {{ $withdrawLogs->appends(request()->all())->links() }}
        </div>
    </section>
@endsection
