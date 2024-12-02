<?php

namespace App\Services;

use App\Concerns\UploadedFile;
use App\Enums\Frontend\Content;
use App\Enums\Frontend\SectionKey;
use App\Enums\Frontend\SectionName;
use App\Models\Frontend;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class FrontendService
{

    use UploadedFile;

    public static function callBasedOnValues(string $sectionKey, string $content): string
    {
        return $sectionKey.'.'.$content;
    }

    public static function getFrontendSection($default = true)
    {
        $sections = include resource_path('data/frontend_config.php');

        if ($default) {
            ksort($sections['sections']);
        }

        return $sections['sections'] ?? [];
    }


    /**
     * @param SectionKey $sectionKey
     * @param Content $content
     * @param int|null $limit
     * @return mixed
     */
    public static function getFrontendContent(SectionKey $sectionKey, Content $content, ?int $limit = null): mixed
    {
        $key = self::callBasedOnValues($sectionKey->value, $content->value);

        $query = Frontend::where('key', $key);

        if (Str::after($key, '.') == Content::FIXED->value && $limit === null) {
            return $query->first();
        }

        if ($limit !== null) {
            $query->take($limit);
        }

        return $query->get();
    }


    /**
     * @param string $key
     * @return array|null
     */
    public function findBySectionKey(string $key): ?array
    {
        $section = Arr::get(self::getFrontendSection(), $key, null);

        if (blank($section)) {
            return null;
        }

        return $section;
    }


    /**
     * @param int|string $id
     * @return Frontend|null
     */
    public function findById(int|string $id): ?Frontend
    {
        return Frontend::find($id);
    }


    /**
     * @param string $key
     * @return Frontend|null
     */
    public function getFixedContent(string $key): ?Frontend
    {
        return Frontend::where('key', $key.'.'.Content::FIXED->value)->first();
    }

    /**
     * @param string $key
     * @return Collection
     */
    public function getEnhancementContent(string $key): Collection
    {
        return Frontend::where('key', $key.'.'.Content::ENHANCEMENT->value)
            ->get();
    }


    /**
     * @param Request $request
     * @param array|null $sectionImages
     * @return bool|array
     */
    public function processInputs(Request $request, ?array $sectionImages): bool|array
    {
        $inputValue = $this->sanitizeInputs($request->except('_token','content','id','images'));

        if(!is_null($sectionImages)){
            foreach ($sectionImages as $key => $item) {
                $file = $request->file("images.{$key}");
                if ($file && $file->isValid()) {
                    try {
                        Arr::set($inputValue, $key, $this->move($file, getFilePath()));
                    } catch (\Exception $exp) {
                        continue;
                    }
                }
            }
        }

        return $inputValue;
    }


    /**
     * @param array $inputs
     * @return array
     */
    private function sanitizeInputs(array $inputs): array
    {
        $purifier = new \HTMLPurifier();
        $sanitizedInputs = [];
        foreach ($inputs as $keyName => $input) {
            $sanitizedInputs[$keyName] = $input;
        }

        return $sanitizedInputs;
    }


    /**
     * @param Request $request
     * @param array $preparePrams
     * @param string $key
     * @return Frontend
     */
    public function save(Request $request, array $preparePrams, string $key): Frontend
    {
        $frontend = $this->initializeFrontend($request, "{$key}.{$request->input('content')}", $key);

        $configMeta = [];

        if (!is_null($frontend->meta)){
            $configMeta = $frontend->meta;
        }

        $frontend->meta = array_replace_recursive($configMeta, $preparePrams);
        $frontend->save();

        return $frontend;

    }

    /**
     * @param Request $request
     * @param string $key
     * @param string $name
     * @return Frontend
     */
    private function initializeFrontend(Request $request, string $key, string $name): Frontend
    {
        if ($request->input('content') === Content::ENHANCEMENT->value){
            $frontend = Frontend::find($request->input('id'));
            if ($frontend){
                $frontend->name = SectionName::getValue(strtoupper($name));
                $frontend->save();
            }else {
                $frontend = Frontend::create([
                    'key' => $key,
                    'name' => SectionName::getValue(strtoupper($name)),
                ]);
            }
        } else {
            $frontend = Frontend::firstOrNew(['key' => $key]);
            $frontend->name = SectionName::getValue(strtoupper($name));
            $frontend->save();
        }

        return $frontend;
    }

}
