@php
    $textValue = \App\Enums\Frontend\InputField::TEXT->value;
    $iconValue = \App\Enums\Frontend\InputField::ICON->value;
    $imagesValue = Illuminate\Support\Arr::has($section, $content_type.'.images');
    $images = null;
    if($imagesValue){
        $images = array_keys(Illuminate\Support\Arr::get($section, $content_type.'.images'));
    }
@endphp


@if (isset($section[$content_type]))
    <div class="card mt-4">
        <div class="card-header">
            <h4 class="card-title">{{ __('Enhancement Contents') }}</h4>
        </div>
        <div class="responsive-table">
            <table>
                <thead>
                    <tr>
                        <th>{{ __('#') }}</th>
                        @if ($imagesValue)
                            @foreach($images as $key => $image)
                                <th>{{ __(replaceInputTitle($image ?? '')) }}</th>
                            @endforeach
                        @endif
                        @foreach ($section[$content_type] as $key => $item)
                            @if (in_array($item, [$textValue, $iconValue]))
                                <th>{{ __(replaceInputTitle($key)) }}</th>
                            @endif
                        @endforeach
                        <th>{{ __('admin.table.action') }}</th>
                    </tr>
                </thead>
                @forelse ($contents as $content)
                    <tr class="{{ $loop->even }}">
                        <td data-label="{{ __('admin.table.name') }}">{{ $loop->iteration }}</td>
                        @if ($imagesValue)
                            @foreach($images as $key => $image)
                                <td data-label="{{ __('admin.input.image') }}">
                                    @if(isset($content->meta[$image]))
                                        <img src="{{ displayImage($content->meta[$image]) }}" class="avatar--md" alt="{{ __($image) }}">
                                    @endif
                                </td>
                            @endforeach
                        @endif
                        @foreach ($section[$content_type] as $key => $item)
                            @if (in_array($item, [$textValue, $iconValue]))
                                <td data-label="{{ __(replaceInputTitle($key)) }}">
                                    {{ $content->meta[$key] ?? '' }}
                                </td>
                            @endif
                        @endforeach

                        <td data-label="{{ __('Action') }}">
                            <div class="d-flex align-items-center justify-content-md-start justify-content-end gap-3">
                                <a href="{{ route('admin.frontend.section.content', [$section_key, $content->id]) }}" class="badge badge--primary-transparent"><i class="la la-pencil-alt"></i></a>
                                <a href="javascript:void(0)" class="badge badge--danger-transparent remove-element"
                                   data-bs-toggle="modal"
                                   data-bs-target="#delete-element"
                                   data-id="{{ $content->id }}"
                                ><i class="las la-trash"></i></a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-muted text-center" colspan="100%">{{ __('No Data Found') }}</td>
                    </tr>
                @endforelse
            </table>
        </div>
    </div>
@endif
