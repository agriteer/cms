<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Tests\Helper\Login;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use Login;

    public function setUp():void 
    {
        parent::setUp();
    }
    
    public function testRegisterUser()
    {
        $user = \factory(User::class)->make()->toArray();

        $this->post('/api/v1/register', $user)
            ->assertStatus(201);
    }
}
