<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    // public function test_login_redirija_al_dashboard()
    // {
    //     $user =  User::factory()->create([
    //         'password' => bcrypt($password = 'password')
    //     ]);
    
    //     $response = $this->actingAs($user)->post('/login', [
    //         'email' => $user->email,
    //         'password' => $password
    //     ]);
        
    //     $response->assertRedirect('/dashboard');

    // }

    public function test_usuario_no_logeado_acceda_al_dashboard()
    {
        $response = $this->get('/dashboard');

        $response->assertStatus(302);
        
        $response->assertRedirect('login');
    }
}
