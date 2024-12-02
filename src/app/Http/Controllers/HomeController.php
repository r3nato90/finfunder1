<?php
namespace App\Http\Controllers;

use App\Enums\Frontend\SectionKey;
use App\Enums\Frontend\SectionName;
use App\Enums\Status;
use App\Models\Contact;
use App\Models\CryptoCurrency;
use App\Models\Language;
use App\Models\Menu;
use App\Models\Subscriber;
use App\Services\FrontendService;
use App\Services\SettingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use InvalidArgumentException;
use Illuminate\Support\Arr;

class HomeController extends Controller
{
    protected string $activeTheme;

    public function __construct(protected FrontendService $frontendService)
    {
        $setting = SettingService::getSetting();
        if ($setting) {
            $theme = $setting->theme_template_setting;
            $this->activeTheme = getArrayValue($theme, 'currently_active', 'default_theme') ?? 'default_theme';
        } else {
            $this->activeTheme = 'default_theme';
        }
    }

    public function index(): View
    {
        $setTitle = "Trading for everyone";

        if (\request()->query('reference')) {
            session()->put('reference_uuid', \request()->query('reference'));
        }

        return view("{$this->activeTheme}.index", compact('setTitle'));
    }


    public function trade(): View
    {
        $setTitle = "Trade Overview";
        $cryptos =  CryptoCurrency::where('status', Status::ACTIVE->value)->paginate(getPaginate());
        $topGainers = CryptoCurrency::where('status', Status::ACTIVE->value)->whereNotNull('top_gainer')->orderBy('top_gainer', 'ASC')->get();
        $topLosers = CryptoCurrency::where('status', Status::ACTIVE->value)->whereNotNull('top_loser')->orderBy('top_loser', 'ASC')->get();

        return view("{$this->activeTheme}.coin", compact(
            'setTitle',
            'cryptos',
            'topGainers',
            'topLosers'
        ));
    }


    public function page(string $url): View
    {
        $setTitle = ucfirst(str_replace(' ', '-', $url));
        $page = Menu::where('url', $url)->firstOrFail();

        return view("{$this->activeTheme}.page", compact(
            'setTitle',
            'page'
        ));
    }

    /**
     * @return View
     */
    public function contact(): View
    {
        $setTitle = "Contact";
        $fixedContent = FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::CONTACT, \App\Enums\Frontend\Content::FIXED);

        return view("{$this->activeTheme}.contact", compact(
            'setTitle',
            'fixedContent',
        ));
    }


    public function languageChange(?string $code = null): Response
    {
        $languageCode = 'en';
        if ($code) {
            $language = Language::where('code', $code)->first();

            if ($language) {
                $languageCode = $language->code;
            }
        }

        Session::put('lang', $languageCode);
        return response(['message' => 'Language changed successfully']);
    }


    public function blogDetail($id): View
    {
        $setTitle = "Blog Details";
        $content = $this->frontendService->findById($id);
        $recentPosts = $this->frontendService->getEnhancementContent(SectionKey::BLOG->value);

        if(!$content || $content->name != SectionName::BLOG->value){
            abort(404);
        }

        return view("{$this->activeTheme}.blog_detail", compact(
            'setTitle',
            'content',
            'recentPosts'
        ));
    }


    public function subscribe(Request $request): Response
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:subscribers,email',
        ]);

        if ($validator->fails()) {
            return response([
                'error' => $validator->errors()->first()
            ], 422);
        }

        Subscriber::create([
            'email' => $request->input('email')
        ]);


        return response(['success' => 'Subscribed Successfully']);
    }


    public function contactStore(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
            'subject' => ['required'],
            'message' => ['required'],
        ]);

        Contact::create([
            'email' => $request->input('email'),
            'subject' => $request->input('subject'),
            'message' => $request->input('message'),
        ]);

        return back()->with('notify', [['success', __('Contact has been submitted')]]);

    }


    public function policy(string $name, string|int $id): View
    {

        $content = $this->frontendService->findById($id);
        $setTitle = Arr::get($content?->meta, 'name', 'Page');

        return view("{$this->activeTheme}.policy", compact(
            'setTitle',
            'content',
        ));
    }

    public function defaultImageCreate(string $size = null): void
    {
        if ($size === null) {
            throw new InvalidArgumentException("Size parameter is required");
        }

        list($width, $height) = explode('x', $size);
        $image = imagecreatetruecolor($width, $height);
        $fontFile = realpath('assets/font') . DIRECTORY_SEPARATOR . 'RobotoMono-Regular.ttf';

        $fontSize = ($width > 100 && $height > 100) ? 30 : 5;
        $text = "$width" . 'X' . "$height";
        $backgroundColor = imagecolorallocate($image, 237, 241, 250);
        $textColor = imagecolorallocate($image, 107, 111, 130);
        imagefilledrectangle($image, 0, 0, $width - 1, $height - 1, $backgroundColor);
        $textSize = imagettfbbox($fontSize, 0, $fontFile, $text);
        $textWidth = $textSize[2] - $textSize[0];
        $textHeight = $textSize[1] - $textSize[7];
        $x = ($width - $textWidth) / 2;
        $y = ($height + $textHeight) / 2;
        header('Content-Type: image/jpeg');
        imagettftext($image, $fontSize, 0, $x, $y, $textColor, $fontFile, $text);
        imagejpeg($image);
        imagedestroy($image);
    }

}
