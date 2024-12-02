@php
    $enhancementContents = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::PROCESS, \App\Enums\Frontend\Content::ENHANCEMENT);
@endphp

<div class="process-section bg-color pt-110 pb-110" id="process">
    <div class="container">
        <div class="row g-0">
            @foreach($enhancementContents as $key => $enhancementContent)
                <div class="col-xl-4 col-lg-4">
                    <div class="process-item">
                        <span class="serial">{{ $loop->iteration }}</span>
                        <div class="icon">
                            @php echo getArrayValue($enhancementContent->meta, 'icon') @endphp
                        </div>
                        <div class="content">
                            <h4>{{ getArrayValue($enhancementContent->meta, 'title') }}</h4>
                            <p>{{ getArrayValue($enhancementContent->meta, 'details') }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
