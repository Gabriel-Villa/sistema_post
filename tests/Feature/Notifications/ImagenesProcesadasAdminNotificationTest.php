<?php

namespace Tests\Feature\Notifications;


use App\Notifications\ImagenesProcesadasAdminNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Notification;

use Spatie\Permission\Models\Role;
use App\Models\Post;
use App\Models\User;


class ImagenesProcesadasAdminNotificationTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Role $rolAdministrador;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = $this->crearUsuario();
        $this->rolAdministrador = $this->crearRolAdministrador();
    }

    private function crearUsuario(): User
    {
        return User::factory()->create();
    }

    private function crearRolAdministrador(): Role
    {
        return Role::create(['name' => 'Administrador']);
    }

    public function test_notificacion_email_usuarios_con_rol_admin_despues_de_procesar_imagenes_a_escala_grises()
    {
        
        Notification::fake(); 

        Post::withoutEvents(function () {

            $this->user->assignRole($this->rolAdministrador->name);

            $post = Post::factory()->state(['creado_por' => $this->user->id])->create();

            $this->user->notify(new ImagenesProcesadasAdminNotification($post));

            Notification::assertSentTo($this->user, ImagenesProcesadasAdminNotification::class, function ($notification, $channels) use($post)
            {
                $this->assertContains('mail', $channels);

                $contenido = $notification->toMail($this->user);

                $this->assertEquals('Imagenes Procesadas', $contenido->subject);
                $this->assertEquals('Se termino de procesar la subida y conversion de imagenes del post: ' . $post->nombre, $contenido->introLines[0]);
    
                return true;
            });

        });
    }

    public function test_notificacion_database_usuarios_con_rol_admin_despues_de_procesar_imagenes_a_escala_grises()
    {

        Notification::fake(); 

        Post::withoutEvents(function () {

            $this->user->assignRole($this->rolAdministrador->name);

            $post = Post::factory()->state(['creado_por' => $this->user->id])->create();

            $this->user->notify(new ImagenesProcesadasAdminNotification($post));

            Notification::assertSentTo($this->user, ImagenesProcesadasAdminNotification::class, function ($notification, $channels) use($post)
            {
                $this->assertContains('database', $channels);

                $contenido = $notification->toArray($this->user);

                $this->assertEquals('Conversion imagenes', $contenido['nombre']);
                $this->assertEquals('Se termino de procesar la subida y conversion de imagenes del post: ' . $post->nombre, $contenido['contenido']);
    
                return true;
            });

        });

    }
}
