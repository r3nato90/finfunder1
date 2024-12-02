<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MenuRequest;
use App\Services\Menu\MenuService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class MenuController extends Controller
{
    public function __construct(protected MenuService $menuService){

    }

    public function index(): View
    {
        $setTitle = "Manage Pages";
        $paginateByMenus = $this->menuService->getMenuByPaginate();
        $menus = $this->menuService->getMenu();

        return view('admin.menu.index', compact('setTitle', 'menus', 'paginateByMenus'));
    }

    /**
     * @param MenuRequest $request
     * @return RedirectResponse
     */
    public function store(MenuRequest $request): RedirectResponse
    {
        $this->menuService->save($this->menuService->prepParams($request));
        return back()->with('notify', [['success', 'Menu have been added']]);
    }

    /**
     * @param MenuRequest $request
     * @return RedirectResponse
     */
    public function update(MenuRequest $request): RedirectResponse
    {
        $this->menuService->update($request);
        return back()->with('notify', [['success', 'Menu have been updated']]);
    }

    /**
     * @param MenuRequest $request
     * @return RedirectResponse
     */
    public function delete(Request $request): RedirectResponse
    {
        if(!$this->menuService->delete($request)){
            return back()->with('notify', [['error', 'Menu Not found']]);
        }

        return back()->with('notify', [['success', 'Menu have been removed']]);
    }


    /**
     * @param string $url
     * @return View
     */
    public function sectionSortable(string $url): view
    {
        $menu = $this->menuService->findByUrl($url);
        $setTitle = __('Update sections');

        if(!$menu){
            abort(404);
        }

        $sections = collect([
            \App\Enums\Frontend\SectionKey::ABOUT->value,
            \App\Enums\Frontend\SectionKey::ADVERTISE->value,
            \App\Enums\Frontend\SectionKey::BLOG->value,
            \App\Enums\Frontend\SectionKey::CHOOSE_US->value,
            \App\Enums\Frontend\SectionKey::CRYPTO_PAIRS->value,
            \App\Enums\Frontend\SectionKey::CURRENCY_EXCHANGE->value,
            \App\Enums\Frontend\SectionKey::FAQ->value,
            \App\Enums\Frontend\SectionKey::PRICING_PLAN->value,
            \App\Enums\Frontend\SectionKey::MATRIX_PLAN->value,
            \App\Enums\Frontend\SectionKey::PROCESS->value,
            \App\Enums\Frontend\SectionKey::SERVICE->value,
            \App\Enums\Frontend\SectionKey::TESTIMONIAL->value,
            \App\Enums\Frontend\SectionKey::FEATURE->value,
        ]);
        $existingSections = collect($menu->section_key ?? []);
        $sections = $sections->diff($existingSections)->values();

        return view('admin.menu.sections', compact('setTitle', 'menu', 'sections'));
    }


    /**
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function updateSection(Request $request, int $id): Response
    {
        $menu = $this->menuService->findById($id);
        if (!$menu) {
            return response('Menu not found', 404);
        }

        $menu->section_key = $request->input('section_keys');
        $menu->save();

        return response('Menu section has been updated', );
    }



}
