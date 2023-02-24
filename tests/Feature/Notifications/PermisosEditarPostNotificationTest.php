<?php

namespace Tests\Feature\Notifications;

use App\Models\PermisosEdicionPost;
use Illuminate\Foundation\Testing\RefreshDatabase;
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

    public function test_notificacion_email_lector_para_poder_editar_post_solicitado_mediante_un_token()
    {
        Notification::fake(); 

        Post::withoutEvents(function () {

            $post = Post::factory(1)
            ->state(['creado_por' => $this->user->id,])
            ->create()
            ->each(function($post) {
                $post->detalle()
                    ->create([
                        'post_id' => $post->id,
                        'solicitado_por' => $this->user->id,
                        'estado' => PermisosEdicionPost::ESTADO_APROBADO
                    ]);
            });

            // $this->assertTrue(true, $post->);

        });

    }

}
