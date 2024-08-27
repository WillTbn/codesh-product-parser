<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthenticateTest extends TestCase
{

    public function test_users_authenticate(): void
    {
        $user = User::factory()->create([
            'email'=>'test@live.com',
            'password' => 'teste123'
        ]);

        $response = $this->post(route('auth', [
            'email' => $user->email,
            'password' => 'teste123',
        ]));
        $response->assertStatus(200)
        ->assertJsonStructure([
            'data',
        ]);
        $this->assertDatabaseHas('personal_access_tokens', [
            'tokenable_id' => $user->id,
            'tokenable_type' => 'App\Models\User',
        ]);
    }
}
