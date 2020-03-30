<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Model\Menu;
use App\Request\Admin\MenuRequest;
use App\Controller\AbstractController;

class MenuController extends AbstractController
{
    public function index()
    {
        // query parameter
        $state = $this->request->input('state');

        $menus = Menu::query()
            ->when($state, function ($query, $state) {
                return $query->where('state', $state);
            })
            ->orderBy('seq')->orderBy('id')
            ->get()->toArray();

        $menus = array_to_tree($menus, 'id', 'pid');

        return $this->response->success($menus);
    }

    public function save($id, MenuRequest $request)
    {
        $validated = $request->validated();
        if (isset($validated['path'])) {
            $validated['path'] = trim($validated['path'], '/');
        }
        if (isset($validated['icon'])) {
            $validated['icon'] = trim($validated['icon'], 'mdi-');
        }

        if ($id) {
            $menu = Menu::query()->find($id);
        } else {
            $menu = new Menu();
        }
        $menu->fill($validated);
        $result = $menu->save();
        return $this->response->success($result);
    }

    public function get(int $id)
    {
        $menu = Menu::query()->find($id);
        return $this->response->success($menu);
    }

    public function delete($id)
    {
        $result = Menu::destroy($id);
        return $this->response->success($result);
    }
}
