<?php

namespace Tests\Unit;

use Mail;
use Tests\TestCase;
use App\Models\User;
use App\Models\Support;
use Tests\Helper\Login;
use App\Services\Mail\MailService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SupportTest extends TestCase
{
    use Login;

    public function setUp():void 
    {
        parent::setUp();
    }
    
    public function testSupport()
    {
        Mail::fake();

        $support = factory(Support::class)->make();
        
        // $this->mock(MailService::class)->shouldReceive('sendUserEmail')->once()->andReturn('sent');
        // $this->mock(MailService::class)->shouldReceive('sendAdminContact')->once()->andReturn('sent');

        $this->post('/api/v1/support', $support->toArray())
            ->assertStatus(201);
    }
}
