<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{

    public function test_pagina_login_tenga_boton_con_texto_ingresar()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);

        $response->assertSee('Ingresar');
    }
}
