<div class="form-wrapper bg--light">
    <h5 class="mb-2"> {{__($title)}}</h5>
    <div class="row g-4">
        <div class="col-xl-10 col-lg-9 col-md-8 col-sm-12">
            {{ __($details)}}
        </div>

        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-12">
            <a href="javascript:void(0)" class="i-btn btn--primary btn--md border-0 rounded new-data w-100"><i class="las la-plus"></i>  {{ __('Add New')}}</a>
        </div>
    </div>

    @if(!is_null($parameter))
        @foreach($parameter as $key => $value)
            <div class="row remove-field my-2 g-3 align-items-center">
                <div class="mb-3 col-lg-5">
                    <input name="field_name[]" class="form-control" value="{{ getArrayValue($value, 'field_label') }}" type="text" placeholder=" {{ __('Field Name')}}">
                </div>

                <div class="mb-3 col-lg-5">
                    <select name="field_type[]" class="form-select">
                        <option value="text" @if(getArrayValue($value, 'field_type') == "text") selected @endif>{{ __('Input Text')}}</option>
                        <option value="text" @if(getArrayValue($value, 'field_type') == "file") selected @endif>{{ __('File')}}</option>
                        <option value="textarea" @if(getArrayValue($value, 'field_type') == "textarea") selected @endif> {{ __('Textarea')}} </option>
                    </select>
                </div>

                <div class="col-lg-2 col-md-12 mt-md-0 mt-2 text-right">
                    <span class="input-group-btn">
                        <button class="i-btn btn--danger btn--md text--white removeBtn w-100" type="button">
                            <i class="las la-times"></i>
                        </button>
                    </span>
                </div>
            </div>
        @endforeach
    @endif
    <div class="payment-gateway-information-add"></div>
</div>

@push('script-push')
    <script>
        "use strict";
        $(document).ready(function () {
            $('.new-data').on('click', function(){
                const html = `
		        <div class="row remove-field my-2">
		    		<div class="mb-3 col-lg-5">
						<input name="field_name[]" class="form-control" type="text" required placeholder=" {{ __('Field Name')}}">
					</div>

					<div class="mb-3 col-lg-5">
						<select name="field_type[]" class="form-control">
	                        <option value="text" >  {{ __('Input Text')}} </option>
	                        <option value="file" >  {{ __('File')}} </option>
	                        <option value="textarea" > {{ __('Textarea')}} </option>
	                    </select>
					</div>

		    		<div class="col-lg-2 col-md-12 mt-md-0 mt-2 text-right">
		                <span class="input-group-btn">
		                    <button class="i-btn btn--danger btn--md text--white removeBtn w-100" type="button">
		                        <i class="las la-times"></i>
		                    </button>
		                </span>
		            </div>
		        </div>`;
                $('.payment-gateway-information-add').append(html);
            });

            $(document).on('click', '.removeBtn', function () {
                $(this).closest('.remove-field').remove();
            });
        });
    </script>
@endpush
