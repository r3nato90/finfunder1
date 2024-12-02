
 <ul class="{{ $isFirst ? 'firstList' : '' }} sub-menu side-menu-dropdown collapse show">
    @foreach($user->recursiveReferrals as $positionedAbove)
        @if($loop->first)
            @php ++$step @endphp
        @endif
         <li class="sub-menu-item">
            <a class="referral-single-link" href="javascript:void(0)">
                <p class="node-element" type="button" data-bs-toggle="collapse" data-bs-target="#node-ul-{{ $positionedAbove->id }}" aria-expanded="true" aria-controls="node-ul-{{ $positionedAbove->id }}">
                    <span><i class="bi bi-person"></i> {{ $positionedAbove->fullname }}</span> 
                    <span><i class="bi bi-envelope"></i> {{ $positionedAbove->email }}</span>
                    <span><i class="bi bi-activity"></i> {{ __('Referral Pool')}} <i class="bi bi-arrow-right"></i> {{ $positionedAbove->referredUsers->count() }}</span>
                </p>
            @if($positionedAbove->recursiveReferrals->count() > 0 && ($step < \App\Services\Investment\MatrixService::getMatrixHeight()))
                @include('user.partials.tree-view',['user'=> $positionedAbove,'step'=> $step,'isFirst'=>false])
            @endif
        </li>
    @endforeach
</ul>
