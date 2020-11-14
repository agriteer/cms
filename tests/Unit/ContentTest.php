<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Content;
use Tests\Helper\Login;
use App\Services\Mail\MailService;

class ContentTest extends TestCase
{
    use Login;

    public function setUp():void 
    {
        parent::setUp();
    }
    
    public function testCreateContent()
    {
        $content = factory(Content::class)->make()->toArray();

        $this->post('/api/v1/content', $content)
            ->assertStatus(201);
    }
    
    public function testGetContents()
    {
        factory(Content::class, 5)->create();

        $this->get('/api/v1/contents')
            ->assertStatus(200);
    }
    
    public function testGetMenu()
    {
        $content = factory(Content::class)->create();

        $this->get('/api/v1/content/'. $content->id)
            ->assertStatus(200);
    }
    
    public function testUpdateContent()
    {
        $content = factory(Content::class)->create();

        $newContent = [
            'user_id' => $content->user_id,
            'menu_id' => $content->menu_id,
            'section_name' => $content->section_name,
            'content' => 'New content updated',
            'status' => true
        ];

        $this->put('/api/v1/content/'. $content->id, $newContent)
            ->assertStatus(200);
    }
}
