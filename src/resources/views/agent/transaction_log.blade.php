@extends('agent.layouts.main')
@section('panel')
<section>
    <div class="card">
        <div class="responsive-table">
            <table>
                <thead>
                <tr>
                    <th>@lang('Initiated At')</th>
                    <th>@lang('Trx')</th>
                    <th>@lang('Amount')</th>
                    <th>@lang('Post Balance')</th>
                    <th>@lang('Charge')</th>
                    <th>@lang('Details')</th>
                </tr>
                </thead>
                <tbody>
                @forelse($transactions as $transaction)
                    <tr>
                        <td data-label="Initiated At">{{ showDateTime($transaction->created_at) }}</td>
                        <td data-label="Trx">{{ $transaction->trx }}</td>
                        <td data-label="Amount">
                            <span class="text--{{ \App\Enums\Transaction\Type::getTextColor((int)$transaction->type) }}">
                                {{ getCurrencySymbol() }}{{ shortAmount($transaction->amount) }}
                            </span>
                        </td>
                        <td data-label="Post Balance">{{ getCurrencySymbol() }}{{ shortAmount($transaction->post_balance) }}</td>
                        <td data-label="Charge">{{ getCurrencySymbol() }}{{ shortAmount($transaction->charge) }}</td>
                        <td data-label="Details">{{ $transaction->details }}</td>
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
        {{$transactions->appends(request()->all())->links()}}
    </div>
</section>
@endsection
