<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    protected $model;

    public function __constructor(Content $content)
    {
        $this->model = $content;
    }

    public function save(Request $request)
    {
        $content = Content::create([
            'user_id' => $request->user_id,
            'menu_id' => $request->menu_id,
            'section_name' => $request->section_name,
            'content' => $request->content,
            'status' => false
        ]);

        return $content;
    }

    public function getContents()
    {
        return Content::all();
    }

    public function getContent($content_id)
    {
        return Content::findById($content_id)->first();
    }

    public function getContentByMenu($menu_id)
    {
        return Content::findByMenuId($menu_id)->first();
    }
}
