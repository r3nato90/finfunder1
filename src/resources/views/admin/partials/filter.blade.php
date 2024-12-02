<h3 class="page-title">{{__($setTitle)}}</h3>
@if($is_filter)
    <div class="filter-wrapper">
        <div class="card-filter">
            <form action="{{ $route }}" method="GET">
                <div class="filter-form">
                    @foreach($filters as $filter)
                        @if(getArrayValue($filter, 'type') == \App\Enums\FilterType::SELECT_OPTIONS->value)
                            <div class="filter-item">
                                <select name="{{ getArrayValue($filter, 'name')  }}" class="form-select" id="{{ getArrayValue($filter, 'name')  }}">
                                    <option value="">{{ __('admin.filter.placeholder.select') }}</option>
                                    @foreach($filter['value'] ?? [] as $key => $option)
                                        <option value="{{ $key }}" @if((int)request(getArrayValue($filter, 'name')) == $key) selected @endif>{{ replaceInputTitle($option) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @elseif(getArrayValue($filter, 'type') == \App\Enums\FilterType::TEXT->value)
                            <div class="filter-item">
                                <input type="text" name="{{ getArrayValue($filter, 'name')  }}" placeholder="{{ getArrayValue($filter, 'placeholder') }}" class="form-control" id="{{ getArrayValue($filter, 'name')  }}" value="{{request(getArrayValue($filter, 'name'))}}">
                            </div>
                        @elseif(getArrayValue($filter, 'type') == \App\Enums\FilterType::DATE_RANGE->value)
                            <div class="filter-item">
                                <input type="text" id="{{ getArrayValue($filter, 'name') }}" class="form-control datepicker-here" name="{{ getArrayValue($filter, 'name') }}"
                                   value="{{request(getArrayValue($filter, 'name'))}}" data-range="true" data-multiple-dates-separator=" - "
                                   data-language="en" data-position="bottom right" autocomplete="off"
                                   placeholder="{{ getArrayValue($filter, 'placeholder') }}">
                            </div>
                        @endif
                    @endforeach
                    <button class="i-btn btn--primary btn--md" type="submit">
                        <i class="fas fa-search"></i> {{ $btn_name }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endif

@if($is_modal)
    <div class="filter-action">
        @foreach($urls ?? [] as $navigation)
            @if(getArrayValue($navigation, 'type') == 'modal')
                <button type="button" data-bs-toggle="modal" data-bs-target="#{{ getArrayValue($navigation, 'id') }}"
                        class="i-btn btn--dark btn--md">@php echo getArrayValue($navigation, 'icon')  @endphp {{ getArrayValue($navigation, 'name') }}
                </button>
            @else
                <a href="{{ getArrayValue($navigation, 'url')  }}" class="i-btn btn--primary btn--md">@php echo getArrayValue($navigation, 'icon')  @endphp {{ getArrayValue($navigation, 'name') }} </a>
            @endif
        @endforeach
    </div>
@endif
