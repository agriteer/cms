<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    protected $model;

    public function __constructor(Menu $content)
    {
        $this->model = $content;
    }

    public function save(Request $request)
    {
        $content = Menu::create([
            'user_id' => $request->user_id,
            'name' => $request->name,
            'status' => false
        ]);

        return $content;
    }

    public function getMenus()
    {
        return Menu::with('content')->get();
    }

    public function getMenu($menu_id)
    {
        return Menu::with('content')->find(['menu_id' => $menu_id])->first();
    }
}
