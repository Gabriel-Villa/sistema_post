<?php

namespace Tests\Feature\Notifications;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Notification;

use App\Models\Post;
use App\Models\User;
use App\Notifications\ImagenesProcesadasEditorNotification;

class ImagenesProcesadasEditorNotificacionTest extends TestCase
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

    public function test_notificacion_email_editor_despues_de_procesar_imagenes_a_escala_grises_de_su_post()
    {
        
        Notification::fake(); 

        Post::withoutEvents(function () {

            $post = Post::factory()->state(['creado_por' => $this->user->id])->create();

            $this->user->notify(new ImagenesProcesadasEditorNotification($post));

            Notification::assertSentTo($this->user, ImagenesProcesadasEditorNotification::class, function ($notification, $channels) use($post)
            {
                $this->assertContains('mail', $channels);

                $contenido = $notification->toMail($this->user);

                $this->assertEquals('Imagenes Procesadas De Tu Post', $contenido->subject);
                $this->assertEquals('Se termino de procesar la subida y conversion de imagenes de tu post llamado : '. $post->nombre, $contenido->introLines[0]);
    
                return true;
            });

        });
    }

    public function test_notificacion_database_editor_despues_de_procesar_imagenes_a_escala_grises_de_su_post()
    {
        
        Notification::fake(); 

        Post::withoutEvents(function () {

            $post = Post::factory()->state(['creado_por' => $this->user->id])->create();

            $this->user->notify(new ImagenesProcesadasEditorNotification($post));

            Notification::assertSentTo($this->user, ImagenesProcesadasEditorNotification::class, function ($notification, $channels) use($post)
            {
                $this->assertContains('database', $channels);

                $contenido = $notification->toArray($this->user);

                $this->assertEquals('Conversion imagenes', $contenido['nombre']);
                $this->assertEquals('Se termino de procesar la subida y conversion de imagenes de tu post llamado : ' . $post->nombre, $contenido['contenido']);
    
                return true;
            });

        });
    }

}
