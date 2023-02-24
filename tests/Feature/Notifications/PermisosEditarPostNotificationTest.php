<?php

namespace Tests\Feature\Notifications;

use App\Models\PermisosEdicionPost;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Notification;
use Illuminate\Support\Str;

use App\Models\Post;
use App\Models\User;

class PermisosEditarPostNotificationTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = $this->crearUsuario();
    }

    private function crearUsuario(): User
    {
        return User::factory()->create();
    }

    public function test_crear_permiso_editar_post_aprobada_con_exito()
    {

        Post::withoutEvents(function () {

            Post::factory(1)
                ->state(['creado_por' => $this->user->id,])
                ->create()
                ->each(function($post) {
                    $post_permiso = $post->permiso()
                        ->create([
                            'post_id' => $post->id,
                            'solicitado_por' => $this->user->id,
                            'estado' => PermisosEdicionPost::ESTADO_APROBADO
                        ]);

                    $this->assertTrue($post_permiso->esta_aprobado());

                });
        });

    }

}
