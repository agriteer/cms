<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Menu;
use Tests\Helper\Login;
use App\Services\Mail\MailService;

class MenuTest extends TestCase
{
    use Login;

    public function setUp():void 
    {
        parent::setUp();
    }
    
    public function testCreatemenu()
    {
        $menu = factory(Menu::class)->make()->toArray();

        $this->post('/api/v1/menus', $menu)
            ->assertStatus(201);
    }
    
    public function testGetMenus()
    {
        factory(Menu::class, 5)->create();

        $this->get('/api/v1/menus')
            ->assertStatus(200);
    }
    
    public function testGetMenu()
    {
        $menu = factory(Menu::class)->create();

        $this->get('/api/v1/menu/'. $menu['id'])
            ->assertStatus(200);
    }
    
    public function testUpdateMenu()
    {
        $menu = factory(Menu::class)->create();

        $newMenu = [
            'user_id' => $menu->user_id,
            'name' => 'New Menu',
            'status' => true
        ];

        $this->put('/api/v1/menu/'. $menu['id'], $newMenu)
            ->assertStatus(200);
    }
}
