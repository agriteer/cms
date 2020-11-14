<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
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

    public function updateMenu($id, Request $request)
    {
        $menu = Menu::find($id);

        $menu->name = $request->name;
        $menu->status = $request->status;
        $menu->save();
        
        return $menu;
    }
}
