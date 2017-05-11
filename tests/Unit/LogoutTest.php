<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LogoutTest extends TestCase
{
    public function testLogout()
    {
        $response = $this->withSession(['access_token' => 'access_token', 'user' => 'user'])
            ->get('auth/logout');

        $response->assertStatus(302);
        $response->assertSessionMissing('user');
        $response->assertRedirect(route('auth::error'));
        $response->assertSessionMissing('access_token');
        $response->assertSessionHas('message', 'success logout');
    }
}
