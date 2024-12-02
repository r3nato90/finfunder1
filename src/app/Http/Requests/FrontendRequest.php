<?php

namespace App\Http\Requests;

use App\Enums\Frontend\Content;
use App\Http\Controllers\Admin\FrontendController;
use App\Services\FrontendService;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FrontendRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        $section = $this->fetchSectionImage();

        return [
            'content' => ['required', Rule::in(Content::values())],
            ...$this->prepareValidationRules($section),
        ];
    }

    /**
     * @return array|null
     */
    private function fetchSectionImage(): ?array
    {
        $frontendService = new FrontendService();
        return $frontendService->findBySectionKey("{$this->route('key')}.{$this->input('content')}.images");
    }

    /**
     * @param array|null $sectionImage
     * @return array
     */
    private function prepareValidationRules(?array $sectionImage): array
    {
        $validationRules = [];

        foreach ($this->except('_token') as $input => $val) {

            if ($input === 'images' && $sectionImage) {
                foreach ($sectionImage as $key => $imageValue) {
                    $validationRules["images.{$key}"] = ['nullable', 'image'];
                }
            } else {
                $validationRules[$input] = 'required';
            }
        }

        return $validationRules;
    }
}
