
    <div class="card mb-3">
        <div class="card-header">
            <h4 class="card-title">{{ __($setTitle) }}</h4>
            @if(isset($section[\App\Enums\Frontend\Content::ENHANCEMENT->value]))
                <a href="{{route('admin.frontend.section.content',$key)}}" class="i-btn btn--primary btn--sm">
                    <i class="las la-plus"></i>
                    @lang('Add New')
                </a>
            @endif
        </div>
        
        
        @if(isset($section[$content_type]))
            <div class="card-body">
                <form action="{{route('admin.frontend.section.save', $key)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="content" value="{{$content_type}}">
    
                    @if($content)
                        <input type="hidden" name="id" value="{{$content->id}}">
                    @endif
    
                    <div class="row g-3 mb-3">
                        @foreach($section[$content_type] as $key => $item)
                            @if($key == 'images')
                                @include('admin.frontend.upload_inputs', ['item' => $item, 'key' => $key, 'content' => $content])
                            @else
                                @include('admin.frontend.standard_inputs',['item' => $item, 'key' => $key, 'content' => $content])
                            @endif
                        @endforeach
                    </div>
                    <button type="submit" class="i-btn btn--primary btn--md">{{ __("admin.button.save")}}</button>
                </form>
            </div>
        @endif
    </div>

