<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Testing\File;
use Spatie\Permission\Models\Role;
use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class PostTest extends TestCase
{
    use RefreshDatabase;
    // use WithoutMiddleware;

    private User $user;
    private Role $rolAdministrador;
    private Role $rolEditor;
    private Role $rolLector;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = $this->crearUsuario();
        $this->rolAdministrador = $this->crearRolAdministrador();
        $this->rolEditor = $this->crearRolEditor();
        $this->rolLector = $this->crearRolLector();
    }

    private function crearUsuario(): User
    {
        return User::factory()->create();
    }

    private function crearRolAdministrador(): Role
    {
        return Role::create(['name' => 'Administrador']);
    }

    private function crearRolEditor(): Role
    {
        return Role::create(['name' => 'Editor']);
    }

    private function crearRolLector(): Role
    {
        return Role::create(['name' => 'Lector']);
    }

    public function test_pagina_post_tenga_la_tabla_vacia()
    {
        $response = $this->actingAs($this->user)->get('/post');

        $response->assertStatus(200);

        $response->assertSee('Sin registros');
    }

    public function test_pagina_post_no_tenga_la_tabla_vacia()
    {
        
        Post::withoutEvents(function () {

            $user = User::factory()->create();
            
            $post = Post::factory()->state(['creado_por' => $this->user->id])->create();

            $response = $this->actingAs($this->user)->get('/post');

            $response->assertStatus(200);

            $response->assertViewHas('posts', function($collection) use($post)
            {
                return $collection->contains($post);
            });

        });
    }

    public function test_usuario_con_rol_admin_pueda_ver_boton_crear_en_pagina_post()
    {

        $admin = $this->user->assignRole($this->rolAdministrador->name);

        $response = $this->actingAs($admin)->get('/post');

        $response->assertStatus(200);

        $response->assertSee('Crear nuevo Post');

    }

    public function test_usuario_con_rol_admin_pueda_ver_boton_eliminar_en_pagina_post()
    {
        
        Post::withoutEvents(function ()
        {
            
            $admin = $this->user->assignRole($this->rolAdministrador->name);

            Post::factory()->state(['creado_por' => $this->user->id])->create();

            $response = $this->actingAs($admin)->get('/post');
            
            $response->assertStatus(200);

            $response->assertSee('Eliminar Post');

        });

    }

    public function test_usuario_con_rol_admin_pueda_ver_boton_editar_en_pagina_post()
    {
        
        Post::withoutEvents(function ()
        {
            
            $admin = $this->user->assignRole($this->rolAdministrador->name);

            Post::factory()->state(['creado_por' => $this->user->id])->create();

            $response = $this->actingAs($admin)->get('/post');
            
            $response->assertStatus(200);

            $response->assertSee('Editar Post');

        });

    }

    public function test_usuario_con_rol_lector_no_pueda_ver_boton_crear_en_pagina_post()
    {
        
        $lector = $this->user->assignRole($this->rolLector->name);

        $response = $this->actingAs($lector)->get('/post');
        
        $response->assertStatus(200);

        $response->assertDontSee('Crear nuevo Post');

    }

    public function test_usuario_con_rol_lector_no_pueda_ingresa_a_pagina_de_crear_post()
    {
        
        $lector = $this->user->assignRole($this->rolLector->name);

        $response = $this->actingAs($lector)->get('/post/create');
        
        $response->assertStatus(403);

    }

    public function test_crear_post_con_exito()
    {
        Post::withoutEvents(function ()
        {

            $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);

            $admin = $this->user->assignRole($this->rolAdministrador->name);

            $file = File::create('test.png', 100);

            $post = [
                'nombre' => 'Post Nombre Desde Test',
                'descripcion' => 'Post descripcion desde test',
                'post_file' => [$file],
            ];
    
            $response = $this->actingAs($admin)->post('/post', $post);

            $response->assertStatus(302);

            $response->assertRedirect('/post/create');

            $response->assertSessionHas('success', 'Post creado exitosamente.');

            $this->assertDatabaseHas('posts', Arr::except($post, ['post_file']));

            $ultimoPost = Post::orderBy('id', 'desc')->first();

            $this->assertEquals($post['nombre'], $ultimoPost->nombre);
            $this->assertEquals(Str::slug($post['nombre'], '-'), $ultimoPost->slug);

        });

    }

    public function test_crear_post_validacion_errores_redirija_a_la_pagina_de_crear()
    {

        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);

        $admin = $this->user->assignRole($this->rolAdministrador->name);

        $post = [
            'nombre' => '',
        ];

        $response = $this->actingAs($admin)->post('/post', $post);

        $response->assertStatus(302);

        $response->assertSessionHasErrors(['nombre']); 
        $response->assertInvalid(['nombre']);

    }

    public function test_eliminar_post_con_exito()
    {

        Post::withoutEvents(function ()
        {

            $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);

            $admin = $this->user->assignRole($this->rolAdministrador->name);

            $post = Post::factory()->state(['creado_por' => $this->user->id])->create();

            $response = $this->actingAs($admin)->delete('post/' . $post->id);

            $this->assertDatabaseMissing('posts', ['id' => $post->toArray()]);

            $this->assertDatabaseCount('posts', 0);

        });

    }

}
