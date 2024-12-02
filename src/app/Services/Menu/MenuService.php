<?php

namespace App\Services\Menu;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Pagination\AbstractPaginator;

class MenuService
{
    /**
     * @param int|string $id
     * @return Menu|null
     */
    public function findById(int|string $id): ?Menu
    {
        return Menu::find($id);
    }


    /**
     * @param string $url
     * @return Menu|null
     */
    public function findByUrl(string $url): ?Menu
    {
        return Menu::where('url', $url)->first();
    }

    public function getMenu()
    {
        return Menu::get();
    }

    /**
     * @return AbstractPaginator
     */
    public function getMenuByPaginate(): AbstractPaginator
    {
        return Menu::paginate(getPaginate());
    }

    /**
     * @param Request $request
     * @return array
     */
    public function prepParams(Request $request): array
    {
        return [
            'name' => $request->input('name'),
            'url' => slug($request->input('url')),
            'parent_id' => $request->input('parent_id', null),
            'section_keys' => null,
        ];
    }

    /**
     * @param array $params
     * @return Menu
     */
    public function save(array $params): Menu
    {
        return Menu::create($params);
    }

    /**
     * @param Request $request
     * @return Menu|null
     */
    public function update(Request $request): ?Menu
    {
        $menu = $this->findById($request->integer('id'));

        if(is_null($menu)){
            return null;
        }

        $menu->update($this->prepParams($request));

        return $menu;
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function delete(Request $request): bool
    {
        $menu = $this->findById($request->integer('id'));

        if(is_null($menu)){
            return false;
        }

        $parentMenus = Menu::where('parent_id', $menu->id)->get();
        $parentMenus->each(function ($parentMenu) {
            $parentMenu->delete();
        });

        $menu->delete();

        return true;
    }



}
